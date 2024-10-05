@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light"><a href="{{route('pages.index')}}">برگه ها</a> /</span> افزودن برگه جدید
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <form action="{{route('pages.store')}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
        @csrf
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">

                        {{-- title --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="title">عنوان (ضروری)</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}">
                        </div>

                        {{-- slug --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="slug">نامک</label>
                            <input type="text" class="form-control" id="slug" name="slug" value="{{old('slug')}}">
                        </div>

                        {{-- image --}}
                        <div class="mb-3 col-lg-6">
                            <label for="image" class="form-label">تصویر اصلی برگه</label>
                            <input class="form-control" type="file" id="image" name="image">
                        </div>

                        {{-- alt --}}
                        <div class="mb-3 col-lg-6">
                            <label for="image_alt" class="form-label">متن جایگزین تصویر ALT</label>
                            <input type="text" class="form-control" id="image_alt" name="image_alt" value="{{old('image_alt')}}">
                        </div>

                        {{-- body --}}
                        <div class="mb-3">
                            <label class="form-label" for="body">محتوای برگه</label>
                            <textarea type="hidden" name="body" id="body" class="tinymceeditor">{{old('body')}}</textarea>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-action mb-4">
                <div class="card-header">
                    <div class="card-action-title">تنظیمات سئو</div>
                    <div class="card-action-element">
                        <a href="javascript:void(0);" class="card-collapsible"><i class="tf-icons bx bx-chevron-up"></i></a>
                    </div>
                </div>
                <div class="collapse">
                    <div class="card-body">

                        {{-- h1 title --}}
                        <div class="mb-3">
                            <label class="form-label" for="h1_hidden">تگ H1 مخفی</label>
                            <input id="h1_hidden" type="text" name="h1_hidden" class="form-control" value="{{old('h1_hidden')}}">
                        </div>

                        {{-- nav title --}}
                        <div class="mb-3">
                            <label class="form-label" for="nav_title">عنوان مخفی nav</label>
                            <input id="nav_title" type="text" name="nav_title" class="form-control" value="{{old('nav_title')}}">
                        </div>

                        {{-- title tag --}}
                        <div class="mb-3">
                            <label class="form-label" for="title_tag">تگ title</label>
                            <input id="title_tag" type="text" name="title_tag" class="form-control" value="{{old('title_tag')}}">
                        </div>

                        {{-- canonical --}}
                        <div class="mb-3">
                            <label class="form-label" for="canonical">canonical</label>
                            <input id="canonical" type="text" dir="ltr" name="canonical" class="form-control" value="{{old('canonical')}}">
                        </div>

                        {{-- meta description --}}
                        <div class="mb-3">
                            <label class="form-label" for="meta_description">متای توضیحات</label>
                            <textarea id="meta_description" name="meta_description" class="form-control">{{old('meta_description')}}</textarea>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">

                    <div class="row align-items-end">
                        {{-- sidebar --}}
                        <div class="mb-3">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="sidebar" name="sidebar" {{old('sidebar') == 'on' ? 'checked' :''}}>
                                <label class="form-check-label" for="sidebar">نمایش سایدبار</label>
                            </div>
                        </div>

                        {{-- status --}}
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="status">وضعیت</label>
                            <select class="select2 form-select" id="status" name="status">
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>منتشر شده</option>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>پیش نویس</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>در انتظار تایید</option>
                            </select>
                        </div>

                        {{-- submit--}}
                        <div class="col-lg-6 mb-3">
                            <button type="submit" class="btn btn-primary submit-button">ذخیره برگه</button>
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
