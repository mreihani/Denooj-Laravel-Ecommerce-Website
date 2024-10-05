@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">تنظیمات /</span> عمومی
    </h4>
    @include('admin.includes.alerts')
    <div class="row">
        <div class="col-md-12">
            @include('settings::nav')
            <form action="{{route('settings.general_update',$settings)}}" method="post" enctype="multipart/form-data">
                @csrf

                {{-- home page seo --}}
                <div class="card mb-4">
                    <h5 class="card-header">تنظیمات سئوی صفحه اصلی</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">

                                    {{-- h1 title --}}
                                    <div class="mb-3 col-lg-6">
                                        <label class="form-label" for="home_h1_hidden">تگ H1 مخفی</label>
                                        <input id="home_h1_hidden" type="text" name="home_h1_hidden" class="form-control" value="{{old('home_h1_hidden',$settings->home_h1_hidden)}}">
                                    </div>

                                    {{-- nav title --}}
                                    <div class="mb-3 col-lg-6">
                                        <label class="form-label" for="home_nav_title">عنوان تگ h2 مخفی در nav</label>
                                        <input id="home_nav_title" type="text" name="home_nav_title" class="form-control" value="{{old('home_nav_title',$settings->home_nav_title)}}">
                                    </div>

                                    {{-- title tag --}}
                                    <div class="mb-3 col-12">
                                        <label class="form-label" for="home_title_tag">تگ title</label>
                                        <input id="home_title_tag" type="text" name="home_title_tag" class="form-control" value="{{old('home_title_tag',$settings->home_title_tag)}}">
                                    </div>

                                    {{-- OG image --}}
                                    <div class="mb-3 col-lg-6">
                                        <label class="form-label" for="home_og_image">آدرس og image</label>
                                        <input id="home_og_image" type="text" dir="ltr" name="home_og_image" class="form-control" value="{{old('home_og_image',$settings->home_og_image)}}">
                                    </div>

                                    {{-- OG image width--}}
                                    <div class="mb-3 col-lg-3">
                                        <label class="form-label" for="home_og_image_width">طول تصویر og</label>
                                        <input id="home_og_image_width" type="text" dir="ltr" name="home_og_image_width" class="form-control" value="{{old('home_og_image_width',$settings->home_og_image_width)}}">
                                    </div>

                                    {{-- OG image width--}}
                                    <div class="mb-3 col-lg-3">
                                        <label class="form-label" for="home_og_image_height">ارتفاع تصویر og</label>
                                        <input id="home_og_image_height" type="text" dir="ltr" name="home_og_image_height" class="form-control" value="{{old('home_og_image_height',$settings->home_og_image_height)}}">
                                    </div>

                                    {{-- OG video --}}
{{--                                    <div class="mb-3 col-lg-6">--}}
{{--                                        <label class="form-label" for="home_og_video">آدرس og video</label>--}}
{{--                                        <input id="home_og_video" type="text" dir="ltr" name="home_og_video" class="form-control" value="{{old('home_og_video',$settings->home_og_video)}}">--}}
{{--                                    </div>--}}

                                    {{-- meta description --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="home_meta_description">متای توضیحات</label>
                                        <textarea id="home_meta_description" name="home_meta_description" class="form-control">{{old('home_meta_description',$settings->home_meta_description)}}</textarea>
                                    </div>

                                    {{-- seo description --}}
{{--                                    <div class="mb-3">--}}
{{--                                        <label class="form-label" for="home_seo_description">توضیحات سئو</label>--}}
{{--                                        <textarea type="hidden" name="home_seo_description" id="home_seo_description" class="tinymceeditor">{{old('home_seo_description',$settings->home_seo_description)}}</textarea>--}}
{{--                                    </div>--}}

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-success me-2 submit-button">ذخیره تغییرات</button>
                                    </div>
                                </div>
                            </div>

                            {{-- faq --}}
{{--                            <div class="col-lg-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label for="faq_title" class="form-label">سوالات متداول صفحه اصلی</label>--}}
{{--                                    <div id="faq-items">--}}
{{--                                        @if($settings->home_faq)--}}
{{--                                            @foreach($settings->home_faq as $item)--}}
{{--                                                <?php $itemName = \Illuminate\Support\Str::random(6);?>--}}
{{--                                                <div class='row align-items-end' id='faq_row_{{$itemName}}'>--}}
{{--                                                    <div class='mb-3 col-12'>--}}
{{--                                                        <label for="item_faq_{{$itemName}}" class="form-label">عنوان</label>--}}
{{--                                                        <input class="form-control text-start" type="text" id="item_faq_{{$itemName}}" name="item_faq_{{$itemName}}[]"--}}
{{--                                                               value="{{old('item_faq_' . $itemName,$item[0])}}">--}}
{{--                                                    </div>--}}

{{--                                                    <div class='mb-3 col-12'>--}}
{{--                                                        <label for="item_faq_{{$itemName}}" class="form-label">متن</label>--}}
{{--                                                        <textarea class="form-control text-start" type="text" id="item_faq_{{$itemName}}" name="item_faq_{{$itemName}}[]">{{old('item_faq_' . $itemName,$item[1])}}</textarea>--}}
{{--                                                    </div>--}}

{{--                                                    <div class='mb-3 col-lg-2'>--}}
{{--                                                        <span class='btn btn-label-danger btn-remove-faq' data-delete='faq_row_{{$itemName}}'><i class='bx bx-trash'></i></span>--}}
{{--                                                    </div>--}}

{{--                                                    <div class='col-12'><hr></div>--}}
{{--                                                </div>--}}
{{--                                            @endforeach--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
{{--                                    <span class="btn btn-primary add-more-faq"><i class="bx bx-plus"></i> افزودن آیتم</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                        </div>
                    </div>
                </div>

                {{-- call buttons --}}
                <div class="card mb-4">
                    <h5 class="card-header">دکمه های تماس</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <label class="switch switch-square mb-4">
                                    <input type="checkbox" class="switch-input" name="display_whatsapp_btn" {{$settings->display_whatsapp_btn ? 'checked' : ''}}>
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                    <span class="switch-label">نمایش دکمه واتساپ</span>
                                </label>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="whatsapp_btn_title" class="form-label">عنوان دکمه واتساپ</label>
                                <input class="form-control" type="text" id="whatsapp_btn_title" name="whatsapp_btn_title"
                                       value="{{old('whatsapp_btn_title',$settings->whatsapp_btn_title)}}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="whatsapp_btn_number" class="form-label">شماره دکمه واتساپ همراه با +98</label>
                                <input class="form-control" dir="ltr" type="text" id="whatsapp_btn_number" name="whatsapp_btn_number"
                                       value="{{old('whatsapp_btn_number',$settings->whatsapp_btn_number)}}">
                            </div>
                            <div class="col-12">
                                <label class="switch switch-square mb-4">
                                    <input type="checkbox" class="switch-input" name="display_call_btn" {{$settings->display_call_btn ? 'checked' : ''}}>
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                    <span class="switch-label">نمایش دکمه تماس</span>
                                </label>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="call_btn_title" class="form-label">عنوان دکمه تماس</label>
                                <input class="form-control" type="text" id="call_btn_title" name="call_btn_title"
                                       value="{{old('call_btn_title',$settings->call_btn_title)}}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="call_btn_number" class="form-label">شماره دکمه تماس</label>
                                <input class="form-control" dir="ltr" type="text" id="call_btn_number" name="call_btn_number"
                                       value="{{old('call_btn_number',$settings->call_btn_number)}}">
                            </div>

                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success me-2 submit-button">ذخیره تغییرات</button>
                        </div>
                    </div>
                </div>

                {{-- social networks --}}
                <div class="card mb-4">
                    <h5 class="card-header">شبکه های اجتماعی</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="twitter" class="form-label">تویتتر</label>
                                <input class="form-control" dir="ltr" type="text" id="twitter" name="twitter"
                                       value="{{old('twitter',$settings->twitter)}}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="instagram" class="form-label">اینستاگرام</label>
                                <input class="form-control" dir="ltr" type="text" id="instagram" name="instagram"
                                       value="{{old('instagram',$settings->instagram)}}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="youtube" class="form-label">یوتیوب</label>
                                <input class="form-control" dir="ltr" type="text" id="youtube" name="youtube"
                                       value="{{old('youtube',$settings->youtube)}}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="linkedin" class="form-label">لینکداین</label>
                                <input class="form-control" dir="ltr" type="text" id="linkedin" name="linkedin"
                                       value="{{old('linkedin',$settings->linkedin)}}">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="telegram" class="form-label">تلگرام</label>
                                <input class="form-control" dir="ltr" type="text" id="telegram" name="telegram"
                                       value="{{old('telegram',$settings->telegram)}}">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="facebook" class="form-label">فیس بوک</label>
                                <input class="form-control" dir="ltr" type="text" id="facebook" name="facebook"
                                       value="{{old('linkedin',$settings->facebook)}}">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="pinterest" class="form-label">پینترست</label>
                                <input class="form-control" dir="ltr" type="text" id="pinterest" name="pinterest"
                                       value="{{old('pinterest',$settings->pinterest)}}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="whatsapp" class="form-label">واتساپ</label>
                                <input class="form-control" dir="ltr" type="text" id="whatsapp" name="whatsapp"
                                       value="{{old('whatsapp',$settings->whatsapp)}}">
                            </div>

                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success me-2 submit-button">ذخیره تغییرات</button>
                        </div>
                    </div>
                </div>

                {{-- 404 page --}}
                <div class="card mb-4">
                    <h5 class="card-header">صفحه خطای 404</h5>
                    <div class="card-body">
                        {{-- title --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="page_404_title">عنوان صفحه</label>
                            <input id="page_404_title" type="text" name="page_404_title" class="form-control" value="{{old('page_404_title',$settings->page_404_title)}}">
                        </div>

                        {{-- image --}}
                        <div class="col-lg-4">
                            <div class="image-chooser">
                                <label class="form-label" for="page_404_image">آدرس تصویر</label>
                                @if($settings->page_404_image != null)
                                    <img src="{{$settings->get404Image()}}" alt="img" class="img-fluid" id="image404">
                                    <button type="button" class="btn btn-sm btn-label-danger mb-3 remove-image-file"
                                            data-url="{{$settings->page_404_image}}"
                                            image-id="image404" data-input-id="page_404_image">
                                        <i class="bx bxs-trash"></i>
                                        <span>حذف تصویر</span>
                                    </button>
                                @endif
                                <input type="text" name="page_404_image" class="form-control" dir="ltr"
                                       id="page_404_image" value="{{old('page_404_image',$settings->page_404_image)}}">
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success me-2 submit-button">ذخیره تغییرات</button>
                        </div>
                    </div>
                </div>

                {{-- comment text --}}
                <div class="card mb-4">
                    <h5 class="card-header">محتوای مدال ثبت دیدگاه</h5>
                    <div class="card-body">
                        {{-- comment text --}}
                        <div class="mb-3">
                            <label class="form-label" for="comment_text">قوانین و ثبت دیدگاه</label>
                            <textarea type="hidden" name="comment_text" id="comment_text" class="tinymceeditor">{{old('comment_text',$settings->comment_text)}}</textarea>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success me-2 submit-button">ذخیره تغییرات</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
