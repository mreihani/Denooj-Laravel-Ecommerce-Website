@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">تنظیمات /</span> صفحه ورود
    </h4>
    @include('admin.includes.alerts')
    <div class="row">
        <div class="col-md-12">
            @include('settings::nav')
            <div class="card mb-4">
                <h5 class="card-header">تنظیمات صفحه ورود کاربران</h5>
                <form action="{{route('settings.signin_update',$settings)}}" method="post" enctype="multipart/form-data" id="mainForm">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="image-chooser">
                                    <label class="form-label" for="logo">آدرس لوگو</label>
                                    @if($settings->logo != null)
                                        <img src="{{$settings->getLogo()}}" alt="img" class="img-fluid" id="logo-image">
                                        <button type="button" class="btn btn-sm btn-label-danger mb-3 remove-image-file"
                                                data-url="{{$settings->logo}}"
                                                image-id="logo-image" data-input-id="logo">
                                            <i class="bx bxs-trash"></i>
                                            <span>حذف تصویر</span>
                                        </button>
                                    @endif
                                    <input type="text" name="logo" class="form-control" dir="ltr"
                                           id="logo" value="{{old('logo',$settings->logo)}}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="image-chooser">
                                    <label class="form-label" for="signin-input">آدرس تصویر</label>
                                    @if($settings->image != null)
                                        <img src="{{$settings->getImage()}}" alt="img" class="img-fluid" id="signin-image">
                                        <button type="button" class="btn btn-sm btn-label-danger mb-3 remove-image-file"
                                                data-url="{{$settings->image}}"
                                                image-id="signin-image" data-input-id="signin-input">
                                            <i class="bx bxs-trash"></i>
                                            <span>حذف تصویر</span>
                                        </button>
                                    @endif
                                    <input type="text" name="image" class="form-control" dir="ltr"
                                           id="signin-input" value="{{old('image',$settings->image)}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-lg-4">
                                <label for="title" class="form-label">عنوان باکس ورود</label>
                                <input class="form-control" type="text" id="title" name="title"
                                       value="{{old('title',$settings->title)}}">
                            </div>

                            {{-- bg color --}}
                            <div class="mb-3 col-lg-4">
                                <label class="form-label" for="bg_color">رنگ بک گراند</label>
                                <input id="bg_color" type="hidden" name="bg_color" class="form-control" value="{{old('bg_color',$settings->bg_color)}}">
                                <div class="color-picker-monolith" data-default-color="{{$settings->bg_color}}" data-input-id="#bg_color"></div>
                            </div>
                        </div>


                        <div class="mt-4">
                            <button type="submit" class="btn btn-success me-2 submit-button">ذخیره تغییرات</button>
                            <a href="{{route('admin.dashboard')}}" class="btn btn-label-secondary">انصراف</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
