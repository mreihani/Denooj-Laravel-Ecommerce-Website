@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">کاربر / نمایش /</span> پرداخت ها
    </h4>
    @include('admin.includes.alerts')
    <div class="row gy-4">
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            @include('users::admin.show.sidebar')
        </div>
        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
            <!-- User Pills -->
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('users.show',$user)}}"><i class="bx bx-file me-1"></i>سفارشات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('users.show_security',$user)}}"><i class="bx bx-lock-alt me-1"></i>امنیت</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('users.balance',$user)}}"><i class="bx bx-wallet-alt me-1"></i>کیف پول و موجودی</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('users.show_payments',$user)}}"><i class="bx bx-money me-1"></i>پرداخت ها</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('users.show_addresses',$user)}}"><i class="bx bx-map me-1"></i>آدرس ها</a>
                </li>
            </ul>

            <div class="card mb-4">
                <h5 class="card-header">لیست پرداخت های کاربر</h5>
                @if($user->payments->count() > 0)
                    <table class="table table-striped table-hover" style="min-height: 200px">
                        <thead>
                        <tr>
                            <th>مبلغ</th>
                            <th>نوع</th>
                            <th>کد پیگیری</th>
                            <th>درگاه پرداخت</th>
                            <th>وضعیت</th>
                            <th>تاریخ</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @foreach($user->payments as $payment)
                            <tr>
                                <td>{{number_format($payment->amount) . ' تومان'}}</td>
                                <td>{{($payment->type == 'wallet') ? 'شارژ کیف پول' : ($payment->type == 'order' ? 'پرداخت سفارش' : '')}}</td>
                                <td>{{$payment->tracking_code}}</td>
                                <td>{{$payment->getGatewayName()}}</td>
                                <td>
                                    @if($payment->status == 'success')
                                        <span class="alert alert-success d-inline-block">موفق</span>
                                    @else
                                        <span class="alert alert-danger d-inline-block">ناموفق</span>
                                    @endif
                                </td>
                                <td>{{verta($payment->created_at)->format('Y-n-j ساعت H:i')}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-secondary m-3">هیچ موردی پیدا نشد.</div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/pages/page-profile.css')}}">
@endsection
@section('scripts')
@endsection
