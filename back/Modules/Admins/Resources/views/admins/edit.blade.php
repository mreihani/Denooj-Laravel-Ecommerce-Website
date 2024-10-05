@extends('admin.layouts.panel')
@section('content')
    <div class="d-flex align-items-center justify-content-between py-3 mb-4">
        <h4 class="m-0 breadcrumb-wrapper">
            <span class="text-muted fw-light"><a href="{{route('admins.index')}}">مدیرها</a> /</span> ویرایش
        </h4>
        <a href="{{route('admins.create')}}" class="dt-button create-new btn btn-primary"><span><i class="bx bx-user-plus me-sm-2"></i> <span class="d-none d-sm-inline-block">ثبت نام مدیر جدید</span></span></a>
    </div>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <form action="{{route('admins.update',$admin)}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
        @csrf
        @method('PATCH')
        <div class="col-lg-6">
            <div class="card mb-4">
                <h5 class="card-header">اطلاعات کاربری</h5>

                <div class="card-body">
                    <div class="row">

                        {{-- avatar --}}
                        <div class="mb-3 col-12">
                            <label for="avatar" class="form-label">تصویر آواتار (اختیاری)</label>
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
                                    <small class="mb-0 d-block">فایل‌های JPG، GIF یا PNG مجاز هستند. حداکثر اندازه فایل 5MB.</small>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- name --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="name">نام</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{old('name',$admin->name)}}">
                        </div>

                        {{-- email --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="email">ایمیل</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{old('email',$admin->email)}}">
                        </div>

                        {{-- password --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="password">کلمه عبور جدید</label>
                            <input type="password" class="form-control" dir="ltr" id="password" name="password" autocomplete="new-password">
                        </div>

                        {{-- mobile --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="mobile">موبایل (اختیاری)</label>
                            <input type="number" class="form-control" dir="ltr" id="mobile" name="mobile" value="{{old('mobile',$admin->mobile)}}">
                        </div>

                        {{-- role --}}
                        <div class="mb-3 col-12">
                            <label class="form-label" for="role">نقش</label>
                            <select class="form-select" name="role" id="role">
                                @php $roles = \Spatie\Permission\Models\Role::all();@endphp
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}" {{$admin->hasRole($role->name) ? 'selected' : ''}}>{{$role->label}}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- bio --}}
                        <div class="mb-3 col-12">
                            <label class="form-label" for="bio">بیوگرافی (اختیاری)</label>
                            <textarea class="form-control" rows="3" id="bio" name="bio">{{old('bio',$admin->bio)}}</textarea>
                        </div>

                        {{-- submit--}}
                        <div class="col-lg-6">
                            <div class="mb-3 mt-4">
                                <button type="submit" class="btn btn-primary submit-button">ویرایش اطلاعات</button>
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
                            <input class="form-control text-start" dir="ltr" type="text" id="instagram" name="instagram" value="{{old('instagram',$admin->instagram)}}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="twitter" class="form-label">توییتر</label>
                            <input class="form-control text-start" dir="ltr" type="text" id="twitter" name="twitter" value="{{old('twitter',$admin->twitter)}}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="facebook" class="form-label">فیس بوک</label>
                            <input class="form-control text-start" dir="ltr" type="text" id="facebook" name="facebook" value="{{old('facebook',$admin->facebook)}}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="linkedin" class="form-label">Linkedin</label>
                            <input class="form-control text-start" dir="ltr" type="text" id="linkedin" name="linkedin" value="{{old('linkedin',$admin->linkedin)}}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="telegram" class="form-label">تلگرام</label>
                            <input class="form-control text-start" dir="ltr" type="text" id="telegram" name="telegram" value="{{old('telegram',$admin->telegram)}}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="dribbble" class="form-label">Dribbble</label>
                            <input class="form-control text-start" dir="ltr" type="text" id="dribbble" name="dribbble" value="{{old('dribbble',$admin->dribble)}}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="youtube" class="form-label">یوتیوب</label>
                            <input class="form-control text-start" dir="ltr" type="text" id="youtube" name="youtube" value="{{old('youtube',$admin->youtube)}}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="soundcloud" class="form-label">ساندکلود</label>
                            <input class="form-control text-start" dir="ltr" type="text" id="soundcloud" name="soundcloud" value="{{old('soundcloud',$admin->soundcloud)}}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="pinterest" class="form-label">پینترست</label>
                            <input class="form-control text-start" dir="ltr" type="text" id="pinterest" name="pinterest" value="{{old('pinterest',$admin->pinterest)}}">
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
