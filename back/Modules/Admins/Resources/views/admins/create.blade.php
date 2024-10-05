@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light"><a href="{{route('admins.index')}}">مدیرها</a> /</span> ثبت نام مدیر جدید
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <form action="{{route('admins.store')}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
        @csrf
        <div class="col-lg-6">
            <div class="card mb-4">
                <h5 class="card-header">اطلاعات کاربری</h5>

                <div class="card-body">
                    <div class="row">

                        {{-- name --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="name">نام</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
                        </div>

                        {{-- email --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="email">ایمیل</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{old('email')}}">
                        </div>

                        {{-- password --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="password">کلمه عبور</label>
                            <input type="password" class="form-control" dir="ltr" id="password" name="password" autocomplete="new-password">
                        </div>

                        {{-- mobile --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="mobile">موبایل (اختیاری)</label>
                            <input type="number" class="form-control" dir="ltr" id="mobile" name="mobile" value="{{old('mobile')}}">
                        </div>

                        {{-- role --}}
                        <div class="mb-3 col-12">
                            <label class="form-label" for="role">نقش</label>
                            <select class="form-select" name="role" id="role">
                                @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                    <option value="{{$role->id}}">{{$role->label}}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- bio --}}
                        <div class="mb-3 col-12">
                            <label class="form-label" for="bio">بیوگرافی (اختیاری)</label>
                            <textarea class="form-control" rows="3" id="bio" name="bio">{{old('bio')}}</textarea>
                        </div>

                        {{-- avatar --}}
                        <div class="mb-3">
                            <label for="avatar" class="form-label">تصویر آواتار (اختیاری)</label>
                            <input class="form-control" type="file" id="avatar" name="avatar">
                        </div>

                        {{-- submit--}}
                        <div class="col-lg-6">
                            <div class="mb-3 mt-4">
                                <button type="submit" class="btn btn-primary submit-button">ایجاد حساب کاربری</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <h5 class="card-header">شبکه های اجتماعی</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="instagram" class="form-label">اینستاگرام</label>
                            <input class="form-control text-start" dir="ltr" type="text" id="instagram" name="instagram" value="{{old('instagram')}}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="twitter" class="form-label">توییتر</label>
                            <input class="form-control text-start" dir="ltr" type="text" id="twitter" name="twitter" value="{{old('twitter')}}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="facebook" class="form-label">فیس بوک</label>
                            <input class="form-control text-start" dir="ltr" type="text" id="facebook" name="facebook" value="{{old('facebook')}}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="linkedin" class="form-label">Linkedin</label>
                            <input class="form-control text-start" dir="ltr" type="text" id="linkedin" name="linkedin" value="{{old('linkedin')}}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="telegram" class="form-label">تلگرام</label>
                            <input class="form-control text-start" dir="ltr" type="text" id="telegram" name="telegram" value="{{old('telegram')}}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="dribbble" class="form-label">Dribbble</label>
                            <input class="form-control text-start" dir="ltr" type="text" id="dribbble" name="dribbble" value="{{old('dribbble')}}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="youtube" class="form-label">یوتیوب</label>
                            <input class="form-control text-start" dir="ltr" type="text" id="youtube" name="youtube" value="{{old('youtube')}}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="soundcloud" class="form-label">ساندکلود</label>
                            <input class="form-control text-start" dir="ltr" type="text" id="soundcloud" name="soundcloud" value="{{old('soundcloud')}}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="pinterest" class="form-label">پینترست</label>
                            <input class="form-control text-start" dir="ltr" type="text" id="pinterest" name="pinterest" value="{{old('pinterest')}}">
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
