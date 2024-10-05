<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Orders\Entities\Order;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\ProductColor;
use Modules\Products\Entities\ProductInventory;
use Modules\Products\Entities\ProductSize;

class CancelNotPaidOrdersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $orders = Order::where('created_at', '<', Carbon::now()->subHours(1)->toDateTimeString())
            ->where('status', '!=', 'cancel')
            ->where('is_paid', false)->get();

        foreach ($orders as $order) {
            $order->status = 'cancel';
            $order->save();

            // decrease order items quantity
            foreach ($order->items as $item) {
                $product = Product::find($item->id);
                if ($product) {

                    if ($product->product_type == 'simple' && $product->manage_stock){
                        $product->update([
                            'stock' => $product->stock + $item->pivot->quantity
                        ]);

                    }else if($product->product_type == 'variation'){

                        if ($item->pivot->color && $item->pivot->size){
                            // color and size
                            $color = ProductColor::where('label',$item->pivot->color)->first();
                            $size = ProductSize::where('label',$item->pivot->size)->first();
                            $inventory = ProductInventory::where('product_id',$product->id)->where('color_id',$color->id)->where('size_id',$size->id)->first();
                        }else if($item->pivot->color && !$item->pivot->size){
                            // just color
                            $color = ProductColor::where('label',$item->pivot->color)->first();
                            $inventory = ProductInventory::where('product_id',$product->id)->where('color_id',$color->id)->first();
                        }else if(!$item->pivot->color && $item->pivot->size){
                            // just color
                            $size = ProductSize::where('label',$item->pivot->size)->first();
                            $inventory = ProductInventory::where('product_id',$product->id)->where('size_id',$size->id)->first();
                        }

                        if (isset($inventory) && !empty($inventory) && $inventory->manage_stock){
                            $inventory->update([
                                'stock' => $inventory->stock + $item->pivot->quantity
                            ]);
                        }
                    }
                }
            }

        }
    }
}
