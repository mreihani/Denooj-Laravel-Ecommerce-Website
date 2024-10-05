@extends('front.layouts.master')
@section('content')
    <div class="container-fluid page-content mt-5">
        <div class="custom-container">

            <div class="row">
                <div class="col-3"></div>
                <div class="col-lg-6 mb-4">
                    <div class="box">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h1 class="section-title font-18 fw-bold mb-0">انتخاب روش ارسال</h1>
                            <a href="{{route('cart.address')}}" class="underline-link">بازگشت <i class="icon-chevron-left ml-1"></i></a>
                        </div>

                        <form action="{{route('cart.shipping.set')}}" method="post" id="myForm">
                            <input type="hidden" id="address_id" name="address_id" value="{{session('address_id')}}">
                            @csrf
                            <div class="row">
                                @if($shippingSettings->post_pishtaz)
                                    <div class="col-lg-6 mb-3">
                                        <label class="aiz-megabox d-block">
                                            <input type="radio" name="shipping_method" value="post_pishtaz" required>
                                            <span class="d-flex p-3 aiz-megabox-elem d-flex align-items-center">
                                                <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                <span class="d-flex align-items-center">
                                                    <img src="{{asset('assets/images/post_pishtaz.png')}}" alt="pishtaz" class="me-2" style="height: 50px; width: auto;max-width: 100%">
                                                    <span class="d-block fw-bold">ارسال با پست پیشتاز</span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                @endif

                                @if($shippingSettings->bike)
                                    <div class="col-lg-6 mb-3">
                                        <label class="aiz-megabox d-block">
                                            <input type="radio" name="shipping_method" value="bike" required>
                                            <span class="d-flex p-3 aiz-megabox-elem d-flex align-items-center">
                                                <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                <span class="d-flex align-items-center">
                                                    <img src="{{asset('assets/images/bike.jpg')}}" alt="bike" class="me-2" style="height: 50px; width: auto;max-width: 100%">
                                                    <span class="d-block fw-bold">ارسال با پیک</span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                @endif

                                @if($shippingSettings->tipax)
                                    <div class="col-lg-6 mb-3">
                                        <label class="aiz-megabox d-block">
                                            <input type="radio" name="shipping_method" value="tipax" required>
                                            <span class="d-flex p-3 aiz-megabox-elem d-flex align-items-center">
                                                <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                <span class="d-flex align-items-center">
                                                    <img src="{{asset('assets/images/tipax.png')}}" alt="pishtaz" class="me-2" style="height: 50px; width: auto;max-width: 100%">
                                                    <span class="d-block fw-bold">ارسال با تیپاکس</span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                @endif

                                <div class="col-12 text-center mt-3" id="shipping_cost_container">هزینه ارسال:
                                    <span class="font-18 fw-bold" id="shipping_cost">وابسته به روش ارسال</span>
                                </div>

                                @if($shippingSettings->tipax || $shippingSettings->post_pishtaz)
                                <div class="col-12 mt-3">
                                    <span type="submit" id="btnSubmit" class="btn btn-success w-100 text-center p-3"><span>مرحله بعد</span><i class="icon-arrow-left ms-3"></i></span>
                                </div>
                                @endif
                            </div>
                        </form>


                        @if(!$shippingSettings->tipax && !$shippingSettings->post_pishtaz)
                            <div class="alert alert-danger mt-4">
                                هیچ روش ارسال وجود ندارد! لطفا با پشتیبانی تماس بگیرید.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{asset('assets/js/jquery.validate.js')}}"></script>
    <script src="{{asset('assets/js/panel.js')}}"></script>
    <script>
        $("#btnSubmit").on('click',function (e){
            e.preventDefault();
            let btn = $(this);
            if($('input[name=shipping_method]:checked').val() === undefined){
                Toast.fire({
                    icon:"warning",
                    text: "ابتدا روش ارسال را مشخص کنید."
                });
            }else{
                btn.addClass('loading');
                btn.parents('form').submit();
            }
        });

        $(document).on('change','input[name=shipping_method]',function (){
            getShippingCost($(this).val());
        });

        function getShippingCost(shippingMethod){
            let data = new FormData();
            data.append('shipping_method', shippingMethod);
            let container = $('#shipping_cost_container');
            container.addClass('opacity-25');

            $.ajax({
                method: 'POST',
                url: '/panel/cart/get-shipping-cost/',
                data: data,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': _token},
                error: function () {
                    container.removeClass('opacity-25');
                    Toast.fire({
                        icon: 'error',
                        title: 'مشکلی پیش آمد، عملیات انجام نشد!'
                    })
                }
            }).done(function (data) {
                $('#shipping_cost').html(data);
            }).always(function () {
                container.removeClass('opacity-25');
            });
        }

    </script>
@endsection
