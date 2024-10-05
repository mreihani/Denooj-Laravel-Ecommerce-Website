@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light"><a href="{{route('users.index')}}">کاربران</a> /</span> ثبت نام کاربر جدید
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <form action="{{route('users.store')}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
        @csrf
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">

                        {{-- first name --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="first_name">نام</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{old('first_name')}}">
                        </div>

                        {{-- last name --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="last_name">نام خانوادگی</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{old('last_name')}}">
                        </div>

                        {{-- password --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="password">کلمه عبور</label>
                            <input type="password" class="form-control" dir="ltr" id="password" name="password" value="{{old('password')}}" autocomplete="new-password">
                        </div>

                        {{-- mobile --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="mobile">موبایل</label>
                            <input type="number" class="form-control" dir="ltr" id="mobile" name="mobile" value="{{old('mobile')}}">
                        </div>

                        {{-- email --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="email">ایمیل (اختیاری)</label>
                            <input type="email" class="form-control" dir="ltr" id="email" name="email" value="{{old('email')}}">
                        </div>

                        {{-- national code --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="national_code">کد ملی (اختیاری)</label>
                            <input type="number" class="form-control" id="national_code" name="national_code" value="{{old('national_code')}}">
                        </div>

                        {{-- avatar --}}
                        <div class="mb-3">
                            <label for="avatar" class="form-label">تصویر آواتار (اختیاری)</label>
                            <input class="form-control" type="file" id="avatar" name="avatar">
                        </div>

                        {{-- submit--}}
                        <div class="col-lg-6">
                            <div class="mb-3 mt-4">
                                <button type="submit" class="btn btn-primary submit-button">ثبت نام کاربر</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>


@endsection

@section('styles')
@endsection
@section('scripts')
@endsection
