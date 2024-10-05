@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">تنظیمات /</span> ظاهری
    </h4>
    @include('admin.includes.alerts')

    <form action="{{route('settings.appearance_update',$settings)}}" method="post" enctype="multipart/form-data"
          id="mainForm">
        @csrf
        <div class="row">

            {{-- general style --}}
            <div class="col-lg-7">
                <div class="card mb-4">
                    <h5 class="card-header">استایل کلی سایت</h5>
                    <div class="card-body">
                        <div class="row">
                            {{-- favicon --}}
                            <div class="mb-3 col-lg-6">
                                <div class="image-chooser">
                                    <label class="form-label" for="favicon">آدرس تصویر فاوایکن (favicon) سایت</label>
                                    @if($settings->favicon != null)
                                        <img src="{{$settings->getFavicon()}}" alt="img" class="img-fluid"
                                             id="favicon-image">
                                        <button type="button" class="btn btn-sm btn-label-danger mb-3 remove-image-file"
                                                data-url="{{$settings->favicon}}"
                                                image-id="favicon-image" data-input-id="favicon">
                                            <i class="bx bxs-trash"></i>
                                            <span>حذف تصویر</span>
                                        </button>
                                    @endif
                                    <input type="text" name="favicon" class="form-control" dir="ltr"
                                           id="favicon" value="{{old('favicon',$settings->favicon)}}">
                                </div>
                            </div>

                            {{-- font --}}
                            <div class="mb-3 col-lg-6">
                                <label class="form-label" for="site_font">فونت سایت</label>
                                <select class="form-select" name="site_font" id="site_font">
                                    <option value="dana" {{$settings->site_font == 'dana' ? 'selected' :''}}>دانا اعداد
                                        فارسی
                                    </option>
                                    <option
                                        value="peydaweb_fanum" {{$settings->site_font == 'peydaweb_fanum' ? 'selected' :''}}>
                                        پیدا اعداد فارسی
                                    </option>
                                    <option value="peydaweb" {{$settings->site_font == 'peydaweb' ? 'selected' :''}}>
                                        پیدا
                                        اعداد لاتین
                                    </option>
                                    <option
                                        value="yekanbakh_fanum" {{$settings->site_font == 'yekanbakh_fanum' ? 'selected' :''}}>
                                        یکان بخ اعداد فارسی
                                    </option>
                                    <option value="yekanbakh" {{$settings->site_font == 'yekanbakh' ? 'selected' :''}}>
                                        یکان
                                        بخ اعداد لاتین
                                    </option>
                                    <option
                                        value="iransansx_fanum" {{$settings->site_font == 'iransansx_fanum' ? 'selected' :''}}>
                                        ایران سنس x اعداد فارسی
                                    </option>
                                    <option value="iransansx" {{$settings->site_font == 'iransansx' ? 'selected' :''}}>
                                        ایران
                                        سنس x اعداد لاتین
                                    </option>
                                </select>
                            </div>

                            <div class="col-12 mb-4"></div>

                            {{-- main color --}}
                            <div class="mb-3 col-lg-2">
                                <label class="form-label" for="main_color">رنگ اصلی</label>
                                <input id="main_color" type="hidden" name="main_color" class="form-control"
                                       value="{{old('main_color',$settings->main_color)}}">
                                <input id="main_color_rgb" type="hidden" name="main_color_rgb" class="form-control"
                                       value="{{old('main_color_rgb',$settings->main_color_rgb)}}">
                                <div class="color-picker-monolith" data-default-color="{{$settings->main_color}}"
                                     data-input-id="#main_color" data-rgb-input-id="#main_color_rgb"></div>
                            </div>

                            {{-- secondary color --}}
                            <div class="mb-3 col-lg-2">
                                <label class="form-label" for="main_color">رنگ فرعی</label>
                                <input id="secondary_color" type="hidden" name="secondary_color" class="form-control"
                                       value="{{old('secondary_color',$settings->secondary_color)}}">
                                <input id="secondary_color_rgb" type="hidden" name="secondary_color_rgb"
                                       class="form-control"
                                       value="{{old('secondary_color_rgb',$settings->secondary_color_rgb)}}">
                                <div class="color-picker-monolith" data-default-color="{{$settings->secondary_color}}"
                                     data-input-id="#secondary_color" data-rgb-input-id="#secondary_color_rgb"></div>
                            </div>

                            {{-- link color --}}
                            <div class="mb-3 col-lg-2">
                                <label class="form-label" for="link_color">رنگ لینک ها</label>
                                <input id="link_color" type="hidden" name="link_color" class="form-control"
                                       value="{{old('link_color',$settings->link_color)}}">
                                <input id="link_color_rgb" type="hidden" name="link_color_rgb" class="form-control"
                                       value="{{old('link_color_rgb',$settings->link_color_rgb)}}">
                                <div class="color-picker-monolith" data-default-color="{{$settings->link_color}}"
                                     data-input-id="#link_color" data-rgb-input-id="#link_color_rgb"></div>
                            </div>

                            {{-- call button color --}}
                            <div class="mb-3 col-lg-2">
                                <label class="form-label" for="link_color">رنگ دکمه تماس</label>
                                <input id="call_button_color" type="hidden" name="call_button_color"
                                       class="form-control"
                                       value="{{old('call_button_color',$settings->call_button_color)}}">
                                <div class="color-picker-monolith" data-default-color="{{$settings->call_button_color}}"
                                     data-input-id="#call_button_color"></div>
                            </div>

                            {{-- whatsapp button color --}}
                            <div class="mb-3 col-lg-2">
                                <label class="form-label" for="link_color">رنگ دکمه واتساپ</label>
                                <input id="whatsapp_button_color" type="hidden" name="whatsapp_button_color"
                                       class="form-control"
                                       value="{{old('whatsapp_button_color',$settings->whatsapp_button_color)}}">
                                <div class="color-picker-monolith"
                                     data-default-color="{{$settings->whatsapp_button_color}}"
                                     data-input-id="#whatsapp_button_color"></div>
                            </div>

                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success me-2 submit-button">ذخیره تغییرات</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- admin panel --}}
            <div class="col-lg-5">
                <div class="card mb-4">
                    <h5 class="card-header">پنل مدیریت</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="image-chooser">
                                    <label class="form-label" for="admin_logo">آدرس تصویر لوگوی پنل</label>
                                    @if($settings->admin_logo != null)
                                        <img src="{{$settings->getAdminLogo()}}" alt="img" class="img-fluid"
                                             id="admin-logo-image">
                                        <button type="button" class="btn btn-sm btn-label-danger mb-3 remove-image-file"
                                                data-url="{{$settings->admin_logo}}"
                                                image-id="admin-logo-image" data-input-id="admin_logo">
                                            <i class="bx bxs-trash"></i>
                                            <span>حذف تصویر</span>
                                        </button>
                                    @endif
                                    <input type="text" name="admin_logo" class="form-control" dir="ltr"
                                           id="admin_logo" value="{{old('admin_logo',$settings->admin_logo)}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="image-chooser">
                                    <label class="form-label" for="admin_signin_logo">آدرس تصویر لوگوی صفحه ورود</label>
                                    @if($settings->admin_signin_logo != null)
                                        <img src="{{$settings->getAdminLogo()}}" alt="img" class="img-fluid"
                                             id="admin-signin-logo-image">
                                        <button type="button" class="btn btn-sm btn-label-danger mb-3 remove-image-file"
                                                data-url="{{$settings->admin_signin_logo}}"
                                                image-id="admin-signin-logo-image" data-input-id="admin_signin_logo">
                                            <i class="bx bxs-trash"></i>
                                            <span>حذف تصویر</span>
                                        </button>
                                    @endif
                                    <input type="text" name="admin_signin_logo" class="form-control" dir="ltr"
                                           id="admin_signin_logo"
                                           value="{{old('admin_signin_logo',$settings->admin_signin_logo)}}">
                                </div>
                            </div>

                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success me-2 submit-button">ذخیره تغییرات</button>
                        </div>
                    </div>
                </div>
            </div>


            {{-- homepage --}}
            <div class="col-12">
                <div class="card mb-4">
                    <h5 class="card-header">صفحه اصلی</h5>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="home_template">قالب صفحه اصلی</label>
                            <select class="form-select" name="home_template" id="home_template">
                                @php $templates = \Modules\PageBuilder\Entities\Template::all();@endphp
                                @if($templates->count() > 0)
                                @foreach($templates as $template)
                                <option value="{{$template->id}}" {{$template->id == $settings->home_template ? 'selected' :''}}>{{$template->title}}</option>
                                @endforeach
                                @else
                                    <option value="" selected>هیچ قالب وجود ندارد</option>
                                @endif
                            </select>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success me-2 submit-button">ذخیره تغییرات</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

@endsection
