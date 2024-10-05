@extends('front.layouts.user_panel')
@section('panel_content')
    <div class="row">

        {{-- edit user --}}
        <div class="col-lg-6">
            @include('front.alerts')

            <form action="{{route('panel.update_password')}}" id="editForm" method="post">
                @csrf

                <div class="box">
                <h1 class="font-18 fw-bold mb-4">ویرایش کلمه عبور</h1>

                    <p class="text-muted mb-3">کلمه عبور جدیدی برای حساب خود انتخاب کنید.</p>

                    {{-- password --}}
                    <div class="form-floating with-icon mb-4">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="کلمه عبور">
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

                    <div class="col-12">
                        <button class="btn btn-success px-4 py-2" id="btnSubmit"><span>ذخیره کردن اطلاعات</span><i class="icon-arrow-left ms-3"></i></button>
                    </div>
            </div>
            </form>
        </div>

    </div>


@endsection


@section('after_panel_scripts')
    <script src="{{asset('js/jquery.validate.js')}}"></script>
    <script>

        $(document).ready(function () {
            // form validation
            $("#editForm").validate({
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
                    },
                    password_confirmation: {
                        required: true,
                        equalTo : "#password"
                    }
                },
                messages: {
                    password: {
                        required: "کلمه عبور را وارد کنید.",
                    },
                    password_confirmation: {
                        required: "کلمه عبور را مجددا وارد کنید.",
                        equalTo: "کلمه عبور با تکرار آن باید یکسان باشد."
                    }
                }
            });
        });

    </script>
@endsection
