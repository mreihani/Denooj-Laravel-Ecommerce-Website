@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light"><a href="{{route('posts.index')}}">مقالات</a> /</span> افزودن مقاله جدید
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <form action="{{route('posts.store')}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
        @csrf
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">

                        {{-- title --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="title">عنوان (ضروری)</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}"
                                   required>
                        </div>

                        {{-- slug --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="slug">نامک</label>
                            <input type="text" class="form-control" id="slug" name="slug" value="{{old('slug')}}">
                        </div>

                        {{-- excerpt --}}
                        <div class="mb-3 col-12">
                            <label class="form-label" for="excerpt">خلاصه</label>
                            <textarea class="form-control" id="excerpt" name="excerpt"
                                      rows="2">{{old('excerpt')}}</textarea>
                        </div>

                        {{-- image --}}
                        <div class="mb-3 col-lg-6">
                            <label for="image" class="form-label">تصویر اصلی مقاله</label>
                            <input class="form-control" type="file" id="image" name="image" accept="image/png, image/gif, image/jpeg">
                        </div>

                        {{-- alt --}}
                        <div class="mb-3 col-lg-6">
                            <label for="image_alt" class="form-label">متن جایگزین تصویر ALT</label>
                            <input type="text" class="form-control" id="image_alt" name="image_alt"
                                   value="{{old('image_alt')}}">
                        </div>


                        {{-- body --}}
                        <div class="mb-3">
                            <label class="form-label" for="body">محتوای مقاله</label>
                            <textarea type="hidden" name="body" id="body" class="tinymceeditor">{{old('post')}}</textarea>
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
                            <input id="h1_hidden" type="text" name="h1_hidden" class="form-control"
                                   value="{{old('h1_hidden')}}">
                        </div>

                        {{-- nav title --}}
                        <div class="mb-3">
                            <label class="form-label" for="nav_title">عنوان مخفی nav</label>
                            <input id="nav_title" type="text" name="nav_title" class="form-control"
                                   value="{{old('nav_title')}}">
                        </div>

                        {{-- title tag --}}
                        <div class="mb-3">
                            <label class="form-label" for="title_tag">تگ title</label>
                            <input id="title_tag" type="text" name="title_tag" class="form-control"
                                   value="{{old('title_tag')}}">
                        </div>

                        {{-- canonical --}}
                        <div class="mb-3">
                            <label class="form-label" for="canonical">canonical</label>
                            <input id="canonical" type="text" dir="ltr" name="canonical" class="form-control"
                                   value="{{old('canonical')}}">
                        </div>

                        {{-- meta description --}}
                        <div class="mb-3">
                            <label class="form-label" for="meta_description">متای توضیحات</label>
                            <textarea id="meta_description" name="meta_description"
                                      class="form-control">{{old('meta_description')}}</textarea>
                        </div>

                        {{-- meta index --}}
{{--                        <label class="switch switch-square mb-4">--}}
{{--                            <input type="checkbox" class="switch-input" name="meta_index" checked>--}}
{{--                            <span class="switch-toggle-slider">--}}
{{--                                        <span class="switch-on"><i class="bx bx-check"></i></span>--}}
{{--                                        <span class="switch-off"><i class="bx bx-x"></i></span>--}}
{{--                                    </span>--}}
{{--                            <span class="switch-label">ایندکس</span>--}}
{{--                        </label>--}}

                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">

                    {{-- reading time --}}
                    <div class="mb-3">
                        <label for="reading_time" class="form-label">زمان مطالعه (ضروری)</label>
                        <input type="text" name="reading_time" class="form-control" id="reading_time"
                               value="{{old('reading_time')}}" required>
                    </div>

                    {{-- category --}}
                    <div class="mb-3">
                        <label class="form-label" for="categories">دسته بندی ها (ضروری)</label>
                        <select class="select2 form-select" id="categories" name="categories[]" data-allow-clear="true"
                                multiple required>
                            @foreach(\Modules\Blog\Entities\PostCategory::all() as $category)
                                <option value="{{$category->id}}" @if(old('categories'))
                                    {{ in_array($category->id,old('categories')) ? 'selected' : '' }}
                                        @endif>{{$category->title}}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- keywords --}}
                    <div class="mb-3">
                        <label for="keywords" class="form-label">کلمات کلیدی</label>
                        <input id="keywords" class="form-control tagify-select" name="keywords"
                               value="{{old('keywords')}}">
                        <small class="d-block text-muted mt-1">کلمه را بنوسید و سپس اینتر بزنید</small>
                    </div>

                    {{-- author --}}
                    @php $authAdmin = auth()->guard('admin')->user(); @endphp
                    <div class="mb-4">
                        @if($authAdmin->hasRole('super-admin') || $authAdmin->can('manage-admins'))
                            <label class="form-label" for="author_id">نویسنده</label>
                            <select class="select2 form-select" id="author_id" name="author_id" data-allow-clear="true">
                                @foreach(\Modules\Admins\Entities\Admin::all() as $admin)
                                    <option value="{{$admin->id}}" @if(old('author_id'))
                                        {{ old('author_id') == $admin->id ? 'selected' : '' }}
                                            @else
                                        {{$authAdmin->id == $admin->id ? 'selected' : ''}}
                                            @endif>{{$admin->name . ' (' .$admin->email. ')'}}</option>
                                @endforeach
                            </select>
                        @else
                            <input type="hidden" value="{{$authAdmin->id}}" name="author_id" id="author_id">
                        @endif
                    </div>

                    {{-- sidebar --}}
                    <div class="mb-3">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="sidebar"
                                   name="sidebar" {{old('sidebar') == 'on' ? 'checked' :''}}>
                            <label class="form-check-label" for="sidebar">نمایش سایدبار</label>
                        </div>
                    </div>

                    {{-- show_thumbnail --}}
                    <div class="mb-3">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="show_thumbnail"
                                   name="show_thumbnail" {{old('show_thumbnail') == 'on' ? 'checked' :''}}>
                            <label class="form-check-label" for="show_thumbnail">نمایش تصویر در صفحه تکی</label>
                        </div>
                    </div>

                    <div class="row align-items-end">
                        {{-- status --}}
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="status">وضعیت</label>
                                <select class="select2 form-select" id="status" name="status">
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>منتشر
                                        شده
                                    </option>
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>پیش نویس
                                    </option>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>در انتظار
                                        تایید
                                    </option>
                                </select>
                            </div>
                        </div>

                        {{-- featured --}}
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" id="featured"
                                           name="featured" {{old('featured') == 'on' ? 'checked' :''}}>
                                    <label class="form-check-label" for="featured">مقاله ویژه</label>
                                </div>
                            </div>
                        </div>

                        {{-- display comments --}}
                        <div class="col-12">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="display_comments"
                                           name="display_comments" @if(old('display_comments')){{old('display_comments') == 'on' ? 'checked' :''}}@else checked @endif>
                                    <label class="form-check-label" for="display_comments">نمایش دیدگاه‌ها</label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary submit-button">ذخیره مقاله</button>
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
