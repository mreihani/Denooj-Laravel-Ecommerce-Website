<div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="fw-bold font-24 text-main m-0">بررسی نهایی و پرداخت</h1>
    <a href="{{route('cart')}}" class="btn btn-outline-secondary ml-3"><i
            class="icon-arrow-right me-1"></i>بازگشت</a>
</div>
@include('front.alerts')

@if(Session::has('wallet_error'))
    <div class="alert alert-danger">
        <p>مبلغ سفارش از موجودی کیف پول شما بیشتر است.
            <br>
            موجودی فعلی: <b>{{number_format(auth()->user()->wallet->balance) . ' تومان'}}</b>
        </p>
        <a href="{{route('panel.wallet')}}" class="kt-btn kt-btn-main md-ripples mt-3"><i
                class="icon-plus"></i>
            افزایش موجودی کیف پول</a>
    </div>
@endif

@if(Session::has('cart_delivery_error'))
    <div class="alert alert-danger">
        <p>{{session('cart_delivery_error')}}</p>
        <a href="{{route('cart')}}" class="kt-btn kt-btn-main md-ripples mt-2">ویرایش سبد خرید</a>
    </div>
@endif
