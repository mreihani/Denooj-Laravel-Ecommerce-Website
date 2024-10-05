@extends('front.layouts.signin_layout')
@section('form')
    <form action="{{route('doVerify')}}" id="signinForm" method="post">
        @csrf
        <h1 class="title mb-5 mt-3">ورود کد یکبار مصرف</h1>

        @if(session('auth_code'))
            <div class="alert alert-danger">{{session('auth_code')}}</div>
        @endif

        <p class="text-muted font-13">کد پنج رقمی ارسال شده به شماره موبایل {{session('mobile')}} را در کادر پایین وارد کنید.</p>

        <button class="border-0 bg-transparent underline-link font-13 mb-4" type="button" onclick="resendAuthCode(this)">کد را دریافت نکردید؟ ارسال دوباره</button>

        <input type="hidden" name="mobile" value="{{session('mobile')}}">
        <input type="hidden" name="remember_me" value="{{session('remember_me')}}">
        <input type="hidden" name="type" value="{{session('type')}}">

        {{-- code --}}
        <div class="form-floating with-icon mb-4">
            <input type="text" class="form-control @error('auth_code') is-invalid @enderror" id="auth_code" name="auth_code"
                   placeholder="کد یکبار مصرف" autofocus autocomplete="false" dir="ltr">
            <i class="icon-user"></i>
            <label for="auth_code">کد یکبار مصرف</label>
            @error('auth_code')
            <span class="is-invalid">{{$message}}</span>
            @enderror
        </div>

        <div class="mb-4">
            <button class="btn btn-primary px-4 py-2 shadow" id="btnSubmit"><span>ورود به حساب کاربری</span><i class="icon-arrow-left ms-3"></i></button>
        </div>



        <div class="d-flex align-items-start justify-content-center flex-wrap mb-3">
{{--            <a href="/" class="underline-link font-14 me-4">بازگشت به سایت</a>--}}
            <a href="{{route('signin')}}" class="underline-link font-14">بازگشت به صفحه ورود</a>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        function resendAuthCode(btn){
            let mobile = $('input[name=mobile]').val();
            let data = new FormData();
            data.append('mobile', mobile);

            $(btn).addClass('loading');

            $.ajax({
                method: 'POST',
                url: '/resend-code/',
                data: data,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': _token},
                error: function () {
                    $(btn).removeClass('loading');
                }
            }).done(function (data) {
                Toast.fire({
                    icon: data['status'],
                    title: data['msg']
                })
            }).always(function () {
                $(btn).removeClass('loading');
            });
        }


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
                auth_code: {
                    required: true,
                    number: true,
                    minlength: 5,
                    maxlength: 5
                }
            },
            messages: {
                auth_code: {
                    required: "کد فعالسازی را وارد کنید.",
                    number:"کد فعالسازی باید اعداد با کیبورد انگلیسی باشد.",
                    minlength:"کد فعالسازی باید 5 رقم باشد",
                    maxlength:"کد فعالسازی باید 5 رقم باشد",
                },
            }
        });
    </script>
@endsection
