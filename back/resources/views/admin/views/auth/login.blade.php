@extends('admin.layouts.auth')
@section('content')
    <h4 class="mb-2">به {{config('app.app_name_fa')}} خوش آمدید!</h4>
    <p class="mb-4">وارد حساب خود شده و ماجراجویی را شروع کنید</p>

    @include('admin.includes.alerts')
    <form id="formAuthentication" class="mb-3 needs-validation" action="{{route('admin.do_login')}}" method="POST" novalidate>
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">ایمیل</label>
            <input type="text" class="form-control text-start" dir="ltr" id="email" name="email" placeholder="ایمیل خود را وارد کنید" autofocus>
        </div>
        <div class="mb-3 form-password-toggle">
            <div class="d-flex justify-content-between">
                <label class="form-label" for="password">رمز عبور</label>
                <a href="{{route('admin.password_request')}}">
                    <small>رمز عبور را فراموش کردید؟</small>
                </a>
            </div>
            <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control text-start" dir="ltr" name="password" placeholder="············" aria-describedby="password">
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
        </div>
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                <label class="form-check-label" for="remember"> به خاطر سپاری </label>
            </div>
        </div>
        <div class="mb-3">
            <button class="btn btn-primary d-grid w-100 submit-button d-flex align-items-center justify-content-center" type="submit">ورود</button>
        </div>
    </form>

@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/pages/page-auth.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('admin/assets/js/pages-auth.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
@endsection
