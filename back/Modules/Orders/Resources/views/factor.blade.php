@extends('front.layouts.master',['hideHeader' => true,'hideFooter' => true])
@php $factorSettings = \Modules\Settings\Entities\FactorSetting::first(); @endphp
@section('content')
    <div class="container-fluid page-content">
        <div class="custom-container">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <button class="btn btn-primary btn-print" data-print-id="print">پرینت / دانلود</button>
                <a href="{{url()->previous()}}" class="underline-link">بازگشت <i class="icon-arrow-left"></i></a>
            </div>

            {{-- factor: print area --}}
            <div id="print" class="dir-rtl">
                <table class="table table-borderless border">
                    <tbody>
                    <tr>
                        <td>
                            <img src="{{$factorSettings->getLogo()}}" alt="logo" style="width: 200px;height: auto">
                        </td>
                        <td>
                            <h4 class="mb-4">{{config('app.app_name_fa')}}</h4>
                            <span>فاکتور فروش</span>
                        </td>
                        <td>
                            <span class="d-block mb-2 mt-2">تاریخ: <span
                                        class="d-inline-block">{{verta($order->created_at)->format('%Y/%m/%d')}}</span></span>
                            <span class="d-block mb-2">شماره فاکتور: <span
                                        class="d-inline-block">{{$order->order_number}}</span></span>
                            <span class="d-block mb-2">تلفن فروشگاه: <span
                                        class="d-inline-block">{{$factorSettings->phone}}</span></span>
                        </td>
                    </tr>
                    @if($factorSettings->address || $factorSettings->postcode)
                        <tr>
                            <td colspan="3" class="text-center">
                                @if($factorSettings->address)
                                    <span class="d-block">آدرس: <span
                                                class="d-inline-block">{{$factorSettings->address}}</span></span>
                                @endif
                                @if($factorSettings->postcode)
                                    <span class="d-block">کدپستی: <span
                                                class="d-inline-block">{{$factorSettings->postcode}}</span></span>
                                @endif
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <table class="table table-bordered">
                    <tbody>
                    <tr class="table-secondary">
                        <td colspan="3">مشخصات خریدار / مشتری</td>
                    </tr>
                    <tr>
                        <td>خریدار: {{$order->user->getFullName()}}</td>
                        <td>شماره تلفن: {{$order->user->mobile}}</td>
                        <td>کد ملی: {{$order->user->national_code}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">آدرس: {{$order->getProvinceName() . '، ' . $order->getCityName() . '، ' . $order->shipping_address}}</td>
                        <td>کد پستی: {{$order->shipping_post_code}}</td>
                    </tr>
                    </tbody>
                </table>

                <table class="table table-bordered mb-0">
                    <tbody>
                    <tr class="table-secondary">
                        <th>ردیف</th>
                        <th>نام کالا</th>
                        <th>تعداد</th>
                        <th>مبلغ واحد (ریال)</th>
                        <th>مبلغ کل (ریال)</th>
                    </tr>
                    @foreach($order->items as $i => $orderItem)
                        <tr>
                            <td>{{++$i}}</td>
                            <td class="text-start">{{$orderItem->title}}
                                {{-- display color and size --}}
                                @if($orderItem->pivot->color)
                                    <span class="d-block font-13 mt-2">رنگ: {{$orderItem->pivot->color}}</span>
                                @endif
                                @if($orderItem->pivot->size)
                                    <span class="d-block font-13 mt-2">سایز: {{$orderItem->pivot->size}}</span>
                                @endif
                            </td>
                            <td class="align-middle" style="min-width: 55px;">
                                {{$orderItem->pivot->quantity}}
                            </td>
                            <td class="align-middle">
                                <p class="m-0">{{number_format(intval($orderItem->pivot->price) * 10)}}</p>
                            </td>
                            <td class="align-middle">
                                <p class="m-0">{{number_format(intval($orderItem->pivot->quantity) * (intval($orderItem->pivot->price) * 10))}}</p>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="text-start">
                            <span class="text-start">مبلغ کل سفارش: </span>
                        </td>
                        <td colspan="2" class="text-end">
                            <span>{{number_format(intval($order->price) * 10) . ' ریال'}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-start">
                            <span class="text-start">مجموع تخفیف محصولات: </span>
                        </td>
                        <td colspan="2" class="text-end">
                            <span>{{number_format(intval($order->items_discount) * 10) . ' ریال'}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-start">
                            <span class="text-start">تخفیف اعمال شد: </span>
                        </td>
                        <td colspan="2" class="text-end">
                            <span>{{number_format(intval($order->discount) * 10) . ' ریال'}}</span>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3" class="text-start">
                            <span class="text-start">هزینه ارسال: </span>
                        </td>
                        <td colspan="2" class="text-end">
                            <span>{{number_format(intval($order->shipping_cost) * 10) . ' ریال'}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-start">
                            <span class="text-start">مبلغ پرداخت شده: </span>
                        </td>
                        <td colspan="2" class="text-end">
                            <span>{{number_format(intval($order->paid_price) * 10) . ' ریال'}}</span>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="table table-borderless border">
                    <tbody>
                    <tr>
                        <td class="py-4" colspan="1">
                            <span class="d-block mb-2">مهر و امضای فروشنده:</span>
                            <img src="{{$factorSettings->getSignature()}}" alt="logo" style="width: 200px;height: auto">
                        </td>
                        <td class="py-4" colspan="1">
                            <span class="d-block mb-2">مهر و امضای خریدار:</span>

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
