@extends('front.layouts.user_panel')
@php $paymentSettings = \Modules\Settings\Entities\PaymentSetting::first(); @endphp
@php $factorSettings = \Modules\Settings\Entities\FactorSetting::first(); @endphp
@section('panel_content')

    <div class="box mb-3">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-3">
            <div class="">
                <h1 class="font-18 fw-bold mb-0">جزئیات سفارش {{$order->order_number}}</h1>
                <small class="d-block mb-4">ثبت شده در {{verta($order->created_at)->format('%d %B، %Y ساعت H:i')}}</small>
            </div>

            @if($order->is_paid && $factorSettings->show_user_factor)
                <div class="text-end">
                    <a href="{{route('order.factor',$order)}}" class="btn btn-primary"><i
                            class="icon-file-text me-2"></i><span>مشاهده فاکتور</span></a>
                </div>
            @endif
        </div>

        @include('front.alerts')

        @switch($order->status)
            @case('pending_payment')
                <div class="alert alert-danger mb-0">
                    این سفارش پرداخت نشده است. سفارشات پرداخت نشده بعد از یک ساعت به صورت خودکار لغو میشوند.
                </div>
                @if(!$order->is_paid)
                    <form action="{{route('order.repay',$order)}}" method="post">
                        @csrf
                        <div class="row my-3">
                            <div class="col-lg-4">
                                <select name="payment_method" class="form-select" id="payment_method">
                                    @if($paymentSettings->zarinpal)
                                        <option value="zarinpal" {{$order->payment_method == 'zarinpal' ? 'selected' : ''}}>
                                            زرین پال (Zarinpal)
                                        </option>
                                    @endif
                                    @if($paymentSettings->zibal)
                                        <option value="zibal" {{$order->payment_method == 'zibal' ? 'selected' : ''}}>
                                            زیبال (Zibal)
                                        </option>
                                    @endif
                                    @if($paymentSettings->nextpay)
                                        <option value="nextpay" {{$order->payment_method == 'nextpay' ? 'selected' : ''}}>
                                            نکست پی (Nextpay)
                                        </option>
                                    @endif
                                    @if($paymentSettings->idpay)
                                        <option value="idpay" {{$order->payment_method == 'idpay' ? 'selected' : ''}}>
                                            آی‌دی‌پی (IDPay)
                                        </option>
                                    @endif
                                    @if($paymentSettings->mellat)
                                        <option value="behpardakht" {{$order->payment_method == 'mellat' ? 'selected' : ''}}>
                                            به پرداخت ملت (Mellat)
                                        </option>
                                    @endif
                                    @if($paymentSettings->parsian)
                                        <option value="parsian" {{$order->payment_method == 'parsian' ? 'selected' : ''}}>
                                            پارسیان (Parsian)
                                        </option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-lg-8">
                                <button type="submit" class="btn btn-success w-100">پرداخت سفارش <i
                                            class="icon-arrow-left"></i></button>
                            </div>
                        </div>

                    </form>
                @endif
                @break
            @case('ongoing')
                <div class="alert alert-warning mb-0">
                    این سفارش پرداخت شده و هم اکنون در مرحله پردازش و ارسال توسط فروشنده است.
                </div>
                @break
            @case('sent')
                <div class="alert alert-warning mb-0">
                    سفارش ارسال شده است (تحویل به شرکت حمل و نقل)
                </div>
                @break
            @case('completed')
                <div class="alert alert-success mb-0">
                    این سفارش تکمیل شده و به دست مشتری رسیده است.
                </div>
                @break
            @case('cancel')
                <div class="alert alert-secondary mb-0">
                    این سفارش لغو شده است.
                </div>
                @break
        @endswitch


        @if($order->postal_code)
            <div class="border rounded-1 p-3 mt-2">
                
                @if($order->shipping_method == 'post_pishtaz')
                    <a href="https://tracking.post.ir?id={{$order->postal_code}}" target="_blank" class="btn btn-secondary mt-3 font-13"><i class="icon-truck me-2"></i><span>رهگیری مرسوله در سامانه پست</span></a>
                @elseif($order->shipping_method == 'tipax')
                    <a href="https://tipaxco.com/tracking?id={{$order->postal_code}}" target="_blank" class="btn btn-secondary mt-3 font-13"><i class="icon-truck me-2"></i><span>رهگیری مرسوله در سایت تیپاکس</span></a>
                @elseif($order->shipping_method == 'freightage')
                    <div class="d-flex align-items-center flex-wrap">
                        کد رهگیری باربری: <b class="d-block mt-2 ms-lg-auto mt-lg-0">{{$order->postal_code}}</b>
                    </div>
                    <!-- <a href="#" target="_blank" class="btn btn-secondary mt-3 font-13">
                        <i class="icon-truck me-2"></i>
                        <span>رهگیری مرسوله باربری</span>
                    </a> -->
                @elseif($order->shipping_method == 'post')
                    <div class="d-flex align-items-center flex-wrap">
                        کد رهگیری مرسوله پستی: <b class="d-block mt-2 ms-lg-auto mt-lg-0">{{$order->postal_code}}</b>
                    </div>
                    <!-- <a href="#" target="_blank" class="btn btn-secondary mt-3 font-13">
                        <i class="icon-truck me-2"></i>
                        <span>رهگیری مرسوله پست</span>
                    </a> -->
                @endif
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="box mb-3">
                <span class="form-title font-15 mb-3 d-block mt-3 mt-lg-0">اقلام سفارش</span>

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>کالا</th>
                        <th>مبلغ</th>
                        <th>تعداد</th>
                        <th>مبلغ کل</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($order->items as $product)
                        <tr>
                            <td class="text-start">
                                <img src="{{$product->getImage('thumb')}}" alt="image" width="60" class="rounded mb-2">
                                <h6 class="font-13">{{$product->title}}</h6>

                                {{-- display color and size --}}
                                @if($product->pivot->color)
                                    <span class="d-block font-13 mt-2">رنگ: {{$product->pivot->color}}</span>
                                @endif
                                @if($product->pivot->size)
                                    <span class="d-block font-13 mt-2">سایز: {{$product->pivot->size}}</span>
                                @endif

                                <a href="{{route('product.show',$product)}}" class="underline-link font-12 mb-2">مشاهده
                                    محصول</a>
                            </td>
                            <td class="font-13">{{number_format($product->pivot->price) . ' تومان'}}</td>
                            <td class="font-13">{{$product->pivot->quantity}}</td>
                            <td class="font-13">{{number_format(intval($product->pivot->price) * intval($product->pivot->quantity)) . ' تومان'}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>


                <div class="list-group">
                    <div class="list-group-item d-flex align-items-center justify-content-between">
                        <span class="font-14 text-muted">جمع مبلغ محصولات:</span>
                        <span>{{number_format($order->getTotalItemsPrice()) . ' تومان'}}</span>
                    </div>
                    @if(intval($order->items_discount) > 0)
                        <div class="list-group-item d-flex align-items-center justify-content-between">
                            <span class="font-14 text-muted">جمع تخفیف محصولات:</span>
                            <span>{{number_format($order->items_discount) . ' تومان'}}</span>
                        </div>
                    @endif
                    @if(intval($order->discount) > 0)
                        <div class="list-group-item d-flex align-items-center justify-content-between">
                            <span class="font-14 text-muted">تخفیف اعمال شده:</span>
                            <span>{{number_format($order->discount) . ' تومان'}}</span>
                        </div>
                    @endif
                    <div class="list-group-item d-flex align-items-center justify-content-between">
                        <span class="font-14 text-muted">هزینه ارسال:</span>
                        <span>{{number_format($order->shipping_cost) . ' تومان'}}</span>
                    </div>
                    <div class="list-group-item d-flex align-items-center justify-content-between">
                        <span class="font-14 text-muted">مبلغ کل سفارش:</span>
                        <span>{{number_format($order->price) . ' تومان'}}</span>
                    </div>
                    <div class="list-group-item d-flex align-items-center justify-content-between list-group-item-success">
                        <span class="font-14 text-muted">مبلغ {{$order->is_paid ? 'پرداخت شده':'قابل پرداخت'}}:</span>
                        <span>{{number_format($order->paid_price) . ' تومان'}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="box mb-3">
                <span class="form-title font-15 mb-3 d-block mt-3 mt-lg-0">اطلاعات حمل و نقل</span>
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="font-14 text-muted">نام خریدار:</span>
                        <span>{{$order->shipping_full_name}}</span>
                    </li>
                    <li class="list-group-item">
                        <span class="font-14 text-muted">آدرس:</span>
                        <span>{{$order->getProvinceName() . '، ' . $order->getCityName() . '، ' . $order->shipping_address}}</span>
                    </li>
                    <li class="list-group-item">
                        <span class="font-14 text-muted">کد پستی:</span>
                        <span>{{$order->shipping_post_code}}</span>
                    </li>
                    <li class="list-group-item">
                        <span class="font-14 text-muted">شماره تماس:</span>
                        <span>{{$order->shipping_phone}}</span>
                    </li>
                    <li class="list-group-item">
                        <span class="font-14 text-muted">روش ارسال:</span>
                        @php $shippingMethod = $order->shipping_method;
                        if ($order->shipping_method == 'post_pishtaz'){
                            $shippingMethod = $shippingSettings->post_pishtaz_title ?? 'پست پیشتاز';
                        }elseif ($order->shipping_method == 'bike'){
                            $shippingMethod = $shippingSettings->bike_title ?? 'پیک موتوری';
                        }elseif ($order->shipping_method == 'tipax'){
                            $shippingMethod = $shippingSettings->tipax_title ?? 'پس کرایه';
                        } elseif ($order->shipping_method == 'post'){
                            $shippingMethod = $shippingSettings->post_title ?? 'پست';
                        } elseif ($order->shipping_method == 'freightage'){
                            $shippingMethod = $shippingSettings->freightage_title ?? 'باربری';
                        }
                        @endphp
                        <span>{{$shippingMethod}}</span>
                    </li>
                    <li class="list-group-item">
                        <span class="font-14 text-muted">هزینه ارسال:</span>
                        <span>{{number_format($order->shipping_cost) . ' تومان'}}</span>
                    </li>
                </ul>
            </div>

            <div class="box mb-3">
                <span class="form-title font-15 mb-3 d-block mt-3 mt-lg-0">پرداختی ها</span>
                @if($order->payments->count() > 0)
                    <div class="list-group">
                        @foreach($order->payments as $payment)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="font-14 text-muted">درگاه پرداخت:</span>
                                    <span>{{$payment->getGatewayName()}}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="font-14 text-muted">مبلغ پرداختی:</span>
                                    <span>{{number_format($payment->amount) . ' تومان'}}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="font-14 text-muted">وضعیت:</span>
                                    @if($payment->status == 'success')
                                        <span class="badge bg-success">موفق</span>
                                    @else
                                        <span class="badge bg-danger">ناموفق</span>
                                    @endif
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="font-14 text-muted">شماره پیگیری:</span>
                                    <span>{{$payment->tracking_code ?? '---'}}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="font-14 text-muted">تاریخ:</span>
                                    <span>{{verta($payment->created_at)->format('%d %B، %Y ساعت H:i')}}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>هیج پرداختی انجام نشده است.</p>
                @endif
            </div>
        </div>
    </div>

@endsection
