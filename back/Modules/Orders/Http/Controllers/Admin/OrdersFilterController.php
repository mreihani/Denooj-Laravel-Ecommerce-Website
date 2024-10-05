<?php

namespace Modules\Orders\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use App\Jobs\SendSmsOrderSentJob;
use Modules\Orders\Entities\Order;
use App\Http\Controllers\Controller;
use App\Jobs\SendSmsOrderCompletedJob;
use Modules\Products\Entities\Product;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Modules\Products\Entities\ProductSize;
use Modules\Products\Entities\ProductColor;
use Modules\Products\Entities\ProductInventory;

class OrdersFilterController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:see-orders'])->only(['filter', 'exportExcel']);
        $this->middleware(['can:edit-orders'])->only(['changeOrderStatus']);
    }

    private function filterQueryHandler($request) {

        $shippingPhone = trim($request->shipping_phone);
        $orderNumber = trim($request->order_number);
        $discountCondition = trim($request->is_discount) === 'normal' ? '==' : (trim($request->is_discount) === 'coupon' ? '!=' : 0);
        $status = trim($request->status);
        $isPaid = trim($request->is_paid);
        $shippingMethod = trim($request->shipping_method);
        $dateOrder = trim($request->date_order);
        $startDate = !empty($request->start_date) ? Jalalian::fromFormat('Y/m/d H:i', trim($request->start_date))->toCarbon() : ''; 
        $endDate = !empty($request->end_date) ? Jalalian::fromFormat('Y/m/d H:i', trim($request->end_date))->toCarbon() : ''; 
        
        // avoid admin to input invalid dates
        if(!empty($startDate) && !empty($endDate) && $startDate > $endDate) {
            session()->flash('error','تاریخ شروع نمی تواند بزرگتر از تاریخ پایان باشد!');
            return redirect()->back();
        }

        $query = Order::query()
        ->when($shippingPhone, function ($query) use ($shippingPhone) {
            $query->where('shipping_phone', $shippingPhone);
        })
        ->when($orderNumber, function ($query) use ($orderNumber) {
            $query->where('order_number', $orderNumber);
        })
        ->when($discountCondition, function ($query) use ($discountCondition) {
            $query->where('discount', $discountCondition, 0);
        })
        ->when($status, function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->when($isPaid, function ($query) use ($request) {
            $query->where('is_paid', $request->is_paid === 'paid' ? 1 : 0);
        })
        ->when($shippingMethod, function ($query) use ($shippingMethod) {
            $query->where('shipping_method', $shippingMethod);
        })
        ->when($startDate, function ($query) use ($startDate) {
            $query->where('created_at', '>=', $startDate);
        })
        ->when($endDate, function ($query) use ($endDate) {
            $query->where('created_at', '<=', $endDate);
        })
        ->when($dateOrder, function ($query) use ($dateOrder) {
            $query->orderBy('created_at', $dateOrder);
        });

        return $query;
    }

    public function filter(Request $request) {

        $inputs = $request->input();

        $query = $this->filterQueryHandler($request);
        
        $orders = $query->paginate(20)->appends($request->except('page'));

        return view('orders::admin.index',compact('orders','inputs'));
    }

    public function exportExcel(Request $request) {
        
        $query = $this->filterQueryHandler($request);

        $orders = $query->get();
        
        // Create a new Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle('لیست سفارشات برنج دنوج');
        
        // Set the default column width for all columns
        $sheet->getDefaultColumnDimension()->setWidth(25);

        // Set the sheet direction to right-to-left
        $sheet->setRightToLeft(true);

        // Set a wider width for the 'آدرس بازدید' column
        $sheet->getColumnDimension('F')->setWidth(50); // Adjust the width as needed

        // Set headers for the Excel file
        $headers = [
            'ردیف',
            'شماره سفارش',
            'نام و نام خانوادگی تحویل گیرنده',
            'شماره تلفن تحویل گیرنده',
            'استان',
            'شهر',
            'آدرس',
            'وزن کل',
            'روش حمل',
            'کد پستی',
            'تاریخ ثبت سفارش',
            'مبلغ سفارش',
            'وضعیت جشنواره',
            'برنجی',
            'غیر برنجی'
        ];

        // Set the headers in the first row of the Excel file
        $sheet->fromArray([$headers], NULL, 'A1');

        // Populate the Excel file with Order data
        $rowData = [];

        foreach ($orders as $key => $order) {

            if($order->shipping_method === 'freightage') {
                $shipping_method = 'باربری';
            } else {
                $shipping_method = 'پست';
            }

            if($order->discount != 0) {
                $is_coupon = 'جشنواره';
            } else {
                $is_coupon = 'عادی';
            }

            // ایجاد لیستی از محصولات برنجی و غیر برنجی
            $rice = '';
            $nonRice = '';
            $totalWeight = 0;

            if($order->items->count()) {
                foreach ($order->items as $productKey => $productItem) {

                    if($productKey == 0) {
                        $seperator = "";
                    } else {
                        $seperator = " | ";
                    }

                    $categories = $productItem->categories->pluck('id')->toArray();
                    if(in_array(443, $categories)) {
                        $nonRice .= $seperator . $productItem->title . " " . $productItem->pivot->quantity . " بسته ";
                    } else {
                        $rice .= $seperator . $productItem->title . " " . $productItem->pivot->quantity * $productItem->weight / 1000 . "KG";
                        $totalWeight += $productItem->pivot->quantity * $productItem->weight / 1000;
                    }   
                }
            } 

            $rowData[] = [
                $key + 1,
                $order->order_number,
                $order->shipping_full_name,
                $order->shipping_phone,
                $order->getProvinceName(),
                $order->getCityName(),
                $order->shipping_address,
                $totalWeight . ' کیلو' . ' | ' . ceil($totalWeight/40) . 'گونی',
                $shipping_method,
                $order->shipping_post_code,
                verta($order->created_at)->format('%d %B، %Y'),
                number_format($order->getTotalPrice()) . ' تومان',
                $is_coupon,
                $rice,
                $nonRice
            ];
        }

        // Add data to the Excel file starting from the second row
        $sheet->fromArray($rowData, NULL, 'A2');
    
        // Save the Excel file
        $writer = new Xlsx($spreadsheet);
        $fileName = hexdec(uniqid()) . '.xlsx';
       
        $filePath = storage_path('app/public/admins/' . $fileName);
        $writer->save($filePath);
      
        // Download the Excel file
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function changeOrderStatus(Request $request) {

        // avoid admin to change all orders without filtering them!
        if(empty($request->except('_token'))) {
            session()->flash('error','لطفا ابتدا سفارشات را فیلتر کنید!');
            return redirect()->back();
        } elseif(!empty($request->except('_token')) && !isset($request->status_handler)) {
            session()->flash('error','لطفا وضعیت مورد نظر را انتخاب کنید!');
            return redirect()->back();
        } 

        $inputs = $request->input();

        $query = $this->filterQueryHandler($request);

        $ordersLoop = $query->get();

        foreach ($ordersLoop as $order) {
            $order->update([
                'status' => $inputs['status_handler']
            ]);
        }

        $orders = $query->paginate(20)->appends($request->except('page'));

        return view('orders::admin.index',compact('orders','inputs'));
    }
}
