@extends('front.layouts.user_panel')
@section('panel_content')

    <div class="box">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="font-18 fw-bold mb-0">سفارشات من</h1>
        </div>

        @include('front.alerts')

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
