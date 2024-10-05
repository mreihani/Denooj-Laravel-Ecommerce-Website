@extends('front.layouts.user_panel')
@section('panel_content')
    <div class="row">

        {{-- edit user --}}
        <div class="col-lg-8 mb-3">
            @include('front.alerts')

            <form action="{{route('panel.update')}}" id="editForm" method="post">
                @csrf
                <input type="hidden" id="defaultImage" value="{{asset('assets/images/avatar.jpg')}}">
                <div class="box">
                <h1 class="font-18 fw-bold mb-4">اطلاعات حساب من</h1>

                <div class="d-flex flex-wrap">
                    {{-- avatar --}}
                    <div class="d-flex align-items-center user-image-upload croppie-image me-lg-4 mb-4">
                        <input type="hidden" name="avatar" class="croppie-input" value="{{json_encode($user->avatar)}}"/>
                        <div class="square-image">
                            <img src="{{$user->getAvatar(true)}}" alt="{{$user->getFullName()}}">
                        </div>

                        <div class="d-flex flex-column file-upload-container">
                            <span class="btn btn-sm btn-outline-danger rounded-pill mb-2 btnCroppieRemoveImage {{$user->avatar == '' ? 'd-none':''}}">
                                <i class="icon-x"></i></span>

                            <div class="fileUpload btn btn-sm btn-primary pr-3 pl-3">
                                <span><i class="icon-camera font-24"></i></span>
                                <input type="file" class="upload upload_input"
                                       accept="image/x-png,image/gif,image/jpeg"/>
                            </div>
                        </div>
                    </div>

                    {{-- fields --}}
                    <div class="row">
                        {{-- first name --}}
                        <div class="col-lg-4 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                       id="first_name" name="first_name" placeholder="نام" value="{{old('first_name',$user->first_name)}}">
                                <label for="first_name">نام</label>
                                @error('first_name')
                                <span class="is-invalid">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- last name --}}
                        <div class="col-lg-4 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                       id="last_name" name="last_name" placeholder="نام خانوادگی" value="{{old('last_name',$user->last_name)}}">
                                <label for="last_name">نام خانوادگی</label>
                                @error('last_name')
                                <span class="is-invalid">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- mobile --}}
                        <div class="col-lg-4 mb-3">
                            <div class="form-floating" data-bs-toggle="tooltip" data-bs-placement="top" title="شماره موبایل قابل ویرایش نیست">
                                <input type="text" class="form-control"
                                       id="mobile" placeholder="شماره موبایل" value="{{$user->mobile}}" readonly>
                                <label for="mobile">شماره موبایل</label>
                            </div>
                        </div>

                        {{-- national code --}}
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('national_code') is-invalid @enderror"
                                       id="national_code" name="national_code" placeholder="کد ملی" value="{{old('national_code',$user->national_code)}}">
                                <label for="national_code">کد ملی</label>
                                @error('national_code')
                                <span class="is-invalid">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- email --}}
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" placeholder="ایمیل" value="{{old('email',$user->email)}}">
                                <label for="email">ایمیل</label>
                                @error('email')
                                <span class="is-invalid">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <button class="btn btn-success px-4 py-2" id="btnSubmit"><span>ذخیره کردن اطلاعات</span><i class="icon-arrow-left ms-3"></i></button>

                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>

        {{-- reset password --}}
        <div class="col-lg-4">
            <div class="box">
                <span class="form-title d-block mb-3">تغییر کلمه عبور حساب کاربری</span>

                <p class="text-muted font-13 mb-3">این کار نیازمند ورود کد یکبار مصرف میباشد.</p>
                <a href="{{route('panel.reset_password')}}" class="btn btn-primary"><i class="icon-lock"></i> ویرایش کلمه عبور</a>
            </div>
        </div>
    </div>

    @include('users::user_panel.image-upload-modal')

@endsection
@section('panel_styles')
    <link rel="stylesheet" href="{{asset('assets/css/croppie.css')}}">
@endsection
@section('before_panel_scripts')
    <script src="{{asset('assets/js/croppie.js')}}"></script>
@endsection
@section('after_panel_scripts')
    <script src="{{asset('assets/js/jquery.validate.js')}}"></script>
    <script>
        initCroppie('/croppie/user/avatar/');

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
                    first_name: {
                        required: true,
                    },
                    last_name: {
                        required: true,
                    },
                    email: {
                        email: true
                    },
                    national_code: {
                        required: true,
                        minlength:10,
                        maxlength:10
                    }
                },
                messages: {
                    first_name: {
                        required: "وارد کردن نام ضروری است.",
                    },
                    last_name: {
                        required: "وارد کردن نام خانوادگی ضروری است.",
                    },
                    national_code: {
                        required: "وارد کردن کد ملی ضروری است.",
                        minlength:"کدملی باید 10 رقم باشد.",
                        maxlength:"کدملی باید 10 رقم باشد."
                    },
                    email: {
                        email: "لطفا یک ایمیل معتبر وارد کنید",
                    },
                }
            });
        });

    </script>
@endsection
