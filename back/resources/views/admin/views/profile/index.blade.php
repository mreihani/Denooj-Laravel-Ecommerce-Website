@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">تنظیمات حساب /</span> حساب
    </h4>
    @include('admin.includes.alerts')
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('admin.profile')}}"><i class="bx bx-user me-1"></i> حساب</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.profile.security')}}"><i class="bx bx-lock-alt me-1"></i> امنیت</a>
                </li>
            </ul>
            <div class="card mb-4">
                <h5 class="card-header">جزئیات پروفایل</h5>
                <form action="{{route('admin.update',$admin)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Account -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <input type="hidden" name="remove_avatar_image" id="remove_avatar_image">
                            <img src="{{$admin->getAvatar()}}" alt="{{$admin->name}}" class="d-block rounded" height="100" width="100" id="avatarImage">
                            <div class="button-wrapper">
                                <label for="avatar" class="btn btn-secondary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">ارسال تصویر جدید</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="avatar" name="avatar" class="account-file-input" hidden accept="image/png, image/jpeg">
                                </label>
                                @if($admin->avatar != null)
                                    <button type="button" class="btn btn-label-secondary account-image-reset mb-4 remove-image-file" data-url="{{$admin->avatar}}" image-id="avatarImage" input-id="remove_avatar_image">
                                        <i class="bx bx-reset d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">بازنشانی</span>
                                    </button>
                                @endif
                                <p class="mb-0">فایل‌های JPG، GIF یا PNG مجاز هستند. حداکثر اندازه فایل 5MB.</p>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="name" class="form-label">نام</label>
                                <input class="form-control" type="text" id="name" name="name" value="{{old('name',$admin->name)}}" autofocus>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="email" class="form-label">ایمیل</label>
                                <input class="form-control text-start" dir="ltr" type="text" id="email" name="email" value="{{old('email',$admin->email)}}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label" for="mobile">شماره تلفن</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">IR (+98)</span>
                                    <input type="text" id="mobile" name="mobile" value="{{old('mobile',$admin->mobile)}}" class="form-control text-start" dir="ltr">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="bio">بیوگرافی</label>
                                <textarea type="text" id="bio" name="bio" class="form-control text-start">{{old('bio',$admin->bio)}}</textarea>
                            </div>
                        </div>

                    </div>
                    <hr class="my-0">
                    <h5 class="card-header">شبکه های اجتماعی</h5>

                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="instagram" class="form-label">اینستاگرام</label>
                                <input class="form-control text-start" dir="ltr" type="text" id="instagram" name="instagram" value="{{old('instagram',$admin->instagram)}}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="twitter" class="form-label">توییتر</label>
                                <input class="form-control text-start" dir="ltr" type="text" id="twitter" name="twitter" value="{{old('twitter',$admin->twitter)}}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="facebook" class="form-label">فیس بوک</label>
                                <input class="form-control text-start" dir="ltr" type="text" id="facebook" name="facebook" value="{{old('facebook',$admin->facebook)}}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="linkedin" class="form-label">Linkedin</label>
                                <input class="form-control text-start" dir="ltr" type="text" id="linkedin" name="linkedin" value="{{old('linkedin',$admin->linkedin)}}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="telegram" class="form-label">تلگرام</label>
                                <input class="form-control text-start" dir="ltr" type="text" id="telegram" name="telegram" value="{{old('telegram',$admin->telegram)}}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="dribbble" class="form-label">Dribbble</label>
                                <input class="form-control text-start" dir="ltr" type="text" id="dribbble" name="dribbble" value="{{old('dribbble',$admin->dribbble)}}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="youtube" class="form-label">یوتیوب</label>
                                <input class="form-control text-start" dir="ltr" type="text" id="youtube" name="youtube" value="{{old('youtube',$admin->youtube)}}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="soundcloud" class="form-label">ساندکلود</label>
                                <input class="form-control text-start" dir="ltr" type="text" id="soundcloud" name="soundcloud" value="{{old('soundcloud',$admin->soundcloud)}}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="pinterest" class="form-label">پینترست</label>
                                <input class="form-control text-start" dir="ltr" type="text" id="pinterest" name="pinterest" value="{{old('pinterest',$admin->pinterest)}}">
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-success me-2">ذخیره تغییرات</button>
                            <a href="{{route('admin.dashboard')}}" class="btn btn-label-secondary">بازگشت</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
