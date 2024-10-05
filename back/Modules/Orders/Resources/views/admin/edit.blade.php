@extends('admin.layouts.panel')
@section('content')
    <div class="d-flex align-items-center justify-content-between py-3 mb-4">
        <h4 class="m-0 breadcrumb-wrapper">
            <span class="text-muted fw-light"><a href="{{route('orders.index')}}">سفارشات</a> /</span> ویرایش
        </h4>
        <div>
            <a href="{{route('orders.label',$order)}}" class="btn btn-label-primary me-2"><span><i class="bx bxs-user-badge me-sm-2"></i> <span
                        class="d-none d-sm-inline-block">چاپ برچسب پستی</span></span></a>
            @if($order->is_paid)
                <a href="{{route('orders.factor',$order)}}" class="btn btn-label-secondary me-2"><span><i class="bx bx-printer me-sm-2"></i> <span
                            class="d-none d-sm-inline-block">مشاهده فاکتور</span></span></a>
            @endif

        </div>
    </div>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <form action="{{route('orders.update',$order)}}" method="post" enctype="multipart/form-data" class="row"
          id="mainForm">
        @csrf
        @method('PATCH')
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-2">{{'جزئیات سفارش شماره: ' . $order->order_number}}</h5>
                    <small>ثبت شده در تاریخ: {{verta($order->created_at)->format('%d %B، %Y ساعت H:i')}}</small>

                    <div class="mt-3">
                        <div class="row">
                            {{-- status --}}
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="status">وضعیت سفارش</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="pending_payment" {{$order->status == 'pending_payment' ? 'selected':''}}>در انتظار پرداخت مشتری</option>
                                    <option value="ongoing" {{$order->status == 'ongoing' ? 'selected':''}}>در حال پردازش</option>
                                    <option value="sent" {{$order->status == 'sent' ? 'selected':''}}>تحویل به پست</option>
                                    <option value="completed" {{$order->status == 'completed' ? 'selected':''}}>تکمیل شده</option>
                                    <option value="cancel" {{$order->status == 'cancel' ? 'selected':''}}>لغو شده</option>
                                </select>
                            </div>

                            {{-- is paid --}}
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="is_paid">وضعیت پرداخت</label>
                                <select class="form-select" id="is_paid" name="is_paid">
                                    <option value="yes" {{$order->is_paid ? 'selected' : ''}}>پرداخت شده</option>
                                    <option value="no" {{$order->is_paid ? '' : 'selected'}}>پرداخت نشده</option>
                                </select>
                            </div>

                            {{-- postal code --}}
                            <div class="col-12 mb-3">
                                <label class="form-label" for="postal_code">کد رهگیری پستی مرسوله</label>
                                <ul>
                                    <li class="mb-1 text-muted font-12">در صورت ورود این مقدار در صفحه جزئیات سفارش برای مشتری نمایش داده میشود.</li>
                                    <li class="mb-1 text-muted font-12">درصورتی که تنظیمات ارسال نوتیفیکیشن به درستی انجام شده باشد، بعد از درج کد رهگیری بلافاصله برای مشتری پیامک ارسال میشود.</li>
                                </ul>
                                <input type="text" class="form-control" dir="ltr" name="postal_code" id="postal_code"
                                       value="{{old('postal_code',$order->postal_code)}}" placeholder="کد رهگیری را وارد کنید">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-success submit-button">بروزرسانی</button>
                        <button type="button" class="btn btn-label-danger" id="edit-page-delete"
                                data-alert-message="این سفارش برای همیشه حذف میشود و قابل بازگشت نخواهد بود!"
                                data-model-id="{{$order->id}}" data-model="orders">حذف سفارش</button>
                    </div>

                </div>
            </div>

            {{-- items --}}
            <div class="card mb-4">
                <div class="card-header">اقلام سفارش</div>
                <div class="card-body">
                    <table class="table">
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
                                <td>
                                    <div class="avatar avatar-lg">
                                        <img src="{{$product->getImage('thumb')}}" alt="image" width="60"
                                             class="rounded">
                                    </div>
                                    <h6>{{$product->title}}</h6>
                                    {{-- display color and size --}}
                                    @if($product->pivot->color)
                                        <span class="d-block font-13 mb-2">رنگ: {{$product->pivot->color}}</span>
                                    @endif
                                    @if($product->pivot->size)
                                        <span class="d-block font-13 mb-2">سایز: {{$product->pivot->size}}</span>
                                    @endif

                                    <a href="{{route('product.show',$product)}}" class="blockquote-footer">مشاهده
                                        محصول</a>
                                </td>
                                <td>{{number_format($product->pivot->price) . ' تومان'}}</td>
                                <td>{{$product->pivot->quantity}}</td>
                                <td>{{number_format(intval($product->pivot->price) * intval($product->pivot->quantity)) . ' تومان'}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <ul class="list-group m-0 p-0 mt-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>جمع مبلغ محصولات:</span>
                            <span>{{number_format($order->getTotalItemsPrice()) . ' تومان'}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>هزینه ارسال:</span>
                            <span>{{number_format($order->shipping_cost) . ' تومان'}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>مجموع هزینه سفارش:</span>
                            <span>{{number_format($order->getTotalPrice()) . ' تومان'}}</span>
                        </li>
                        <li class="list-group-item list-group-item-success d-flex justify-content-between align-items-center">
                            <span>مبلغ پرداخت شده:</span>
                            <span>{{number_format($order->paid_price) . ' تومان'}}</span>
                        </li>
                        @if($order->paid_from_wallet != null)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>مبلغ پرداخت شده از کیف پول:</span>
                            <span>{{number_format($order->paid_from_wallet) . ' تومان'}}</span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            {{-- shipping --}}
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    اطلاعات حمل و نقل
                    <a href="{{route('orders.edit_shipping',$order)}}" class="btn btn-sm btn-label-primary"><i class="bx bx-edit me-2"></i><span>ویرایش آدرس</span></a>
                </div>

                <div class="card-body">
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
                            @php $shippingMethod = $order->shipping_method; $shippingSettings = \Modules\Settings\Entities\ShippingSettings::firstOrCreate();
                            if ($order->shipping_method == 'post_pishtaz'){
                                $shippingMethod = $shippingSettings->post_pishtaz_title;
                            }elseif ($order->shipping_method == 'bike'){
                                $shippingMethod = $shippingSettings->bike_title;
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
            </div>
        </div>
        <div class="col-lg-4">
            {{-- details --}}
            <div class="card mb-4">
                <div class="card-body">

                    @if($order->notes != null)
                    <div class="mb-3">
                        <div class="alert alert-warning">
                            <b class="d-block mb-2">یادداشت مشتری:</b>
                            {{$order->notes}}
                        </div>
                    </div>
                    @endif

                    <div class="mb-3">
                        <h6>پرداخت های این سفارش</h6>
                        @if($order->payments->count() > 0)
                        <div class="list-group">
                            @foreach($order->payments as $payment)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="font-13 fw-bold text-muted">درگاه پرداخت:</span>
                                        <span>{{$payment->getGatewayName()}}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="font-13 fw-bold text-muted">مبلغ پرداختی:</span>
                                        <span>{{number_format($payment->amount) . ' تومان'}}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="font-13 fw-bold text-muted">وضعیت:</span>
                                        @if($payment->status == 'success')
                                            <span class="badge bg-label-success">موفق</span>
                                        @else
                                            <span class="badge bg-label-danger">ناموفق</span>
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="font-13 fw-bold text-muted">شماره پیگیری:</span>
                                        <span>{{$payment->tracking_code ?? '---'}}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="font-13 fw-bold text-muted">تاریخ:</span>
                                        <span>{{verta($payment->created_at)->format('%d %B، %Y ساعت H:i')}}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @else
                            <p>هیج پرداختی انجام نشده است.</p>
                        @endif
                    </div>

                    @if(count($order->getCoupons()) > 0)
                    <div class="mb-3">
                        @foreach($order->getCoupons() as $coupon)
                            <div class="alert alert-dark">
                                <p>مشتری از کد تخفیف <b>{{$coupon->code}}</b> روی این سفارش استفاده کرده است.</p>
                                <span class="d-block mb-2">نوع تخفیف: {{$coupon->type == 'amount' ? 'مبلغ' : 'درصدی'}}</span>
                                <span> مقدار تخفیف: {{$coupon->type == 'amount' ? (number_format($coupon->amount) . ' تومان') : ($coupon->percent . '% درصد')}}</span>
                            </div>
                        @endforeach
                    </div>
                    @endif


                </div>
            </div>

            {{-- customer --}}
            @include('users::admin.show.sidebar',['user' => $order->user, 'simpleView' => true])

        </div>
    </form>

@endsection

@section('styles')
@endsection
@section('scripts')
@endsection
