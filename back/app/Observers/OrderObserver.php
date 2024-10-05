<?php

namespace App\Observers;

use Modules\Orders\Entities\Order;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param  \Modules\Orders\Entities\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        //
    }

    /**
     * Handle the Order "updating" event.
     *
     * @param  \Modules\Orders\Entities\Order  $order
     * @return void
     */
    public function updating(Order $order)
    {
        if ($order->isDirty('status')) {
            if ($order->status == 'cancel') {
                // decrease order items quantity
                increaseOrderItemStock($order);
            }
        }
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \Modules\Orders\Entities\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \Modules\Orders\Entities\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \Modules\Orders\Entities\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
