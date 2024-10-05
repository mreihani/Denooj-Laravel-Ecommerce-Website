@extends('admin.layouts.auth')
@section('content')
    <h4 class="mb-2 ">فعالسازی اسکریپت</h4>
    <p class="mb-4">برای استفاده از اسکریپت، اطلاعات خرید خود را وارد کنید</p>

    @include('admin.includes.alerts')

    <form id="formAuthentication" class="mb-3 needs-validation" action="{{route('license')}}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label">نام کاربری</label>
            <input type="text" class="form-control text-start" dir="ltr" id="username" value="{{old('username',$settings->username)}}" name="username" placeholder="نام کاربری شما در راستچین" required>
        </div>

        <div class="mb-3">
            <label for="order_id" class="form-label">شماره سفارش</label>
            <input type="text" class="form-control text-start" dir="ltr" id="order_id" value="{{old('order_id',$settings->order_id)}}" name="order_id" placeholder="شماره سفارش شما در راستچین" required>
        </div>

        <div class="mb-3">
            <button class="btn btn-success d-grid w-100 submit-button d-flex align-items-center justify-content-center" type="submit">فعالسازی اسکریپت</button>
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
