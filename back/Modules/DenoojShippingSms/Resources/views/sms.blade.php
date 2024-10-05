@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">تنظیمات /</span> پیامک
    </h4>
    @include('admin.includes.alerts')
    <div class="row">
        <div class="col-md-12">
            @include('settings::nav')
            <div class="card">
                <h5 class="card-header">تنظیمات پیامک ها</h5>
                <form action="{{route('settings.denooj-sms_update',$settings)}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">

                        <div id="farazsms_fields" data-banta-switcher="farazsms" class="row">

                            <h4 class="card-title">پترن ها</h4>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="denooj_post">پترن ثبت سفارش از طریق پست</label>
                                        <input id="denooj_post" dir="ltr" type="text" name="denooj_post" class="form-control" value="{{old('denooj_post',$settings->denooj_post)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            پترن ثبت سفارش از طریق پست باید شامل یک پارامتر با نام <b>order_id</b> و یک پارامتر با نام <b>name</b> باشد. نمونه صحیح پترن قابل قبول:
                                            <div class="mt-2">
                                                آقا/خانم %name% عزیز 
                                                <br>
                                                سفارش شما با شماره %order_id% با موفقیت ثبت شد.
                                                <br>
                                                در روز های آتی کد پیگیری مرسوله پستی شما پیامک خواهد شد.
                                                <br>
                                                همچنین می توانید محتوای سفارش خود را از طریق لینک زیر مشاهده فرمایید:
                                                <br>
                                                denooj.com/panel/orders/%order_id%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="denooj_ordinary_freightage">پترن ثبت سفارش از طریق باربری در حالت عادی (غیر جشنواره)</label>
                                        <input id="denooj_ordinary_freightage" dir="ltr" type="text" name="denooj_ordinary_freightage" class="form-control" value="{{old('denooj_ordinary_freightage',$settings->denooj_ordinary_freightage)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            پترن ثبت سفارش از طریق باربری در حالت غیر جشنواره باید شامل یک پارامتر با نام <b>order_id</b> و یک پارامتر با نام <b>name</b> باشد. نمونه صحیح پترن قابل قبول:
                                            <div class="mt-2">
                                                آقا/خانم %name% عزیز 
                                                <br>
                                                سفارش شما با شماره %order_id% با موفقیت ثبت شد.
                                                <br>
                                                برنج شما از طریق باربری ارسال خواهد شد.
                                                <br>
                                                به دلیل عدم امکان پرداخت نقدی در مبدا، در زمان تحویل هزینه را حساب کنید و از بارنامه عکس گرفته به همراه شماره کارت برای ما ارسال نمایید تا مبلغ کرایه خدمتتان عودت داده شود.
                                                <br>
                                                همچنین می توانید محتوای سفارش خود را از طریق لینک زیر مشاهده فرمایید:
                                                <br>
                                                denooj.com/panel/orders/%order_id%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <hr>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="denooj_coupon_freightage">پترن ثبت سفارش از طریق باربری در حالت جشنواره</label>
                                        <input id="denooj_coupon_freightage" dir="ltr" type="text" name="denooj_coupon_freightage" class="form-control" value="{{old('denooj_coupon_freightage',$settings->denooj_coupon_freightage)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            پترن ثبت سفارش از طریق باربری در حالت جشنواره باید شامل یک پارامتر با نام <b>order_id</b> و یک پارامتر با نام <b>name</b> باشد. نمونه صحیح پترن قابل قبول:
                                            <div class="mt-2">
                                                آقا/خانم %name% عزیز 
                                                <br>
                                                سفارش شما با شماره %order_id% با موفقیت ثبت شد.
                                                <br>
                                                برنج شما از طریق باربری ارسال خواهد شد.
                                                <br>
                                                هزینه باربری را در زمان تحویل می توانید حساب کنید.
                                                <br>
                                                همچنین می توانید محتوای سفارش خود را از طریق لینک زیر مشاهده فرمایید:
                                                <br>
                                                denooj.com/panel/orders/%order_id%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="denooj_three_days">پترن 3 روز پس از ثبت سفارش</label>
                                        <input id="denooj_three_days" dir="ltr" type="text" name="denooj_three_days" class="form-control" value="{{old('denooj_three_days',$settings->denooj_three_days)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            پترن 3 روز پس از ثبت سفارش باید به صورت زیر باشد:
                                            <div class="mt-2">
                                                برنج دِنوُج
                                                <br>
                                                اگر بابت تحویل سفارشتان، طی ۱۵ روز کاری تماسی حاصل نشد، نام و شهر خودتان را به این شماره پیامک کنید.
                                                <br>
                                                09309003164 رضا
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="denooj_fifteen_days">پترن 15 روز پس از ثبت سفارش</label>
                                        <input id="denooj_fifteen_days" dir="ltr" type="text" name="denooj_fifteen_days" class="form-control" value="{{old('denooj_fifteen_days',$settings->denooj_fifteen_days)}}">

                                        <label class="form-label mt-3" for="denooj_fifteen_days_link">لینک راز پخت برنج</label>
                                        <input id="denooj_fifteen_days_link" dir="ltr" type="text" name="denooj_fifteen_days_link" class="form-control" value="{{old('denooj_fifteen_days_link',$settings->denooj_fifteen_days_link)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            پترن 15 روز پس از ثبت سفارش باید شامل یک پارامتر با نام <b>link</b> و یک پارامتر با نام <b>name</b> باشد. نمونه صحیح پترن قابل قبول:
                                            <div class="mt-2">
                                                آقا/خانم %name% عزیز 
                                                <br>
                                                اگر راز پخت برنج های حاج علی رو نمی‌دونید لینک زیر رو بزنید 
                                                <br>
                                                %link%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-label" for="denooj_fourty_days">پترن 40 روز پس از ثبت سفارش</label>
                                        <input id="denooj_fourty_days" dir="ltr" type="text" name="denooj_fourty_days" class="form-control" value="{{old('denooj_fourty_days',$settings->denooj_fourty_days)}}">

                                        <label class="form-label mt-3" for="denooj_fourty_days_link">لینک نظرسنجی</label>
                                        <input id="denooj_fourty_days_link" dir="ltr" type="text" name="denooj_fourty_days_link" class="form-control" value="{{old('denooj_fourty_days_link',$settings->denooj_fourty_days_link)}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="alert alert-secondary">
                                            پترن 40 روز پس از ثبت سفارش باید شامل یک پارامتر با نام <b>link</b> و یک پارامتر با نام <b>name</b> باشد. نمونه صحیح پترن قابل قبول:
                                            <div class="mt-2">
                                                حاج علی هستم (برنج دِنوُج)    
                                                <br>
                                                آقا/خانم %name% عزیز 
                                                <br>
                                                محصولم تونست رضایت شمارو جلب کنه?!
                                                <br>
                                                ۱. بله
                                                <br>
                                                ۲. خیر
                                                <br>
                                                عدد رو بفرستین 
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
