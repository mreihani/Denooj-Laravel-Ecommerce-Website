@extends('front.layouts.signin_layout')
@section('form')
    <form action="{{route('doLoginWithEmail')}}" id="signinForm" method="post">
        @csrf
        <h1 class="title mb-5 mt-3">ورود با ایمیل</h1>

        @if(session('error'))
            <div class="alert alert-danger mb-3">{{session('error')}}</div>
        @endif

        {{-- email --}}
        <div class="form-floating with-icon mb-3">
            <input type="email" class="form-control @error('auth_code') is-invalid @enderror" id="email" name="email"
                   placeholder="ایمیل" autocomplete="off" dir="ltr">
            <i class="icon-user"></i>
            <label for="email">ایمیل</label>
            @error('email')
            <span class="is-invalid">{{$message}}</span>
            @enderror
        </div>

        {{-- password --}}
        <div class="form-floating with-icon mb-4">
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                   placeholder="کلمه عبور" autocomplete="off">
            <i class="icon-lock"></i>
            <label for="password">کلمه عبور</label>
            @error('password')
            <span class="is-invalid">{{$message}}</span>
            @enderror
        </div>

        {{-- remember me --}}
        <div class="text-start mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" name="remember_me" id="rememberMe">
                <label class="form-check-label" for="rememberMe">مرا به خاطر بسپار</label>
            </div>
        </div>

        <div class="signin-form-buttons mb-4">
            <button class="btn btn-primary px-4 py-2 shadow w-100 mb-4" id="btnSubmit"><span>ورود به حساب</span><i class="icon-arrow-left ms-3"></i></button>
            <a href="{{route('login.with_password')}}" class="outlined-link font-14 w-100 mb-2">ورود با شماره موبایل و کلمه عبور</a>
            <a href="{{route('signin')}}" class="outlined-link font-14 w-100">ورود با کد یکبار مصرف</a>
        </div>

        <div class="d-flex align-items-center justify-content-center mt-3 pb-3">
            <a href="/" class="underline-link color-main font-14">بازگشت به سایت</a>
            <a href="{{route('signin').'?type=forget'}}" class="underline-link font-14 ms-4">فراموشی کلمه عبور</a>
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
                email: {
                    required: true,
                },
                password: {
                    required: true
                }
            },
            messages: {
                password: {
                    required: "کلمه عبور را وارد کنید"
                },
                email: {
                    email: 'یک ایمیل صحیح وارد کنید.',
                    required: "ایمیل خود را وارد کنید.",
                },
            }
        });
    </script>
@endsection
