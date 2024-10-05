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
use Modules\Products\Entities\ProductSize;
use Modules\Products\Entities\ProductColor;
use Modules\Products\Entities\ProductInventory;

class OrdersController extends Controller
{

    public function __construct()
    {
        $this->middleware(['can:see-orders'])->only(['index','trash','search','searchTrash','factor','filter']);
        $this->middleware(['can:delete-orders'])->only(['destroy','ajaxDelete']);
        $this->middleware(['can:edit-orders'])->only(['edit','update','editShipping','updateShipping']);
    }

    public function index()
    {
        $orders = Order::latest()->paginate(20);
        return view('orders::admin.index',compact('orders'));
    }

    public function trash()
    {
        $orders = Order::onlyTrashed()->paginate(20);
        return view('orders::admin.trash', compact('orders'));
    }

    public function factor(Order $order){
        if (!$order->is_paid){
            return abort(403);
        }
        return view('orders::factor',compact('order'));
    }

    public function label(Order $order){
        return view('orders::label',compact('order'));
    }

    public function edit(Order $order)
    {
        return view('orders::admin.edit',compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required',
            'postal_code' => 'string|max:255|nullable'
        ]);
        $inputs = $request->all();

        // send sms notification to customer
        if ($order->status != 'completed' && $order->completed == null && $request->status == 'completed'){
            $inputs['completed_at'] = Carbon::now();
            if (allow_user_order_completed_sms()){
                SendSmsOrderCompletedJob::dispatch($order->user->mobile,$order->order_number);
            }
        }

        if ($request->is_paid == 'yes'){
            $inputs['is_paid'] = true;
        }else{
            $inputs['is_paid'] = false;
        }

        // check for postal_code
        if (!empty($request->postal_code) && $order->sent_at == null){
            $inputs['sent_at'] = Carbon::now();
            $inputs['status'] = 'sent';
            if (allow_user_order_sent_sms()){
                SendSmsOrderSentJob::dispatch($order->user->mobile,"$request->postal_code");
            }
        }

        $order->update($inputs);
        session()->flash('success','سفارش با موفقیت بروزرسانی شد.');
        return redirect(route('orders.edit',$order));
    }

    public function editShipping(Order $order)
    {
        return view('orders::admin.edit_shipping',compact('order'));
    }

    public function updateShipping(Request $request, Order $order)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'shipping_province' => 'required|string|max:255',
            'shipping_city' => 'required',
            'shipping_post_code'=> 'required|string|max:255',
            'shipping_phone'=> 'required|string|max:255',
            'shipping_full_name'=> 'required|string|max:255',
        ]);
        $inputs = $request->all();
        $order->update($inputs);
        session()->flash('success','آدرس سفارش با موفقیت بروزرسانی شد.');
        return redirect(route('orders.edit',$order));
    }

    public function destroy(Order $order)
    {
        $name = $order->order_number;
        try {
            $order->items()->sync([]);
            $order->payments()->delete();
            $deleted = $order->delete();
            if ($deleted){
                session()->flash('success','سفارش شماره '.$name.' با موفقیت حذف شد');
            }
        }catch (\Exception $e){
            session()->flash('error',$e->getMessage());
        }
        return redirect()->back();
    }

    public function ajaxDelete(Request $request){
        try {
            $order = Order::where('id',$request->id)->first();
            $order->items()->sync([]);
            $order->payments()->delete();
            $deleted = $order->delete();
            if ($deleted){
                session()->flash('success','سفارش با موفقیت حذف شد');
                return "success";
            }
        }catch (\Exception $e){
            return $e;
        }
        return "couldn't delete order";
    }

    public function search()
    {
        $query = request('query');
        $orders = Order::whereHas('user', function ($q) use ($query) {
                $q->where('first_name', 'like', "%{$query}%");
            })
            ->orWhereHas('user', function ($q) use ($query) {
                $q->where('last_name', 'like', "%{$query}%");
            })
            ->orWhereHas('user', function ($q) use ($query) {
                $q->where('mobile', 'like', "%{$query}%");
            })
            ->orWhere('order_number', 'LIKE', '%' . $query . '%')
            ->paginate(20);
        return view('orders::admin.index', compact('orders', 'query'));
    }

    public function searchTrash()
    {
        $query = request('query');
        $orders = Order::onlyTrashed()->whereHas('user', function ($q) use ($query) {
            $q->where('first_name', 'like', "%{$query}%");
        })
            ->orWhereHas('user', function ($q) use ($query) {
                $q->where('last_name', 'like', "%{$query}%");
            })
            ->orWhere('order_number', 'LIKE', '%' . $query . '%')
            ->paginate(20);
        return view('orders::admin.trash', compact('orders', 'query'));
    }

    // denooj.com filters
    public function filter(Request $request) {

        $inputs = $request->input();

        $query = $this->filterQueryHandler($request);
        
        $orders = $query->paginate(20)->appends($request->except('page'));

        return view('orders::admin.index',compact('orders','inputs'));
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

}
