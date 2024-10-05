@extends('admin.layouts.panel')
@section('content')
    <div class="d-flex align-items-center justify-content-between py-3 mb-4">
        <h4 class="m-0 breadcrumb-wrapper">
            <span class="text-muted fw-light"><a href="{{route('users.index')}}">کاربران</a> /</span> ویرایش
        </h4>
        <a href="{{route('users.create')}}" class="dt-button create-new btn btn-primary"><span><i class="bx bx-user-plus me-sm-2"></i> <span class="d-none d-sm-inline-block">ثبت نام کاربر جدید</span></span></a>
    </div>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <form action="{{route('users.update',$user)}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
        @csrf
        @method('PATCH')
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">

                        {{-- first name --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="first_name">نام</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{old('first_name',$user->first_name)}}">
                        </div>

                        {{-- last name --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="last_name">نام خانوادگی</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{old('last_name',$user->last_name)}}">
                        </div>

                        {{-- password --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="password">کلمه عبور جدید</label>
                            <input type="password" class="form-control" dir="ltr" id="password" name="password" value="{{old('password')}}" autocomplete="new-password">
                        </div>

                        {{-- mobile --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="mobile">موبایل</label>
                            <input type="number" class="form-control" dir="ltr" id="mobile" name="mobile" value="{{old('mobile',$user->mobile)}}">
                        </div>

                        {{-- email --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="email">ایمیل (اختیاری)</label>
                            <input type="email" class="form-control" dir="ltr" id="email" name="email" value="{{old('email',$user->email)}}">
                        </div>

                        {{-- national code --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="national_code">کد ملی (اختیاری)</label>
                            <input type="number" class="form-control" id="national_code" name="national_code" value="{{old('national_code',$user->national_code)}}">
                        </div>

                        {{-- avatar --}}
                        <div class="mb-3 col-lg-4">
                            <label for="avatar" class="form-label">تصویر جدید</label>
                            <input class="form-control" type="file" id="avatar" name="avatar">
                        </div>

                        @if($user->avatar)
                            <div class="col-lg-3 mb-3">
                                <input type="hidden" id="remove_avatar" name="remove_avatar">
                                <div class="pt-4">
                                    <a href="{{$user->getAvatar()}}" target="_blank">
                                        <img src="{{$user->getAvatar('thumb')}}" alt="image" class="w-px-40 h-auto rounded" id="avatarImage">
                                    </a>
                                    <span class="btn btn-sm btn-danger remove-image-file" data-url="{{$user->avatar['original']}}"
                                          input-id="remove_avatar" image-id="avatarImage"><i class="bx bx-trash"></i></span>
                                </div>
                            </div>
                        @endif


                        {{-- submit--}}
                        <div class="col-lg-6">
                            <div class="mb-3 mt-4">
                                <button type="submit" class="btn btn-primary submit-button">ذخیره اطلاعات</button>
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
