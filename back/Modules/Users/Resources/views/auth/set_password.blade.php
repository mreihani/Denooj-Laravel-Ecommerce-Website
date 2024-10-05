@extends('front.layouts.signin_layout')
@section('form')
    <form action="{{route('reset_password')}}" id="signinForm" method="post">
        @csrf
        <h1 class="title mb-5 mt-3">انتخاب کلمه عبور</h1>

        @include('front.alerts')

        <p class="text-muted font-13">برای حساب خود یک کلمه عبور انتخاب کنید.</p>

        {{-- password --}}
        <div class="form-floating with-icon mb-4">
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="کلمه عبور" autocomplete="new-password" autofocus>
            <i class="icon-lock"></i>
            <label for="password">کلمه عبور</label>
            @error('password')
            <span class="is-invalid">{{$message}}</span>
            @enderror
        </div>

        {{-- password confirmation --}}
        <div class="form-floating with-icon mb-4">
            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="تکرار کلمه عبور">
            <i class="icon-lock"></i>
            <label for="password_confirmation">تکرار کلمه عبور</label>
            @error('password_confirmation')
            <span class="is-invalid">{{$message}}</span>
            @enderror
        </div>

        <div class="mb-4">
            <button class="btn btn-primary px-4 py-2 shadow" id="btnSubmit"><span>ذخیره کلمه عبور</span><i class="icon-arrow-left ms-3"></i></button>
        </div>

        <div class="d-flex align-items-start justify-content-center flex-wrap mb-3">
            <a href="/" class="underline-link font-14 me-4">بازگشت به سایت</a>
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
                password: {
                    required: true,
                    minlength: 8,
                    maxlength: 30
                },
                password_confirmation: {
                    required: true,
                    minlength: 8,
                    equalTo : "#password"
                }
            },
            messages: {
                password: {
                    required: "کلمه عبور را وارد کنید.",
                    minlength:"کلمه عبور یا حداقل 8 حرف باشد",
                    maxlength:"کلمه عبور خیلی طولانی است.",
                },
                password_confirmation: {
                    required: "کلمه عبور را وارد کنید.",
                    minlength:"کلمه عبور یا حداقل 8 حرف باشد",
                    maxlength:"کلمه عبور خیلی طولانی است.",
                    equalTo:"کلمه عبور با تکرار آن یکسان نیست.",
                },
            }
        });
    </script>
@endsection
