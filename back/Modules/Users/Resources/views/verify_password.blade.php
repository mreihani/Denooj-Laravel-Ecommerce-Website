@extends('front.layouts.user_panel')
@section('panel_content')
    <div class="row">

        {{-- edit user --}}
        <div class="col-lg-6">
            @include('front.alerts')

            <form action="{{route('panel.do_verify_password')}}" id="editForm" method="post">
                @csrf
                <input type="hidden" name="password" value="{{session('password')}}">

                <div class="box">
                <h1 class="font-18 fw-bold mb-4">ویرایش کلمه عبور</h1>

                    <p class="text-muted mb-3">کد 5 رقمی ارسال شده به شماره موبایل خود را در فیلد زیر وارد کنید.</p>

                    {{-- code --}}
                    <div class="form-floating with-icon mb-4">
                        <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code"
                               placeholder="کد یکبار مصرف" autofocus autocomplete="false">
                        <i class="icon-user"></i>
                        <label for="code">کد یکبار مصرف</label>
                        @error('code')
                        <span class="is-invalid">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-12">
                        <button class="btn btn-success px-4 py-2" id="btnSubmit"><span>ذخیره کلمه عبور</span><i class="icon-arrow-left ms-3"></i></button>
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
