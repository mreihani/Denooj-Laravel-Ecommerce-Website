@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">تنظیمات /</span> پیشرفته
    </h4>
    @include('admin.includes.alerts')
    <div class="row">
        <div class="col-md-12">
            @include('settings::nav')
            <form action="{{route('settings.config_update')}}" method="post" enctype="multipart/form-data"
                  id="mainForm">
                @csrf
                <div class="card mb-4">
                    <h5 class="card-header">تنظیمات کانفیگ</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 mb-4">
                                <label for="site_name_fa" class="form-label">نام سایت</label>
                                <input class="form-control" type="text" id="site_name_fa" name="site_name_fa"
                                       value="{{old('site_name_fa',$appNameFa)}}">
                            </div>
                            <div class="col-lg-4 mb-4">
                                <label for="site_domain" class="form-label">نام دامنه سایت بدون http</label>
                                <input class="form-control" dir="ltr" type="text" id="site_domain" name="site_domain"
                                       value="{{old('site_domain',$siteDomain)}}">
                            </div>

                            <div class="mb-4">
                                <label class="switch switch-square">
                                    <input type="checkbox" class="switch-input check-toggle"
                                           name="maintenance_mode" {{$settings->maintenance_mode  ? 'checked' : ''}}>
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                    <span class="switch-label">فعالسازی حالت تعمیر و نگهداری</span>
                                </label>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-success me-2 submit-button">ذخیره تغییرات</button>
                                <a href="{{route('admin.dashboard')}}" class="btn btn-label-secondary">انصراف</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <h5 class="card-header">تنظیمات اکانت ایمیل مدیریت</h5>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 mb-4">
                                <label for="mail_mailer" class="form-label">نوع سرویس دهنده</label>
                                <select class="form-select" id="mail_mailer" name="mail_mailer">
                                    <option value="pop3" {{$mailMailer == 'pop3' ? 'selected' :''}}>pep3</option>
                                    <option value="smtp" {{$mailMailer == 'smtp' ? 'selected' :''}}>smtp</option>
                                </select>
                            </div>
                            <div class="col-lg-4 mb-4">
                                <label for="mail_host" class="form-label">آدرس سرور</label>
                                <input class="form-control" dir="ltr" type="text" id="mail_host" name="mail_host"
                                       value="{{old('mail_host',$mailHost)}}">
                            </div>
                            <div class="col-lg-4 mb-4">
                                <label for="mail_port" class="form-label">پورت</label>
                                <input class="form-control" dir="ltr" type="text" id="mail_port" name="mail_port"
                                       value="{{old('mail_port',$mailPort)}}">
                            </div>
                            <div class="col-lg-4 mb-4">
                                <label for="mail_username" class="form-label">نام کاربری</label>
                                <input class="form-control" dir="ltr" type="text" id="mail_username"
                                       name="mail_username"
                                       value="{{old('mail_username',$mailUsername)}}">
                            </div>
                            <div class="col-lg-4 mb-4">
                                <label for="mail_password" class="form-label">کلمه عبور</label>
                                <input class="form-control" dir="ltr" type="text" id="mail_password"
                                       name="mail_password"
                                       value="{{old('mail_password',$mailPassword)}}">
                            </div>

                            <div class="col-lg-4 mb-4">
                                <label for="mail_from_address" class="form-label">آدرس ایمیل فرستنده</label>
                                <input class="form-control" dir="ltr" type="text" id="mail_from_address"
                                       name="mail_from_address"
                                       value="{{old('mail_from_address',$mailFromAddress)}}">
                            </div>
                            <div class="col-lg-4 mb-4">
                                <label for="mail_from_name" class="form-label">نام فرستنده</label>
                                <input class="form-control" dir="ltr" type="text" id="mail_from_name"
                                       name="mail_from_name"
                                       value="{{old('mail_from_name',$mailFromName)}}">
                            </div>


                            <div class="mt-4">
                                <button type="submit" class="btn btn-success me-2 submit-button">ذخیره تغییرات</button>
                                <a href="{{route('admin.dashboard')}}" class="btn btn-label-secondary">انصراف</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <form action="{{route('settings.test_mail')}}" method="post" enctype="multipart/form-data" id="secondForm">
                @csrf
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="card-title">
                            <h5 class="m-0 me-2">ارسال ایمیل تست</h5>
                        </div>
                        <div class="mb-2">
                            <label for="test_mail_receiver" class="form-label">آدرس ایمیل دریافت کننده تست</label>
                            <input class="form-control" dir="ltr" type="email" id="test_mail_receiver" style="min-width: 300px;" aria-label="test_mail_receiver"
                                   name="test_mail_receiver" placeholder="yourmail@gmail.com">
                        </div>

                        <p class="card-text">جهت بررسی صحیح بودن اطلاعات اکانت ایمیل یک آدرس ایمیل در فیلد بالا وارد کنید تا ایمیل آزمایشی به آن آدرس ایمیل ارسال شود سپس روی ارسال ایمیل تست کلیک کنید.</p>

                        <button type="submit" class="btn btn-success mt-2 submit-button">ارسال ایمیل تست</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
