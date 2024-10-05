<?php

namespace App\Providers;

use App\Observers\OrderObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Modules\Orders\Entities\Order;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Order::observe(OrderObserver::class);
        Paginator::defaultView('admin.includes.paginator');
//        Paginator::defaultView('front.vendor.pagination.bootstrap-4');

    }
}
