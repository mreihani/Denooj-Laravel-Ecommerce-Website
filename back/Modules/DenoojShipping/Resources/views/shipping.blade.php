@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">تنظیمات /</span> حمل و نقل اختصاصی دنوج
    </h4>
    @include('admin.includes.alerts')

    <div class="row">
        <div class="col-md-12">
            @include('settings::nav')
            <form action="{{route('settings.denooj-shipping_update',$settings)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">

                            <div class="mt-5 d-flex justify-content-end me-5">
                                <button type="submit" class="btn btn-success me-2 submit-button">ذخیره تغییرات
                                </button>
                                <a href="{{route('admin.dashboard')}}" class="btn btn-label-secondary">انصراف</a>
                            </div>

                            <h5 class="card-header">روش‌های حمل و نقل</h5>
                            <div class="card-body">

                                {{-- freightage --}}
                                <div class="mb-4">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <label class="switch switch-square">
                                                <input type="checkbox" class="switch-input check-toggle"
                                                       data-toggle=".freightage-fields"
                                                       name="freightage" {{$settings->freightage ? 'checked' : ''}}>
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on"><i class="bx bx-check"></i></span>
                                                    <span class="switch-off"><i class="bx bx-x"></i></span>
                                                </span>
                                                <span class="switch-label">باربری</span>
                                            </label>
                                            <small class="d-block text-muted mt-2">
                                                در این روش هزینه ای هنگام ثبت سفارش
                                                توسط مشتری پراخت نمیشود بلکه بعد از تحویل مرسوله، هزینه ارسال توسط مشتری
                                                به شرکت باربری پرداخت میشود. 
                                            </small>

                                            <div class="mt-3 freightage-fields {{$settings->freightage ? '': 'd-none'}}">
                                                <label for="freightage_title" class="form-label">عنوان باربری</label>
                                                <input class="form-control" type="text" id="freightage_title"
                                                       name="freightage_title"
                                                       value="{{old('freightage_title',$settings->freightage_title)}}">
                                            </div>

                                        </div>
                                        <div class="col-lg-4">
                                            <div class="image-chooser freightage-fields {{$settings->freightage ? '': 'd-none'}}">
                                                <label class="form-label" for="freightage_logo">آدرس تصویر روش
                                                    باربری</label>
                                                @if($settings->freightage_logo != null)
                                                    <img src="{{$settings->getFreightageLogo()}}" alt="img" class="img-fluid"
                                                         id="freightage-logo-image">
                                                    <button type="button"
                                                            class="btn btn-sm btn-label-danger mb-3 remove-image-file"
                                                            data-url="{{$settings->freightage_logo}}"
                                                            image-id="freightage-logo-image" data-input-id="freightage_logo">
                                                        <i class="bx bxs-trash"></i>
                                                        <span>حذف تصویر</span>
                                                    </button>
                                                @endif
                                                <input type="text" name="freightage_logo" class="form-control" dir="ltr"
                                                       id="freightage_logo"
                                                       value="{{old('freightage_logo',$settings->freightage_logo)}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                {{-- post --}}
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <label class="switch switch-square">
                                                <input type="checkbox" class="switch-input check-toggle"
                                                       data-toggle=".post-fields"
                                                       name="post" {{$settings->post ? 'checked' : ''}}>
                                                <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                                <span class="switch-label">پست</span>
                                            </label>
                                            <small class="d-block text-muted mt-2">
                                                یکی از مرسوم ترین روش های ارسال مرسولات،
                                                ارسال از طریق سامانه پست ملی ایران است. در این روش مدیر سایت یک هزینه ثابت برای
                                                ارسال تعریف میکند و با توجه به وزن محصول هزینه پستی محاسبه میشود.
                                            </small>

                                            <div class="mt-3 post-fields {{$settings->post ? '': 'd-none'}}">
                                                <label for="post_title" class="form-label">عنوان روش پست</label>
                                                <input class="form-control" type="text" id="post_title"
                                                       name="post_title"
                                                       value="{{old('post_title',$settings->post_title)}}">
                                            </div>

                                            <hr class="my-4 post-fields {{$settings->post ? '': 'd-none'}}">

                                            <div class="mt-3 post-fields {{$settings->post ? '': 'd-none'}}">
                                                <label for="post_cost_five" class="form-label">هزینه ارسال 5 کیلوگرم کالا از طریق پست در حالت عادی
                                                    </label>
                                                <div class="input-group">
                                                    <input type="number" dir="ltr" class="form-control" name="post_cost_five"
                                                           id="post_cost_five"
                                                           value="{{old('post_cost_five',$settings->post_cost_five)}}">
                                                    <span class="input-group-text">تومان</span>
                                                </div>
                                            </div>
                                            <div class="mt-3 post-fields {{$settings->post ? '': 'd-none'}}">
                                                <label for="post_cost_ten" class="form-label">هزینه ارسال 10 کیلوگرم کالا از طریق پست در حالت عادی</label>
                                                <div class="input-group">
                                                    <input type="number" dir="ltr" class="form-control" name="post_cost_ten"
                                                           id="post_cost_ten"
                                                           value="{{old('post_cost_ten',$settings->post_cost_ten)}}">
                                                    <span class="input-group-text">تومان</span>
                                                </div>
                                            </div>
                                            <div class="mt-3 post-fields {{$settings->post ? '': 'd-none'}}">
                                                <label for="post_cost_twenty" class="form-label">هزینه ارسال 20 کیلوگرم کالا از طریق پست در حالت عادی</label>
                                                <div class="input-group">
                                                    <input type="number" dir="ltr" class="form-control" name="post_cost_twenty"
                                                           id="post_cost_twenty"
                                                           value="{{old('post_cost_twenty',$settings->post_cost_twenty)}}">
                                                    <span class="input-group-text">تومان</span>
                                                </div>
                                            </div>

                                            <hr class="my-4 post-fields {{$settings->post ? '': 'd-none'}}">

                                            <div class="mt-3 post-fields {{$settings->post ? '': 'd-none'}}">
                                                <label for="post_cost_off_five" class="form-label">هزینه ارسال 5 کیلوگرم کالا از طریق پست در زمان جشنواره
                                                    </label>
                                                <div class="input-group">
                                                    <input type="number" dir="ltr" class="form-control" name="post_cost_off_five"
                                                           id="post_cost_off_five"
                                                           value="{{old('post_cost_off_five',$settings->post_cost_off_five)}}">
                                                    <span class="input-group-text">تومان</span>
                                                </div>
                                            </div>

                                            <div class="mt-3 post-fields {{$settings->post ? '': 'd-none'}}">
                                                <label for="post_cost_off_ten" class="form-label">هزینه ارسال 10 کیلوگرم کالا از طریق پست در زمان جشنواره
                                                    </label>
                                                <div class="input-group">
                                                    <input type="number" dir="ltr" class="form-control" name="post_cost_off_ten"
                                                           id="post_cost_off_ten"
                                                           value="{{old('post_cost_off_ten',$settings->post_cost_off_ten)}}">
                                                    <span class="input-group-text">تومان</span>
                                                </div>
                                            </div>

                                            <div class="mt-3 post-fields {{$settings->post ? '': 'd-none'}}">
                                                <label for="post_cost_off_twenty" class="form-label">هزینه ارسال 20 کیلوگرم کالا از طریق پست در زمان جشنواره
                                                    </label>
                                                <div class="input-group">
                                                    <input type="number" dir="ltr" class="form-control" name="post_cost_off_twenty"
                                                           id="post_cost_off_twenty"
                                                           value="{{old('post_cost_off_twenty',$settings->post_cost_off_twenty)}}">
                                                    <span class="input-group-text">تومان</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="image-chooser post-fields {{$settings->post ? '': 'd-none'}}">
                                                <label class="form-label" for="post_logo">آدرس تصویر روش
                                                    پست</label>
                                                @if($settings->post_logo != null)
                                                    <img src="{{$settings->getPostLogo()}}" alt="img" class="img-fluid"
                                                         id="post-logo-image">
                                                    <button type="button"
                                                            class="btn btn-sm btn-label-danger mb-3 remove-image-file"
                                                            data-url="{{$settings->post_logo}}"
                                                            image-id="post-logo-image" data-input-id="post_logo">
                                                        <i class="bx bxs-trash"></i>
                                                        <span>حذف تصویر</span>
                                                    </button>
                                                @endif
                                                <input type="text" name="post_logo" class="form-control" dir="ltr"
                                                       id="post_logo"
                                                       value="{{old('post_logo',$settings->post_logo)}}">
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
