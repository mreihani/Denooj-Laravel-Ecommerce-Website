@extends('admin.layouts.auth')
@section('content')
    @include('admin.includes.alerts')

    <div class="text-center">
        <p class="mb-4 text-success">لینک بازیابی کلمه عبور به ایمیل شما ارسال شد.</p>
        <a href="{{route('admin.login')}}" class="btn btn-primary">
            <small>بازگشت به صفحه ورود</small>
        </a>
    </div>

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
