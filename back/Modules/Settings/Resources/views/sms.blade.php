@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">تنظیمات /</span> پیامک
    </h4>
    @include('admin.includes.alerts')
    <div class="row">
        <div class="col-md-12">
            @include('settings::nav')
            <div class="card mb-4">
                <h5 class="card-header">تنظیمات پیامک ها</h5>
                <form action="{{route('settings.sms_update',$settings)}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <div class="mb-4 col-lg-4">
                            <label class="form-label" for="sms_provider">انتخاب سرویس دهنده پیامک</label>
                            <select id="sms_provider" type="text" name="sms_provider" class="form-select banta-ui-switcher">
                                <option value="farazsms" {{$settings->sms_provider == 'farazsms' ? 'selected' : ''}}>فراز اس‌ام‌اس</option>
                                <option value="ghasedak" {{$settings->sms_provider == 'ghasedak' ? 'selected' : ''}}>قاصدک</option>
                                <option value="kavenegar" {{$settings->sms_provider == 'kavenegar' ? 'selected' : ''}}>کاوه نگار</option>
                            </select>
                        </div>

                        <div id="farazsms_fields" data-banta-switcher="farazsms" class="{{$settings->sms_provider == 'farazsms' ? '':'d-none'}} row">

                            {{-- help --}}
                            <div class="col-12 mb-3">
                                <div class="alert alert-info">
                                    <h4>راهنمایی</h4>
                                    <p>جهت فعالسازی پنل پیامکی فراز اس ام اس به صورت زیر عمل کنید:</p>
                                    <ul style="list-style: inside">
                                        <li>ابتدا باید در سایت فراز اس ام اس (farazsms.com) ثبت نام و پنل پیامکی خریداری کنید.</li>
                                        <li>اطلاعات حساب کاربری خود از جمله نام کاربری، کلمه عبور و شماره خط پیامکی را در فیلد های زیر وارد کنید.</li>
                                        <li>از طریق پنل کاربری خود در فراز اس ام اس، وارد بخش <b>ارسال بر اساس پترن</b> شوید، سپس برای هر یک از فیلدهای خواسته شده در قسمت پایین، یک پترن جدید ایجاد کنید.</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <label class="form-label" for="farazsms_username">نام کاربری</label>
                                <input id="farazsms_username" dir="ltr" type="text" name="farazsms_username" class="form-control" value="{{old('farazsms_username',$settings->farazsms_username)}}">
                            </div>

                            <div class="col-lg-4 mb-3">
                                <label class="form-label" for="farazsms_password">کلمه عبور</label>
                                <input id="farazsms_password" dir="ltr" type="text" name="farazsms_password" class="form-control" value="{{old('farazsms_password',$settings->farazsms_password)}}">
                            </div>

                            <div class="col-lg-4 mb-3">
                                <label class="form-label" for="farazsms_number">شماره ارسال</label>
                                <input id="farazsms_number" dir="ltr" type="text" name="farazsms_number" class="form-control" value="{{old('farazsms_number',$settings->farazsms_number)}}">
                            </div>

                            <h4 class="card-title mt-4">پترن ها</h4>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="farazsms_signin_pattern">پترن کد یکبار مصرف</label>
                                        <input id="farazsms_signin_pattern" dir="ltr" type="text" name="farazsms_signin_pattern" class="form-control" value="{{old('farazsms_signin_pattern',$settings->farazsms_signin_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            پترن کد یکبار مصرف باید شامل یک پارامتر با نام <b>code</b> باشد! نمونه صحیح پترن قابل قبول:
                                            <div class="mt-2">
                                                فروشگاه {{config('app.app_name_fa')}}
                                                <br>
                                                کد تایید شما: %code%
                                                <br>

                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="farazsms_question_answered_pattern">پترن ثبت پاسخ برای پرسش مشتری</label>
                                        <input id="farazsms_question_answered_pattern" dir="ltr" type="text" name="farazsms_question_answered_pattern" class="form-control" value="{{old('farazsms_question_answered_pattern',$settings->farazsms_question_answered_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            این پترن باید شامل یک پارامتر با نام <b>link</b> باشد! نمونه صحیح پترن قابل قبول:
                                            <div class="mt-2">
                                                کاربر گرامی پاسخ جدیدی برای پرسش شما ثبت شده است.
                                                <br>
                                                لینک مشاهده: %link%
                                                <br>
                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <hr>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="farazsms_order_submitted_pattern">پترن ثبت سفارش توسط مشتری</label>
                                        <input id="farazsms_order_submitted_pattern" dir="ltr" type="text" name="farazsms_order_submitted_pattern" class="form-control" value="{{old('farazsms_order_submitted_pattern',$settings->farazsms_order_submitted_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            این پترن باید شامل یک پارامتر با نام <b>number</b> باشد! نمونه صحیح پترن قابل قبول:
                                            <div class="mt-2">
                                                سفارش شما با کد پیگیری %number% ثبت شد و بزودی بررسی خواهد شد! از خرید شما سپاسگذاریم.
                                                <br>
                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="farazsms_order_sent_pattern">پترن تغییر وضعیت سفارش به تحویل به پست (هنگام درج کد مرسوله پستی)</label>
                                        <input id="farazsms_order_sent_pattern" dir="ltr" type="text" name="farazsms_order_sent_pattern" class="form-control" value="{{old('farazsms_order_sent_pattern',$settings->farazsms_order_sent_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            این پترن باید شامل یک پارامتر با نام <b>number</b> باشد! نمونه صحیح پترن قابل قبول:
                                            <div class="mt-2">
                                                سفارش شما به پست تحویل داده شد. کد مرسوله پستی: <b>%number%</b>
                                                <br>
                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="farazsms_order_completed_pattern">پترن تغییر وضعیت سفارش به تکمیل شده</label>
                                        <input id="farazsms_order_completed_pattern" dir="ltr" type="text" name="farazsms_order_completed_pattern" class="form-control" value="{{old('farazsms_order_completed_pattern',$settings->farazsms_order_completed_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            این پترن باید شامل یک پارامتر با نام <b>number</b> باشد! نمونه صحیح پترن قابل قبول:
                                            <div class="mt-2">
                                                سفارش شماره "<b>%number%</b>" برای شما ارسال شد. با تشکر از خرید شما
                                                <br>
                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>



                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="farazsms_product_comment_pattern">پترن نوتیف مدیر هنگام ثبت دیدگاه جدید</label>
                                        <input id="farazsms_product_comment_pattern" dir="ltr" type="text" name="farazsms_product_comment_pattern" class="form-control" value="{{old('farazsms_product_comment_pattern',$settings->farazsms_product_comment_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            این پترن باید شامل یک پارامتر با نام <b>title</b> باشد! نمونه صحیح پترن قابل قبول:
                                            <div class="mt-2">
                                                دیدگاه جدیدی برای محصول "%title%" ثبت شد.
                                                <br>
                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="farazsms_post_comment_pattern">پترن نوتیف مدیر هنگام ثبت دیدگاه جدید برای مقاله</label>
                                        <input id="farazsms_post_comment_pattern" dir="ltr" type="text" name="farazsms_post_comment_pattern" class="form-control" value="{{old('farazsms_post_comment_pattern',$settings->farazsms_post_comment_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            این پترن باید شامل یک پارامتر با نام <b>title</b> باشد! نمونه صحیح پترن قابل قبول:
                                            <div class="mt-2">
                                                دیدگاه جدیدی برای مقاله "%title%" ثبت شد.
                                                <br>
                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="farazsms_question_pattern">پترن نوتیف مدیر هنگام ثبت پرسش جدید</label>
                                        <input id="farazsms_question_pattern" dir="ltr" type="text" name="farazsms_question_pattern" class="form-control" value="{{old('farazsms_question_pattern',$settings->farazsms_question_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            این پترن باید شامل یک پارامتر با نام <b>title</b> باشد! نمونه صحیح پترن قابل قبول:
                                            <div class="mt-2">
                                                پرسش جدیدی برای محصول "%title%" ثبت شد.
                                                <br>
                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="farazsms_admin_order_submitted_pattern">پترن نوتیف مدیر هنگام دریافت سفارش جدید</label>
                                        <input id="farazsms_admin_order_submitted_pattern" dir="ltr" type="text" name="farazsms_admin_order_submitted_pattern" class="form-control" value="{{old('farazsms_admin_order_submitted_pattern',$settings->farazsms_admin_order_submitted_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            این پترن باید شامل یک پارامتر با نام <b>number</b> باشد! نمونه صحیح پترن قابل قبول:
                                            <div class="mt-2">
                                                سفارش جدیدی با کد "%number%" ثبت شد.
                                                <br>
                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>



                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-success me-2 submit-button">ذخیره تغییرات</button>
                                <a href="{{route('admin.dashboard')}}" class="btn btn-label-secondary">انصراف</a>
                            </div>
                        </div>

                        <div id="ghasedak_fields" data-banta-switcher="ghasedak" class="{{$settings->sms_provider == 'ghasedak' ? '':'d-none'}} row">

                            {{-- help --}}
                            <div class="col-12 mb-3">
                                <div class="alert alert-info">
                                    <h4>راهنمایی</h4>
                                    <p>جهت فعالسازی پنل پیامکی قاصدک به صورت زیر عمل کنید:</p>
                                    <ul style="list-style: inside">
                                        <li>ابتدا باید در سایت قاصدک (ghasedaksms.com) ثبت نام و پنل پیامکی خریداری کنید.</li>
                                        <li>وارد پنل توسعه دهنده قاصدک (developers.ghasedak.me) شوید و از منوی Api Keys یک کلید جدید ایجاد کنید.</li>
                                        <li>کلیک Api ساخته شده را در فیلد زیر وارد کنید.</li>
                                        <li>وارد بخش <b>سرویس اعتبارسنجی otp</b> شوید، سپس برای هر یک از فیلدهای خواسته شده در قسمت پایین، یک پترن جدید ایجاد کنید.</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label" for="ghasedak_api">کلید api</label>
                                <input id="ghasedak_api" dir="ltr" type="text" name="ghasedak_api" class="form-control" value="{{old('ghasedak_api',$settings->ghasedak_api)}}">
                            </div>

                            <h4 class="card-title mt-4">قالب ها</h4>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="ghasedak_signin_pattern">نام قالب کد یکبار مصرف</label>
                                        <input id="ghasedak_signin_pattern" dir="ltr" type="text" name="ghasedak_signin_pattern" class="form-control" value="{{old('ghasedak_signin_pattern',$settings->ghasedak_signin_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            پترن کد یکبار مصرف باید شامل یک پارامتر با نام <b>param1</b> باشد! نمونه صحیح پترن قابل قبول:
                                            <div class="mt-2">
                                                فروشگاه {{config('app.app_name_fa')}}
                                                <br>
                                                کد تایید شما: <span style="direction: ltr;display: inline-block">%param1%</span>
                                                <br>
                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="ghasedak_question_answered_pattern">نام قالب ثبت پاسخ برای پرسش مشتری</label>
                                        <input id="ghasedak_question_answered_pattern" dir="ltr" type="text" name="ghasedak_question_answered_pattern" class="form-control" value="{{old('ghasedak_question_answered_pattern',$settings->ghasedak_question_answered_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            این پترن باید شامل یک پارامتر با نام <b>param1</b> باشد! نمونه صحیح پترن قابل قبول:
                                            <div class="mt-2">
                                                کاربر گرامی پاسخ جدیدی برای پرسش شما ثبت شده است.
                                                <br>
                                                لینک مشاهده: <span style="direction: ltr;display: inline-block">%param1%</span>
                                                <br>
                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <hr>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="ghasedak_order_submitted_pattern">نام قالب ثبت سفارش توسط مشتری</label>
                                        <input id="ghasedak_order_submitted_pattern" dir="ltr" type="text" name="ghasedak_order_submitted_pattern" class="form-control" value="{{old('ghasedak_order_submitted_pattern',$settings->ghasedak_order_submitted_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            این پترن باید شامل یک پارامتر با نام <b>param1</b> باشد! نمونه صحیح پترن قابل قبول:
                                            <div class="mt-2">
                                                سفارش شما با کد پیگیری <span class="d-inline-block dir-ltr">%param1%</span> ثبت شد و بزودی بررسی خواهد شد! از خرید شما سپاسگذاریم.
                                                <br>
                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="ghasedak_order_completed_pattern">نام قالب تغییر وضعیت سفارش به تکمیل شده</label>
                                        <input id="ghasedak_order_completed_pattern" dir="ltr" type="text" name="ghasedak_order_completed_pattern" class="form-control" value="{{old('ghasedak_order_completed_pattern',$settings->ghasedak_order_completed_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            این پترن باید شامل یک پارامتر با نام <b>param1</b> باشد! نمونه صحیح پترن قابل قبول:
                                            <div class="mt-2">
                                                سفارش شماره "<span class="d-inline-block dir-ltr">%param1%</span>" برای شما ارسال شد.
                                                <br>
                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="ghasedak_product_comment_pattern">نام قالب نوتیف مدیر هنگام ثبت دیدگاه جدید برای محصول</label>
                                        <input id="ghasedak_product_comment_pattern" dir="ltr" type="text" name="ghasedak_product_comment_pattern" class="form-control" value="{{old('ghasedak_product_comment_pattern',$settings->ghasedak_product_comment_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            این پترن باید شامل یک پارامتر با نام <b>param1</b> باشد! نمونه صحیح پترن قابل قبول:
                                            <div class="mt-2">
                                                دیدگاه جدیدی برای محصول "<span class="d-inline-block dir-ltr">%param1%</span>" ثبت شد.
                                                <br>
                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="ghasedak_post_comment_pattern">نام قالب نوتیف مدیر هنگام ثبت دیدگاه جدید برای مقاله</label>
                                        <input id="ghasedak_post_comment_pattern" dir="ltr" type="text" name="ghasedak_post_comment_pattern" class="form-control" value="{{old('ghasedak_post_comment_pattern',$settings->ghasedak_post_comment_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            این پترن باید شامل یک پارامتر با نام <b>param1</b> باشد! نمونه صحیح پترن قابل قبول:
                                            <div class="mt-2">
                                                دیدگاه جدیدی برای مقاله "<span class="d-inline-block dir-ltr">%param1%</span>" ثبت شد.
                                                <br>
                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="ghasedak_question_pattern">نام قالب نوتیف مدیر هنگام ثبت پرسش جدید</label>
                                        <input id="ghasedak_question_pattern" dir="ltr" type="text" name="ghasedak_question_pattern" class="form-control" value="{{old('ghasedak_question_pattern',$settings->ghasedak_question_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            این پترن باید شامل یک پارامتر با نام <b>param1</b> باشد! نمونه صحیح پترن قابل قبول:
                                            <div class="mt-2">
                                                پرسش جدیدی برای محصول "<span class="d-inline-block dir-ltr">%param1%</span>" ثبت شد.
                                                <br>
                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="ghasedak_admin_order_submitted_pattern">نام قالب نوتیف مدیر هنگام دریافت سفارش جدید</label>
                                        <input id="ghasedak_admin_order_submitted_pattern" dir="ltr" type="text" name="ghasedak_admin_order_submitted_pattern" class="form-control" value="{{old('ghasedak_admin_order_submitted_pattern',$settings->ghasedak_admin_order_submitted_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            این پترن باید شامل یک پارامتر با نام <b>param1</b> باشد! نمونه صحیح پترن قابل قبول:
                                            <div class="mt-2">
                                                سفارش جدیدی با کد "<span class="d-inline-block dir-ltr">%param1%</span>" ثبت شد.
                                                <br>
                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-success me-2 submit-button">ذخیره تغییرات</button>
                                <a href="{{route('admin.dashboard')}}" class="btn btn-label-secondary">انصراف</a>
                            </div>
                        </div>

                        <div id="kavenegar_fields" data-banta-switcher="kavenegar" class="{{$settings->sms_provider == 'kavenegar' ? '':'d-none'}} row">

                            {{-- help --}}
                            <div class="col-12 mb-3">
                                <div class="alert alert-info">
                                    <h4>راهنمایی</h4>
                                    <p>جهت فعالسازی پنل پیامکی کاوه نگار به صورت زیر عمل کنید:</p>
                                    <ul style="list-style: inside">
                                        <li>ابتدا باید در سایت کاوه نگار (kavenegar.com) ثبت نام و پنل پیامکی خریداری کنید.</li>
                                        <li>از طریق گزینه پروفایل و حساب من، Api Key خود را کپی کرده و در فیلد زیر وارد کنید.</li>
                                        <li>وارد بخش <b>اعتبارسنجی</b> شوید، سپس برای هر یک از فیلدهای خواسته شده در قسمت پایین، یک الگو جدید با توجه به توضیحات کاوه نگار ایجاد کنید.</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label" for="kavenegar_api">کلید api</label>
                                <input id="kavenegar_api" dir="ltr" type="text" name="kavenegar_api" class="form-control" value="{{old('kavenegar_api',$settings->kavenegar_api)}}">
                            </div>

                            <h4 class="card-title mt-4">الگو ها</h4>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="kavenegar_signin_pattern">نام الگوی کد یکبار مصرف</label>
                                        <input id="kavenegar_signin_pattern" dir="ltr" type="text" name="kavenegar_signin_pattern" class="form-control" value="{{old('kavenegar_signin_pattern',$settings->kavenegar_signin_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            الگو کد یکبار مصرف باید شامل یک پارامتر با نام <b>token</b> باشد! نمونه صحیح الگوی قابل قبول:
                                            <div class="mt-2">
                                                فروشگاه {{config('app.app_name_fa')}}
                                                <br>
                                                کد تایید شما: <span style="direction: ltr;display: inline-block">%token</span>
                                                <br>
                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="kavenegar_question_answered_pattern">نام الگوی ثبت پاسخ برای پرسش مشتری</label>
                                        <input id="kavenegar_question_answered_pattern" dir="ltr" type="text" name="kavenegar_question_answered_pattern" class="form-control" value="{{old('kavenegar_question_answered_pattern',$settings->kavenegar_question_answered_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            این الگو باید شامل یک پارامتر با نام <b>token</b> باشد! نمونه صحیح الگوی قابل قبول:
                                            <div class="mt-2">
                                                کاربر گرامی پاسخ جدیدی برای پرسش شما ثبت شده است.
                                                <br>
                                                لینک مشاهده: <span style="direction: ltr;display: inline-block">%token</span>
                                                <br>
                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <hr>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="kavenegar_order_submitted_pattern">نام الگوی ثبت سفارش توسط مشتری</label>
                                        <input id="kavenegar_order_submitted_pattern" dir="ltr" type="text" name="kavenegar_order_submitted_pattern" class="form-control" value="{{old('kavenegar_order_submitted_pattern',$settings->kavenegar_order_submitted_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            این الگو باید شامل یک پارامتر با نام <b>token</b> باشد! نمونه صحیح الگوی قابل قبول:
                                            <div class="mt-2">
                                                سفارش شما با کد پیگیری <span class="d-inline-block dir-ltr">%token</span> ثبت شد و بزودی بررسی خواهد شد! از خرید شما سپاسگذاریم.
                                                <br>
                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="kavenegar_order_completed_pattern">نام تغییر وضعیت سفارش به تکمیل شده</label>
                                        <input id="kavenegar_order_completed_pattern" dir="ltr" type="text" name="kavenegar_order_completed_pattern" class="form-control" value="{{old('kavenegar_order_completed_pattern',$settings->kavenegar_order_completed_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            این الگو باید شامل یک پارامتر با نام <b>token</b> باشد! نمونه صحیح الگوی قابل قبول:
                                            <div class="mt-2">
                                                سفارش شماره "<span class="d-inline-block dir-ltr">%token</span>" برای شما ارسال شد.
                                                <br>
                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="kavenegar_product_comment_pattern">نام الگوی نوتیف مدیر هنگام ثبت دیدگاه جدید برای محصول</label>
                                        <input id="kavenegar_product_comment_pattern" dir="ltr" type="text" name="kavenegar_product_comment_pattern" class="form-control" value="{{old('kavenegar_product_comment_pattern',$settings->kavenegar_product_comment_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            این الگو باید شامل یک پارامتر با نام <b>token</b> باشد! نمونه صحیح الگوی قابل قبول:
                                            <div class="mt-2">
                                                دیدگاه جدیدی برای محصول "<span class="d-inline-block dir-ltr">%token</span>" ثبت شد.
                                                <br>
                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="kavenegar_post_comment_pattern">نام الگوی نوتیف مدیر هنگام ثبت دیدگاه جدید برای مقاله</label>
                                        <input id="kavenegar_post_comment_pattern" dir="ltr" type="text" name="kavenegar_post_comment_pattern" class="form-control" value="{{old('kavenegar_post_comment_pattern',$settings->kavenegar_post_comment_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            این الگو باید شامل یک پارامتر با نام <b>token</b> باشد! نمونه صحیح الگوی قابل قبول:
                                            <div class="mt-2">
                                                دیدگاه جدیدی برای مقاله "<span class="d-inline-block dir-ltr">%token</span>" ثبت شد.
                                                <br>
                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="kavenegar_question_pattern">نام الگوی نوتیف مدیر هنگام ثبت پرسش جدید</label>
                                        <input id="kavenegar_question_pattern" dir="ltr" type="text" name="kavenegar_question_pattern" class="form-control" value="{{old('kavenegar_question_pattern',$settings->kavenegar_question_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            این الگو باید شامل یک پارامتر با نام <b>token</b> باشد! نمونه صحیح الگوی قابل قبول:
                                            <div class="mt-2">
                                                پرسش جدیدی برای محصول "<span class="d-inline-block dir-ltr">%token</span>" ثبت شد.
                                                <br>
                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="kavenegar_admin_order_submitted_pattern">نام الگوی نوتیف مدیر هنگام دریافت سفارش جدید</label>
                                        <input id="kavenegar_admin_order_submitted_pattern" dir="ltr" type="text" name="kavenegar_admin_order_submitted_pattern" class="form-control" value="{{old('kavenegar_admin_order_submitted_pattern',$settings->kavenegar_admin_order_submitted_pattern)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            این الگو باید شامل یک پارامتر با نام <b>token</b> باشد! نمونه صحیح الگوی قابل قبول:
                                            <div class="mt-2">
                                                سفارش جدید با کد "<span class="d-inline-block dir-ltr">%token</span>" ثبت شد.
                                                <br>
                                                https://yoursite.com
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-success me-2 submit-button">ذخیره تغییرات</button>
                                <a href="{{route('admin.dashboard')}}" class="btn btn-label-secondary">انصراف</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
