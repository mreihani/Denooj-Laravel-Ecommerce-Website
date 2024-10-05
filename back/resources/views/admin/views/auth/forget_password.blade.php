@extends('admin.layouts.auth')
@section('content')
    <h4 class="mb-2">فراموشی کلمه عبور</h4>

    @include('admin.includes.alerts')
    <form id="formAuthentication" class="mb-3 needs-validation" action="{{route('admin.password_email')}}" method="POST" novalidate>
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">ایمیل</label>
            <input type="text" class="form-control text-start" dir="ltr" id="email" name="email" placeholder="ایمیل خود را وارد کنید" autofocus>
        </div>

        <div class="mb-3">
            <button class="btn btn-primary d-grid w-100 submit-button d-flex align-items-center justify-content-center" type="submit">بازیابی کلمه عبور</button>
        </div>

        <a href="{{route('admin.login')}}" class="text-center mt-2 d-block">
            <small>بازگشت به صفحه ورود</small>
        </a>
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
