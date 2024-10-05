@extends('front.layouts.master')
@section('content')
    <div class="container-fluid page-content mt-5">
        <div class="custom-container">
            <form action="{{route('order.store')}}" method="post" id="checkoutForm" enctype="multipart/form-data">
                @csrf

                @include('shoppingcart::checkout.before_checkout_fields')

                <div class="row mb-5">
                    <div class="col-lg-8">
                        
                        @include('shoppingcart::cart.cart-controlpanel')

                        {{-- choose address --}}
                        @include('shoppingcart::checkout.checkout_address_box')

                        {{-- items --}}
                        @include('shoppingcart::checkout.checkout_order_items')

                        {{-- notes --}}
                        <div class="box p-3 mb-3">
                            <div class="section-title font-17 fw-bold mb-4 d-flex align-items-center">
                                <i class="icon-edit-2 me-2 mb-1 text-muted"></i>
                                <span>یادداشت</span>
                            </div>

                            <small class="d-block text-muted mb-3">در صورت تمایل میتوانید توضیحاتی برای فروشنده
                                بنویسید.</small>
                            <textarea class="form-control flat-input" name="notes" id="notes" aria-label="notes"
                                      rows="2" placeholder="توضیحات خود را وارد کنید...">{{old('notes')}}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-4">

                        {{-- factor --}}
                        @include('shoppingcart::checkout.checkout_factor')

                        {{-- payment methods --}}
                        @include('shoppingcart::checkout.checkout_payment_method')
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('users::user_panel.add_address_modal')

@endsection
@section('scripts')
    <script src="{{asset('assets/js/checkout.js')}}"></script>
@endsection
