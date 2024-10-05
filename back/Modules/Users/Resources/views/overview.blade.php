@extends('front.layouts.user_panel')
@section('panel_content')

    <div class="box">
        {{-- info boxes --}}
        <div class="row mb-5">
            <div class="col-lg-3 mb-3 mb-lg-0">
                <div class="dashboard-box dashboard-box-primary">
                    <i class="icon-shopping-cart"></i>
                    <h5>{{$cartCount}} محصول</h5>
                    <span>در سبد خرید شما</span>
                </div>
            </div>
            <div class="col-lg-3 mb-3 mb-lg-0">
                <div class="dashboard-box dashboard-box-success">
                    <i class="icon-dollar-sign"></i>
                    <h5>{{number_format(auth()->user()->wallet->balance)}} تومان</h5>
                    <span>موجودی کیف پول شما</span>
                </div>
            </div>
            <div class="col-lg-3 mb-3 mb-lg-0">
                <div class="dashboard-box dashboard-box-danger">
                    <i class="icon-headphones"></i>
                    <h5>{{$ticketsCount}} تیکت</h5>
                    <span>درخواست های پشتیبانی</span>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="dashboard-box dashboard-box-warning">
                    <i class="icon-file-text"></i>
                    <h5>{{$ordersProductCount}} محصول</h5>
                    <span>شما سفارش داده اید</span>
                </div>
            </div>

        </div>

        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="font-18 fw-bold m-0">آخرین سفارشات</h5>
            <a href="{{route('order.index')}}" class="underline-link font-13">مشاهده همه <i class="icon-arrow-left"></i></a>
        </div>
        @if($orders->count() > 0)
            @foreach($orders as $order)
                @include('users::user_panel.order_table_row',$order)
            @endforeach
        @else
            <div class="alert alert-info">
                شما تاکنون هیچ سفارشی ثبت نکرده اید.
            </div>
        @endif

    </div>
@endsection
