@extends('front.layouts.signin_layout')
<?php $signinSettings = \Modules\Settings\Entities\SigninSetting::first(); ?>

@section('form')
    <form action="{{route('doSignin')}}" id="signinForm" method="post">
        @csrf
        <h1 class="title mb-5 mt-3">{{$signinSettings->title}}</h1>

        @if(session()->has('type') && session('type') == 'forget')
            <input type="hidden" name="type" value="forget">
        @endif

        <div class="form-floating with-icon mb-3">
            <input type="text" class="form-control @error('auth_code') is-invalid @enderror" id="mobile" name="mobile"
                   placeholder="شماره موبایل" autofocus dir="ltr">
            <i class="icon-user"></i>
            <label for="mobile">شماره موبایل</label>
            @error('mobile')
            <span class="is-invalid">{{$message}}</span>
            @enderror
        </div>

        {{-- remember me --}}
        <div class="text-start mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember_me" id="rememberMe">
                <label class="form-check-label" for="rememberMe">مرا به خاطر بسپار</label>
            </div>
        </div>

        <div class="signin-form-buttons mb-4">
            <button class="btn btn-primary px-4 py-2 shadow w-100 mb-4" id="btnSubmit"><span>دریافت کد یکبار مصرف</span><i class="icon-arrow-left ms-3"></i></button>
            <a href="{{route('login.with_password')}}" class="outlined-link font-14 w-100 mb-2">ورود با شماره موبایل و کلمه عبور</a>
            <!-- <a href="{{route('login.with_email')}}" class="outlined-link font-14 w-100">ورود با ایمیل و کلمه عبور</a> -->
        </div>

        <div class="d-flex align-items-center justify-content-center mt-3 pb-3">
            <a href="/" class="underline-link color-main font-14">بازگشت به سایت</a>
        </div>

    </form>
@endsection

@section('scripts')
    <script>
        $("#signinForm").validate({
            errorClass: "is-invalid",
            errorElement: "span",
            errorPlacement: function(error, element) {
                error.appendTo( element.parent('.form-floating') );
            },
            submitHandler: function(form) {
                $('#btnSubmit').addClass('loading');
                form.submit();
            },
            rules: {
                mobile: {
                    required: true,
                    number: true,
                    minlength: 11,
                    maxlength: 11
                }
            },
            messages: {
                mobile: {
                    required: "شماره موبایل خود را وارد کنید.",
                    number:"شماره موبایل باید اعداد با کیبورد انگلیسی باشد.",
                    minlength:"شماره موبایل باید 11 رقم باشد",
                    maxlength:"شماره موبایل باید 11 رقم باشد",
                },
            }
        });
    </script>
@endsection