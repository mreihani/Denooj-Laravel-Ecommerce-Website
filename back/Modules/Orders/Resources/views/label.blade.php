@extends('front.layouts.master',['hideHeader' => true,'hideFooter' => true])
@php $factorSettings = \Modules\Settings\Entities\FactorSetting::first(); @endphp
@php $shippingSettings = \Modules\Settings\Entities\ShippingSettings::first(); @endphp
@section('content')
    <div class="container-fluid page-content">
        <div class="custom-container">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <button class="btn btn-primary btn-print" data-print-id="print">پرینت / دانلود</button>
                <a href="{{url()->previous()}}" class="underline-link">بازگشت <i class="icon-arrow-left"></i></a>
            </div>

            {{-- label: print area --}}
            <div id="print" class="dir-rtl">
                <table class="table border">
                    <tbody>
                    <tr>
                        <td class="text-start p-3">
                            <div class="mb-3" style="font-size: 18px; font-weight: bold">فرستنده: {{config('app.app_name_fa')}}</div>
                            آدرس: {{$factorSettings->address}}
                            <div class="d-flex mt-3 w-100">
                                <span>کدپستی: {{$factorSettings->postcode}}</span>
                                <span class="ms-4">تلفن: {{$factorSettings->phone}}</span>
                            </div>
                        </td>

                        <td class="text-end p-3">
                            <img src="{{$factorSettings->getLogo()}}" alt="logo" style="width: 120px;height: auto">
                            <div class="font-14 mt-2">
                                <span>روش ارسال: </span>
                                @switch($order->shipping_method)
                                    @case('post_pishtaz')
                                        <span>{{$shippingSettings->post_pishtaz_title}}</span>
                                        @break
                                    @case('bike')
                                        <span>{{$shippingSettings->bike_title}}</span>
                                        @break
                                    @case('tipax')
                                        <span>{{$shippingSettings->tipax_title}}</span>
                                        @break
                                @endswitch
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start p-3" colspan="2">
                            <div class="mb-3" style="font-size: 18px; font-weight: bold">خریدار: {{$order->shipping_full_name}}</div>
                            آدرس: {{$order->getProvinceName() . '، ' . $order->getCityName() . '، ' . $order->shipping_address}}
                            <div class="d-flex mt-3 w-100">
                                <span>کدپستی: {{$order->shipping_post_code}}</span>
                                <span class="ms-4">تلفن: {{$order->shipping_phone}}</span>
                            </div>
                        </td>
                    </tr>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('assets/js/printThis.js')}}"></script>
    <script>
        $(document).on('click', '.btn-print', function () {
            let id = $(this).attr('data-print-id');
            $('#' + id).printThis();
        });
    </script>
@endsection
