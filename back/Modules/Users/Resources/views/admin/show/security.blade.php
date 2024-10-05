@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">کاربر / نمایش /</span> امنیت
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
                    <a class="nav-link active" href="{{route('users.show_security',$user)}}"><i class="bx bx-lock-alt me-1"></i>امنیت</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('users.balance',$user)}}"><i class="bx bx-wallet-alt me-1"></i>کیف پول و موجودی</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('users.show_payments',$user)}}"><i class="bx bx-money me-1"></i>پرداخت ها</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('users.show_addresses',$user)}}"><i class="bx bx-map me-1"></i>آدرس ها</a>
                </li>
            </ul>

            <div class="card mb-4">
                <h5 class="card-header">تغییر رمز عبور</h5>
                <div class="card-body">
                    <form action="{{route('users.password_update',$user)}}" method="POST" id="mainForm">
                        @csrf
                        <div class="alert alert-warning" role="alert">
                            <h6 class="alert-heading mb-1">از رعایت الزامات زیر اطمینان حاصل کنید</h6>
                            <span>حداقل 8 کاراکتر</span>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12 col-sm-6 form-password-toggle">
                                <label class="form-label" for="password">رمز عبور جدید</label>
                                <div class="input-group input-group-merge">
                                    <input class="form-control text-start" dir="ltr" type="password" id="password" name="password" placeholder="············">
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>

                            <div class="mb-3 col-12 col-sm-6 form-password-toggle">
                                <label class="form-label" for="password_confirmation">تایید رمز عبور جدید</label>
                                <div class="input-group input-group-merge">
                                    <input class="form-control text-start" dir="ltr" type="password" name="password_confirmation" id="password_confirmation" placeholder="············">
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary submit-button me-2">تغییر رمز عبور</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/pages/page-profile.css')}}">
@endsection
@section('scripts')
@endsection
