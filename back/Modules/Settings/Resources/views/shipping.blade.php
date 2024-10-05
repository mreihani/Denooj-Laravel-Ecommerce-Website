@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">تنظیمات /</span> حمل و نقل
    </h4>
    @include('admin.includes.alerts')

    <div class="alert alert-warning">
        <b>توجه: </b>
        برای انجام صحیح تنظیمات حمل و نقل لطفا حتما توضیحات مربوطه در PDF راهنمای محصول را مطالعه کنید.
    </div>
    <div class="row">
        <div class="col-md-12">
            @include('settings::nav')
            <form action="{{route('settings.shipping_update',$settings)}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <h5 class="card-header">روش‌های حمل و نقل</h5>
                            <div class="card-body">

                                @if(!$settings->tipax && !$settings->post_pishtaz && !$settings->bike)
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <h6 class="alert-heading mb-1"><i class="bx bx-error me-2"></i>هیچ روش ارسالی
                                            فعال
                                            نیست!
                                        </h6>
                                        <span>در وضعیت فعلی امکان ثبت سفارش توسط مشتریان وجود نخواهد داشت!</span>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                    </div>
                                @endif

                                {{-- tipax --}}
                                <div class="mb-4">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <label class="switch switch-square">
                                                <input type="checkbox" class="switch-input check-toggle"
                                                       data-toggle=".tipax-fields"
                                                       name="tipax" {{$settings->tipax ? 'checked' : ''}}>
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on"><i class="bx bx-check"></i></span>
                                                    <span class="switch-off"><i class="bx bx-x"></i></span>
                                                </span>
                                                <span class="switch-label">پس کرایه</span>
                                            </label>
                                            <small class="d-block text-muted mt-2">در این روش هزینه ای هنگام ثبت سفارش
                                                توسط مشتری پراخت نمیشود بلکه بعد از تحویل مرسوله، هزینه ارسال توسط مشتری
                                                به شرکت حمل و نقل پرداخت میشود. مناسب برای تیپاکس و غیره</small>

                                            <div class="mt-3 tipax-fields {{$settings->tipax ? '': 'd-none'}}">
                                                <label for="tipax_title" class="form-label">عنوان روش پس کرایه</label>
                                                <input class="form-control" type="text" id="tipax_title"
                                                       name="tipax_title"
                                                       value="{{old('tipax_title',$settings->tipax_title)}}">
                                            </div>

                                        </div>
                                        <div class="col-lg-4">
                                            <div class="image-chooser tipax-fields {{$settings->tipax ? '': 'd-none'}}">
                                                <label class="form-label" for="tipax_logo">آدرس تصویر روش
                                                    پس کرایه</label>
                                                @if($settings->tipax_logo != null)
                                                    <img src="{{$settings->getTipaxLogo()}}" alt="img" class="img-fluid"
                                                         id="tipax-logo-image">
                                                    <button type="button"
                                                            class="btn btn-sm btn-label-danger mb-3 remove-image-file"
                                                            data-url="{{$settings->tipax_logo}}"
                                                            image-id="tipax-logo-image" data-input-id="tipax_logo">
                                                        <i class="bx bxs-trash"></i>
                                                        <span>حذف تصویر</span>
                                                    </button>
                                                @endif
                                                <input type="text" name="tipax_logo" class="form-control" dir="ltr"
                                                       id="tipax_logo"
                                                       value="{{old('tipax_logo',$settings->tipax_logo)}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                {{-- pishtaz --}}
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <label class="switch switch-square">
                                                <input type="checkbox" class="switch-input check-toggle"
                                                       data-toggle=".pishtaz-fields"
                                                       name="post_pishtaz" {{$settings->post_pishtaz ? 'checked' : ''}}>
                                                <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                                <span class="switch-label">پست پیشتاز</span>
                                            </label>
                                            <small class="d-block text-muted mt-2">یکی از مرسوم ترین روش های ارسال مرسولات،
                                                ارسال از طریق سامانه پست ملی ایران است. در این روش مدیر سایت یک هزینه ثابت برای
                                                ارسال تعریف میکند و با توجه به وزن محصول هزینه پستی محاسبه میشود.</small>

                                            <div class="mt-3 pishtaz-fields {{$settings->post_pishtaz ? '': 'd-none'}}">
                                                <label for="post_pishtaz_title" class="form-label">عنوان روش پست پیشتاز</label>
                                                <input class="form-control" type="text" id="post_pishtaz_title"
                                                       name="post_pishtaz_title"
                                                       value="{{old('post_pishtaz_title',$settings->post_pishtaz_title)}}">
                                            </div>

                                            <div class="mt-3 pishtaz-fields {{$settings->post_pishtaz ? '': 'd-none'}}">
                                                <label for="cost_post_pishtaz" class="form-label">هزینه ثابت ارسال با پست
                                                    پیشتاز</label>
                                                <div class="input-group">
                                                    <input type="number" dir="ltr" class="form-control" name="cost_post_pishtaz"
                                                           id="cost_post_pishtaz"
                                                           value="{{old('cost_post_pishtaz',$settings->cost_post_pishtaz)}}">
                                                    <span class="input-group-text">تومان</span>
                                                </div>
                                            </div>
                                            <div class="mt-3 pishtaz-fields {{$settings->post_pishtaz ? '': 'd-none'}}">
                                                <label for="cost_post_pishtaz_kilogram" class="form-label">هزینه به ازای هر یک کیلوگرم اضافه وزن</label>
                                                <div class="input-group">
                                                    <input type="number" dir="ltr" class="form-control" name="cost_post_pishtaz_kilogram"
                                                           id="cost_post_pishtaz_kilogram"
                                                           value="{{old('cost_post_pishtaz_kilogram',$settings->cost_post_pishtaz_kilogram)}}">
                                                    <span class="input-group-text">تومان</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="image-chooser pishtaz-fields {{$settings->post_pishtaz ? '': 'd-none'}}">
                                                <label class="form-label" for="post_pishtaz_logo">آدرس تصویر روش
                                                    پست پیشتاز</label>
                                                @if($settings->post_pishtaz_logo != null)
                                                    <img src="{{$settings->getPishtazLogo()}}" alt="img" class="img-fluid"
                                                         id="pishtaz-logo-image">
                                                    <button type="button"
                                                            class="btn btn-sm btn-label-danger mb-3 remove-image-file"
                                                            data-url="{{$settings->post_pishtaz_logo}}"
                                                            image-id="pishtaz-logo-image" data-input-id="post_pishtaz_logo">
                                                        <i class="bx bxs-trash"></i>
                                                        <span>حذف تصویر</span>
                                                    </button>
                                                @endif
                                                <input type="text" name="post_pishtaz_logo" class="form-control" dir="ltr"
                                                       id="post_pishtaz_logo"
                                                       value="{{old('post_pishtaz_logo',$settings->post_pishtaz_logo)}}">
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                {{-- bike --}}
                                <div class="mb-4">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <label class="switch switch-square">
                                                <input type="checkbox" class="switch-input check-toggle" data-toggle=".bike-fields"
                                                       name="bike" {{$settings->bike ? 'checked' : ''}}>
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on"><i class="bx bx-check"></i></span>
                                                    <span class="switch-off"><i class="bx bx-x"></i></span>
                                                </span>
                                                <span class="switch-label">پیک درون شهری</span>
                                            </label>
                                            <small class="d-block text-muted mt-2">روش ارسال با پیک را میتوانید برای شهر های مورد نظر خود فعال کنید، هزینه پیک مانند روش پست پیشتاز محاسبه میشود.</small>

                                            <div class="mt-3 bike-fields {{$settings->bike ? '': 'd-none'}}">
                                                <label for="bike_title" class="form-label">عنوان روش پیک درون شهری</label>
                                                <input class="form-control" type="text" id="bike_title"
                                                       name="bike_title"
                                                       value="{{old('bike_title',$settings->bike_title)}}">
                                            </div>

                                            <div class="mt-3 bike-fields {{$settings->bike ? '': 'd-none'}}">
                                                <label for="cost_bike" class="form-label">هزینه ارسال با پیک درون شهری</label>
                                                <div class="input-group">
                                                    <input type="number" dir="ltr" class="form-control" name="cost_bike"
                                                           id="cost_bike"
                                                           value="{{old('cost_bike',$settings->cost_bike)}}">
                                                    <span class="input-group-text">تومان</span>
                                                </div>
                                            </div>

                                            <div class="mt-3 pishtaz-fields {{$settings->bike ? '': 'd-none'}}">
                                                <label for="cost_bike_kilogram" class="form-label">هزینه به ازای هر یک کیلوگرم اضافه وزن</label>
                                                <div class="input-group">
                                                    <input type="number" dir="ltr" class="form-control" name="cost_bike_kilogram"
                                                           id="cost_bike_kilogram"
                                                           value="{{old('cost_bike_kilogram',$settings->cost_bike_kilogram)}}">
                                                    <span class="input-group-text">تومان</span>
                                                </div>
                                            </div>


                                            {{-- category --}}
                                            <div class="select2-primary bike-fields {{$settings->bike ? '': 'd-none'}} mt-3">
                                                <label class="form-label" for="bike_cities">شهرهای تحت پوشش (ضروری)</label>
                                                <select class="select2 form-select" id="bike_cities" name="bike_cities[]" data-allow-clear="true"
                                                        multiple required>
                                                    @foreach(\Modules\Users\Entities\City::all() as $city)
                                                        <option value="{{$city->id}}" @if(old('bike_cities'))
                                                            {{ in_array($city->id,old('bike_cities')) ? 'selected' : '' }}
                                                            @elseif($settings->bike_cities != null)
                                                            {{ in_array($city->id, $settings->bike_cities) ? 'selected' : '' }}
                                                            @endif>{{'استان '. $city->getProvince->name . ': شهر ' . $city->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                        </div>
                                        <div class="col-lg-4">
                                            <div class="image-chooser bike-fields {{$settings->bike ? '': 'd-none'}}">
                                                <label class="form-label" for="post_pishtaz_logo">آدرس تصویر روش
                                                    پیک درون شهری</label>
                                                @if($settings->bike_logo != null)
                                                    <img src="{{$settings->getBikeLogo()}}" alt="img" class="img-fluid"
                                                         id="bike-logo-image">
                                                    <button type="button"
                                                            class="btn btn-sm btn-label-danger mb-3 remove-image-file"
                                                            data-url="{{$settings->bike_logo}}"
                                                            image-id="bike-logo-image" data-input-id="bike_logo">
                                                        <i class="bx bxs-trash"></i>
                                                        <span>حذف تصویر</span>
                                                    </button>
                                                @endif
                                                <input type="text" name="bike_logo" class="form-control" dir="ltr"
                                                       id="bike_logo"
                                                       value="{{old('bike_logo',$settings->bike_logo)}}">
                                            </div>

                                        </div>

                                    </div>

                                </div>





                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <h5 class="card-header">ارسال رایگان</h5>

                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="free_shipping_limit" class="form-label">ارسال رایگان برای سفارشات
                                        بالای:</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="free_shipping_limit"
                                               name="free_shipping_limit"
                                               value="{{old('free_shipping_limit',$settings->free_shipping_limit)}}">
                                        <span class="input-group-text">تومان</span>
                                    </div>
                                    <small class="d-block text-muted mt-1">هزینه ارسال برای سفارشات بالار از مبلغ وارد شده رایگان خواهد بود. (فقط روش پیک موتوری و پست)</small>
                                    <small class="d-block text-warning mt-1">در صورتی که ارسال رایگان ندارید این فیلد را خال بگذارید.</small>
                                </div>


                                <div class="mt-5">
                                    <button type="submit" class="btn btn-success me-2 submit-button">ذخیره تغییرات
                                    </button>
                                    <a href="{{route('admin.dashboard')}}" class="btn btn-label-secondary">انصراف</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
