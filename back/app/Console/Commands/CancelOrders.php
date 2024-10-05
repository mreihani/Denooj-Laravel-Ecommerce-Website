<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Orders\Entities\Order;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\ProductColor;
use Modules\Products\Entities\ProductInventory;
use Modules\Products\Entities\ProductSize;

class CancelOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel unpaid orders after 1 hour';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
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
            increaseOrderItemStock($order);
        }
    }
}
