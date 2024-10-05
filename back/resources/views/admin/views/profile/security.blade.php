@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">تنظیمات حساب /</span> امنیت
    </h4>
    @include('admin.includes.alerts')
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.profile')}}"><i class="bx bx-user me-1"></i> حساب</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('admin.profile.security')}}"><i class="bx bx-lock-alt me-1"></i> امنیت</a>
                </li>
            </ul>
            <div class="card mb-4">
                <h5 class="card-header">تغییر رمز عبور</h5>
                <form action="{{route('admin.update.password',$admin)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <form id="formAccountSettings" method="POST" onsubmit="return false">
                            <div class="row">
                                <div class="mb-3 col-md-6 form-password-toggle">
                                    <label class="form-label" for="current_password">رمز عبور کنونی</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control text-start" dir="ltr" type="password" name="current_password" id="current_password" placeholder="············">
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6 form-password-toggle">
                                    <label class="form-label" for="password">رمز عبور جدید</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control text-start" dir="ltr" type="password" id="password" name="password" placeholder="············">
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6 form-password-toggle">
                                    <label class="form-label" for="password_confirmation">تایید رمز عبور جدید</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control text-start" dir="ltr" type="password" name="password_confirmation" id="password_confirmation" placeholder="············">
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                                <div class="col-12 mb-4">
                                    <p class="fw-semibold mt-2">یک رمز عبور قوی باید شامل:</p>
                                    <ul class="ps-3 mb-0 lh-1-85">
                                        <li class="mb-1">حداقل 8 کاراکتر - هرچه بیشتر، بهتر</li>
                                        <li class="mb-1">حداقل یک کاراکتر با حرف کوچک</li>
                                        <li>حداقل یک عدد، نماد یا کاراکتر فاصله</li>
                                    </ul>
                                </div>
                                <div class="col-12 mt-1">
                                    <button type="submit" class="btn btn-primary me-2">ذخیره تغییرات</button>
                                    <a href="{{route('admin.dashboard')}}" class="btn btn-label-secondary">بازگشت</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
