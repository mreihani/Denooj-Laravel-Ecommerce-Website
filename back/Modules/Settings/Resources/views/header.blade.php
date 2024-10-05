@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">تنظیمات /</span> سربرگ (Header)
    </h4>
    @include('admin.includes.alerts')
    <div class="row">
        <div class="col-md-12">
            @include('settings::nav')
            <div class="card mb-4">
                <h5 class="card-header">تنظیمات سربرگ (Header)</h5>
                <form action="{{route('settings.header_update',$settings)}}" method="post" enctype="multipart/form-data" id="mainForm">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="image-chooser">
                                    <label class="form-label" for="header_logo">آدرس تصویر لوگو</label>
                                    @if($settings->header_logo != null)
                                    <img src="{{$settings->getHeaderLogo()}}" alt="img" class="img-fluid" id="header-logo-image">
                                    <button type="button" class="btn btn-sm btn-label-danger mb-3 remove-image-file"
                                            data-url="{{$settings->header_logo}}"
                                            image-id="header-logo-image" data-input-id="header_logo">
                                        <i class="bx bxs-trash"></i>
                                        <span>حذف تصویر</span>
                                    </button>
                                    @endif
                                    <input type="text" name="header_logo" class="form-control" dir="ltr"
                                           id="header_logo" value="{{old('header_logo',$settings->header_logo)}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="header_search_placeholder" class="form-label">متن پیشفرض کادر جستجو</label>
                            <input class="form-control" type="text" id="header_search_placeholder" name="header_search_placeholder"
                                   value="{{old('header_search_placeholder',$settings->header_search_placeholder)}}">
                        </div>

                        {{-- search recommendation --}}
                        <div class="mb-3">
                            <label class="form-label" for="search_recommendation">پیشنهادهای جستجو</label>
                            <?php $recommendation = $settings->search_recommendation;
                            if (is_array($settings->search_recommendation)) $recommendation = implode(',',$settings->search_recommendation); ?>
                            <input id="search_recommendation" class="form-control tagify-select" name="search_recommendation" value="{{old('search_recommendation',$recommendation)}}">
                            <small class="d-block text-muted mt-1">کلمه را بنوسید و سپس اینتر بزنید</small>
                        </div>

                    </div>
                    <hr class="my-0">
                    <h5 class="card-header">پشتیبانی</h5>
                    <div class="card-body">
                        <label class="switch switch-square mb-4">
                            <input type="checkbox" class="switch-input" name="display_header_support" {{$settings->display_header_support ? 'checked' : ''}}>
                            <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                            <span class="switch-label">نمایش متن پشتیباتی</span>
                        </label>

                        <div class="row" >
                            <div class="mb-3 col-md-3">
                                <label for="header_support_text" class="form-label">متن پشتیبانی</label>
                                <input class="form-control text-start" type="text" id="header_support_text" name="header_support_text"
                                       value="{{old('header_support_text',$settings->header_support_text)}}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="header_support_link_text" class="form-label">متن لینک</label>
                                <input class="form-control text-start" type="text" id="header_support_link_text" name="header_support_link_text"
                                       value="{{old('header_support_link_text',$settings->header_support_link_text)}}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="header_support_link" class="form-label">لینک</label>
                                <input class="form-control" dir="ltr" type="text" id="header_support_link" name="header_support_link"
                                       value="{{old('header_support_link',$settings->header_support_link)}}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="header_support_icon" class="form-label">آیکن <a href="{{route('admin.icons')}}" class="ms-2">(آیکن‌ها)</a></label>
                                <input class="form-control" dir="ltr" type="text" id="header_support_icon" name="header_support_icon"
                                       value="{{old('header_support_icon',$settings->header_support_icon)}}">
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
