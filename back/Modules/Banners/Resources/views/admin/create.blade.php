@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light"><a href="{{route('banners.index')}}">بنرها</a> /</span> بنر جدید
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <form action="{{route('banners.store')}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
        @csrf
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        {{-- title --}}
                        <div class="col-12 mb-4">
                            <label class="form-label" for="title">عنوان *</label>
                            <input id="title" type="text" name="title" class="form-control" value="{{old('title')}}">
                        </div>

                        {{-- link --}}
                        <div class="col-12 mb-4">
                            <label class="form-label" for="link">لینک <span class="text-muted font-13 mr-1">(اختیاری)</span></label>
                            <input id="link" type="text" dir="ltr" name="link" class="form-control" value="{{old('link')}}">
                        </div>

                        {{-- parent --}}
                        <div class="col-12 mb-4">
                            @php $dynamicLocations = \Modules\PageBuilder\Entities\TemplateRow::where('widget_type','image_slider')->orWhere('widget_type','banner_location')->get(); @endphp

                            <label class="form-label" for="location">محل نمایش</label>
                            <select class="form-select" name="location" id="location">
                                @foreach($dynamicLocations as $row)
                                    <option value="{{'row_' . $row->id}}" {{old('location') == 'row_' . $row->id ? 'selected' : ''}}>{{$row->template->title . ' > ' . $row->widget_name}}</option>
                                @endforeach
                                <option value="posts_sidebar" {{old('location') == 'posts_sidebar' ? 'selected' : ''}}>سایدبار مقالات</option>
                                <option value="pages_sidebar" {{old('location') == 'pages_sidebar' ? 'selected' : ''}}>سایدبار برگه ها</option>
                            </select>
                        </div>

                        {{-- image --}}
                        <div class="col-12 mb-4">
                            <div class="image-chooser">
                                <label class="form-label" for="image">آدرس تصویر بنر</label>
                                <input type="text" name="image" class="form-control" dir="ltr"
                                       id="image" value="{{old('image')}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card mb-4">
                <h5 class="card-header">تنظیمات نمایش</h5>

                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-4 mb-3">
                            <label for="sort" class="form-label">ترتیب نمایش</label>
                            <input type="number" name="sort" id="sort" class="form-control" value="{{old('sort',1)}}">
                        </div>

                        <div class="col-lg-4 mb-3">
                            <label class="form-label" for="margin_top">فاصله از بالا</label>
                            <div class="input-group">
                                <input type="number" class="form-control" aria-label="margin_top" name="margin_top"
                                       value="{{old('margin_top',10)}}">
                                <span class="input-group-text">px</span>
                            </div>
                        </div>

                        <div class="col-lg-4 mb-3">
                            <label class="form-label" for="margin_top">فاصله از پایین</label>
                            <div class="input-group">
                                <input type="number" class="form-control" aria-label="margin_bottom" name="margin_bottom"
                                       value="{{old('margin_bottom',10)}}">
                                <span class="input-group-text">px</span>
                            </div>
                        </div>
                    </div>


                    <div class="alert alert-info font-14">
                        <h4 class="font-18">آموزش چینش بنرها:</h4>
                        <p>شما میتوانید در هر جایگاه، به تعداد دلخواه بنر نمایش دهید.</p>
                        <p>شما در هر سطر میتوانید از 1 تا 12 عدد بنر نمایش دهید و این را میتوانید به کمک اندازه نمایش مشخص کنید. برای مثال برای نمایش 4 بنر در یک سطر کافی است اندازه هر چهار بنر را روی 3 قرار دهید. مجموع اندازه هر سطر نهایتا باید 12 باشد.</p>
                    </div>

                    <div class="row">
                        {{-- desktop col --}}
                        <div class="col-lg-4 mb-4">
                            <label class="form-label" for="lg_col">اندازه نمایش در دسکتاپ</label>
                            <select class="form-select" name="lg_col" id="lg_col">
                                <option value="12" {{old('lg_col') == '12' ? 'selected' : ''}}>12</option>
                                <option value="11" {{old('lg_col') == '11' ? 'selected' : ''}}>11</option>
                                <option value="10" {{old('lg_col') == '10' ? 'selected' : ''}}>10</option>
                                <option value="9" {{old('lg_col') == '9' ? 'selected' : ''}}>9</option>
                                <option value="8" {{old('lg_col') == '8' ? 'selected' : ''}}>8</option>
                                <option value="7" {{old('lg_col') == '7' ? 'selected' : ''}}>7</option>
                                <option value="6" {{old('lg_col') == '6' ? 'selected' : ''}}>6</option>
                                <option value="5" {{old('lg_col') == '5' ? 'selected' : ''}}>5</option>
                                <option value="4" {{old('lg_col') == '4' ? 'selected' : ''}}>4</option>
                                <option value="3" {{old('lg_col') == '3' ? 'selected' : ''}}>3</option>
                                <option value="2" {{old('lg_col') == '2' ? 'selected' : ''}}>2</option>
                                <option value="1" {{old('lg_col') == '1' ? 'selected' : ''}}>1</option>
                            </select>
                        </div>

                        {{-- tablet col --}}
                        <div class="col-lg-4 mb-4">
                            <label class="form-label" for="sm_col">اندازه نمایش در تبلت</label>
                            <select class="form-select" name="sm_col" id="sm_col">
                                <option value="12" {{old('sm_col') == '12' ? 'selected' : ''}}>12</option>
                                <option value="11" {{old('sm_col') == '11' ? 'selected' : ''}}>11</option>
                                <option value="10" {{old('sm_col') == '10' ? 'selected' : ''}}>10</option>
                                <option value="9" {{old('sm_col') == '9' ? 'selected' : ''}}>9</option>
                                <option value="8" {{old('sm_col') == '8' ? 'selected' : ''}}>8</option>
                                <option value="7" {{old('sm_col') == '7' ? 'selected' : ''}}>7</option>
                                <option value="6" {{old('sm_col') == '6' ? 'selected' : ''}}>نصف جایگاه</option>
                                <option value="5" {{old('sm_col') == '5' ? 'selected' : ''}}>5</option>
                                <option value="4" {{old('sm_col') == '4' ? 'selected' : ''}}>4</option>
                                <option value="3" {{old('sm_col') == '3' ? 'selected' : ''}}>3</option>
                                <option value="2" {{old('sm_col') == '2' ? 'selected' : ''}}>2</option>
                                <option value="1" {{old('sm_col') == '1' ? 'selected' : ''}}>1</option>
                            </select>
                        </div>

                        {{-- mobile col --}}
                        <div class="col-lg-4 mb-4">
                            <label class="form-label" for="col">اندازه نمایش در موبایل</label>
                            <select class="form-select" name="col" id="col">
                                <option value="12" {{old('col') == '12' ? 'selected' : ''}}>12</option>
                                <option value="11" {{old('col') == '11' ? 'selected' : ''}}>11</option>
                                <option value="10" {{old('col') == '10' ? 'selected' : ''}}>10</option>
                                <option value="9" {{old('col') == '9' ? 'selected' : ''}}>9</option>
                                <option value="8" {{old('col') == '8' ? 'selected' : ''}}>8</option>
                                <option value="7" {{old('col') == '7' ? 'selected' : ''}}>7</option>
                                <option value="6" {{old('col') == '6' ? 'selected' : ''}}>6</option>
                                <option value="5" {{old('col') == '5' ? 'selected' : ''}}>5</option>
                                <option value="4" {{old('col') == '4' ? 'selected' : ''}}>4</option>
                                <option value="3" {{old('col') == '3' ? 'selected' : ''}}>3</option>
                                <option value="2" {{old('col') == '2' ? 'selected' : ''}}>2</option>
                                <option value="1" {{old('col') == '1' ? 'selected' : ''}}>1</option>
                            </select>
                        </div>
                    </div>



                    <div class="mt-4">
                        <button type="submit" class="btn btn-success me-2 submit-button">ذخیره اطلاعات</button>
                        <a href="{{route('admin.dashboard')}}" class="btn btn-label-secondary">انصراف</a>
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
