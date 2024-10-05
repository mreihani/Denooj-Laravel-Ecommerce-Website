@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">تنظیمات /</span> فاکتور فروش
    </h4>
    @include('admin.includes.alerts')
    <div class="row">
        <div class="col-md-12">
            @include('settings::nav')
            <div class="card mb-4">
                <h5 class="card-header">تنظیمات فاکتور فروش</h5>
                <form action="{{route('settings.factor_update',$settings)}}" method="post" enctype="multipart/form-data" id="mainForm">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="image-chooser">
                                    <label class="form-label" for="logo">آدرس تصویر لوگو</label>
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
                            <div class="col-lg-6 mb-4">
                                <div class="image-chooser">
                                    <label class="form-label" for="logo">آدرس تصویر امضاء فروشنده</label>
                                    @if($settings->signature != null)
                                        <img src="{{$settings->getSignature()}}" alt="signature" class="img-fluid" id="signature-image">
                                        <button type="button" class="btn btn-sm btn-label-danger mb-3 remove-image-file"
                                                data-url="{{$settings->signature}}"
                                                image-id="signature-image" data-input-id="signature">
                                            <i class="bx bxs-trash"></i>
                                            <span>حذف تصویر</span>
                                        </button>
                                    @endif
                                    <input type="text" name="signature" class="form-control" dir="ltr"
                                           id="signature" value="{{old('signature',$settings->signature)}}">
                                </div>
                            </div>

                            <div class="col-lg-4 mb-4">
                                <label for="address" class="form-label">آدرس فروشنده</label>
                                <input class="form-control" type="text" id="address" name="address"
                                       value="{{old('address',$settings->address)}}">
                            </div>
                            <div class="col-lg-4 mb-4">
                                <label for="postcode" class="form-label">کد پستی فروشنده</label>
                                <input class="form-control" type="text" id="postcode" name="postcode"
                                       value="{{old('postcode',$settings->postcode)}}">
                            </div>
                            <div class="col-lg-4 mb-4">
                                <label for="phone" class="form-label">تلفن تماس فروشنده</label>
                                <input class="form-control" type="text" id="phone" name="phone"
                                       value="{{old('phone',$settings->phone)}}">
                            </div>

                            <hr class="my-4">

                            <label class="switch switch-square mb-4">
                                <input type="checkbox" class="switch-input" name="show_user_factor" {{$settings->show_user_factor ? 'checked' : ''}}>
                                <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                <span class="switch-label">امکان مشاهده فاکتور برای مشتری در پروفایل کاربری</span>
                            </label>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-success me-2 submit-button">ذخیره تغییرات</button>
                                <a href="{{route('admin.dashboard')}}" class="btn btn-label-secondary">انصراف</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
