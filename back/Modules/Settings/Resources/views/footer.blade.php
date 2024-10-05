@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">تنظیمات /</span> پابرگ (Footer)
    </h4>
    @include('admin.includes.alerts')
    <div class="row">
        <div class="col-md-12">
            @include('settings::nav')
            <div class="card mb-4">
                <h5 class="card-header">آیکن باکس ها</h5>
                <form action="{{route('settings.footer_update',$settings)}}" method="post" enctype="multipart/form-data" id="mainForm">
                    @csrf
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12 mb-3">
                                <div class="image-chooser">
                                    <label class="form-label" for="footer_icon1">آدرس آیکن اول</label>
                                    @if($settings->footer_icon1 != null)
                                        <img src="{{$settings->getIcon1()}}" alt="img" class="img-fluid" id="icon1-image">
                                        <button type="button" class="btn btn-sm btn-label-danger mb-3 remove-image-file"
                                                data-url="{{$settings->footer_icon1}}" image-id="icon1-image" data-input-id="footer_icon1">
                                            <i class="bx bxs-trash"></i>
                                            <span>حذف تصویر</span>
                                        </button>
                                    @endif
                                    <input type="text" name="footer_icon1" class="form-control" dir="ltr"
                                           id="footer_icon1" value="{{old('footer_icon1',$settings->footer_icon1)}}">

                                    <label for="footer_icon1_title" class="form-label mt-3">عنوان آیکن اول</label>
                                    <input class="form-control" type="text" id="footer_icon1_title" name="footer_icon1_title"
                                           value="{{old('footer_icon1_title',$settings->footer_icon1_title)}}">
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6 col-12 mb-3">
                                <div class="image-chooser">
                                    <label class="form-label" for="footer_icon2">آدرس آیکن دوم</label>
                                    @if($settings->footer_icon2 != null)
                                        <img src="{{$settings->getIcon2()}}" alt="img" class="img-fluid" id="icon2-image">
                                        <button type="button" class="btn btn-sm btn-label-danger mb-3 remove-image-file"
                                                data-url="{{$settings->footer_icon2}}" image-id="icon2-image" data-input-id="footer_icon2">
                                            <i class="bx bxs-trash"></i>
                                            <span>حذف تصویر</span>
                                        </button>
                                    @endif
                                    <input type="text" name="footer_icon2" class="form-control" dir="ltr"
                                           id="footer_icon2" value="{{old('footer_icon2',$settings->footer_icon2)}}">

                                    <label for="footer_icon2_title" class="form-label mt-3">عنوان آیکن دوم</label>
                                    <input class="form-control" type="text" id="footer_icon2_title" name="footer_icon2_title"
                                           value="{{old('footer_icon2_title',$settings->footer_icon2_title)}}">
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6 col-12 mb-3">
                                <div class="image-chooser">
                                    <label class="form-label" for="footer_icon3">آدرس آیکن سوم</label>
                                    @if($settings->footer_icon3 != null)
                                        <img src="{{$settings->getIcon3()}}" alt="img" class="img-fluid" id="icon3-image">
                                        <button type="button" class="btn btn-sm btn-label-danger mb-3 remove-image-file"
                                                data-url="{{$settings->footer_icon3}}" image-id="icon3-image" data-input-id="footer_icon3">
                                            <i class="bx bxs-trash"></i>
                                            <span>حذف تصویر</span>
                                        </button>
                                    @endif
                                    <input type="text" name="footer_icon3" class="form-control" dir="ltr"
                                           id="footer_icon3" value="{{old('footer_icon3',$settings->footer_icon3)}}">

                                    <label for="footer_icon3_title" class="form-label mt-3">عنوان آیکن سوم</label>
                                    <input class="form-control" type="text" id="footer_icon3_title" name="footer_icon3_title"
                                           value="{{old('footer_icon3_title',$settings->footer_icon3_title)}}">
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6 col-12 mb-3">
                                <div class="image-chooser">
                                    <label class="form-label" for="footer_icon4">آدرس آیکن چهارم</label>
                                    @if($settings->footer_icon4 != null)
                                        <img src="{{$settings->getIcon4()}}" alt="img" class="img-fluid" id="icon4-image">
                                        <button type="button" class="btn btn-sm btn-label-danger mb-3 remove-image-file"
                                                data-url="{{$settings->footer_icon4}}" image-id="icon4-image" data-input-id="footer_icon4">
                                            <i class="bx bxs-trash"></i>
                                            <span>حذف تصویر</span>
                                        </button>
                                    @endif
                                    <input type="text" name="footer_icon4" class="form-control" dir="ltr"
                                           id="footer_icon4" value="{{old('footer_icon4',$settings->footer_icon4)}}">

                                    <label for="footer_icon4_title" class="form-label mt-3">عنوان آیکن چهارم</label>
                                    <input class="form-control" type="text" id="footer_icon4_title" name="footer_icon4_title"
                                           value="{{old('footer_icon4_title',$settings->footer_icon4_title)}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                        <div class="col-lg-4">
                            <div class="image-chooser">
                                <label class="form-label" for="footer_logo">آدرس تصویر لوگو</label>
                                @if($settings->footer_logo != null)
                                    <img src="{{$settings->getFooterLogo()}}" alt="img" class="img-fluid" id="footer-logo-image">
                                    <button type="button" class="btn btn-sm btn-label-danger mb-3 remove-image-file"
                                            data-url="{{$settings->footer_logo}}"
                                            image-id="footer-logo-image" data-input-id="footer_logo">
                                        <i class="bx bxs-trash"></i>
                                        <span>حذف تصویر</span>
                                    </button>
                                @endif
                                <input type="text" name="footer_logo" class="form-control" dir="ltr"
                                       id="footer_logo" value="{{old('footer_logo',$settings->footer_logo)}}">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row" >
                            <div class="mb-3">
                                <label class="form-label" for="footer_about_text">متن زیر لوگو</label>
                                <textarea type="hidden" name="footer_about_text" id="footer_about_text" class="tinymceeditor-sm">{{old('footer_about_text',$settings->footer_about_text)}}</textarea>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="footer_address" class="form-label">آدرس</label>
                                <input class="form-control text-start" type="text" id="footer_address" name="footer_address"
                                       value="{{old('footer_address',$settings->footer_address)}}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="footer_email" class="form-label">ایمیل</label>
                                <input class="form-control" dir="ltr" type="text" id="footer_email" name="footer_email"
                                       value="{{old('footer_email',$settings->footer_email)}}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="footer_phone" class="form-label">تلفن</label>
                                <input class="form-control" dir="ltr" type="text" id="footer_phone" name="footer_phone"
                                       value="{{old('footer_phone',$settings->footer_phone)}}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="working_hours" class="form-label">ساعات کاری</label>
                                <input class="form-control" type="text" id="working_hours" name="working_hours"
                                       value="{{old('working_hours',$settings->working_hours)}}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="footer_box1_title" class="form-label">عنوان باکس یک</label>
                                <input class="form-control" type="text" id="footer_box1_title" name="footer_box1_title"
                                       value="{{old('footer_box1_title',$settings->footer_box1_title)}}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="footer_box2_title" class="form-label">عنوان باکس دو</label>
                                <input class="form-control" type="text" id="footer_box2_title" name="footer_box2_title"
                                       value="{{old('footer_box2_title',$settings->footer_box2_title)}}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="footer_box3_title" class="form-label">عنوان باکس سه</label>
                                <input class="form-control" type="text" id="footer_box3_title" name="footer_box3_title"
                                       value="{{old('footer_box3_title',$settings->footer_box3_title)}}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="footer_box4_title" class="form-label">عنوان باکس چهار</label>
                                <input class="form-control" type="text" id="footer_box4_title" name="footer_box4_title"
                                       value="{{old('footer_box4_title',$settings->footer_box4_title)}}">
                            </div>

                            <div class="mb-3 col-12">
                                <label for="footer_social_title" class="form-label">عنوان شبکه های اجتماعی</label>
                                <input class="form-control" type="text" id="footer_social_title" name="footer_social_title"
                                       value="{{old('footer_social_title',$settings->footer_social_title)}}">
                            </div>

                            <div class="mb-3 col-12">
                                <label for="footer_html" class="form-label">کد html نمادها</label>
                                <textarea class="form-control" dir="ltr" id="footer_html" rows="3" name="footer_html">{{old('footer_html',$settings->footer_html)}}</textarea>
                            </div>

                            {{-- copyright --}}
                            <div class="mb-3">
                                <label class="form-label" for="footer_copyright">متن کپی رایت</label>
                                <textarea type="hidden" name="footer_copyright" id="footer_copyright" class="tinymceeditor-sm">{{old('footer_copyright',$settings->footer_copyright)}}</textarea>
                            </div>

                            {{-- designer --}}
                            <div class="mb-3">
                                <label class="form-label" for="footer_designer">متن طراح</label>
                                <textarea type="hidden" name="footer_designer" id="footer_designer" class="tinymceeditor-sm">{{old('footer_designer',$settings->footer_designer)}}</textarea>
                            </div>



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
