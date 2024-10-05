@extends('admin.layouts.panel')
@section('content')
    <div class="d-flex align-items-center justify-content-between py-3 mb-4">
        <h4 class="m-0 breadcrumb-wrapper">
            <span class="text-muted fw-light"><a href="{{route('posts.index')}}">مقالات</a> /</span> ویرایش
        </h4>
        <div>
            <a href="{{route('post.show',$post)}}" class="btn btn-label-secondary" target="_blank"><span><i
                            class="bx bx-show me-sm-2"></i> <span class="d-none d-sm-inline-block">مشاهده</span></span></a>
            <a href="{{route('posts.create')}}" class="btn btn-primary"><span><i class="bx bx-plus me-sm-2"></i> <span
                            class="d-none d-sm-inline-block">افزودن مقاله جدید</span></span></a>
        </div>
    </div>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <form action="{{route('posts.update',$post)}}" method="post" enctype="multipart/form-data" class="row"
          id="mainForm">
        @csrf
        @method('PATCH')
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">

                        {{-- title --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="title">عنوان (ضروری)</label>
                            <input type="text" class="form-control" id="title" name="title"
                                   value="{{old('title',$post->title)}}">
                        </div>

                        {{-- slug --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="slug">نامک</label>
                            <input type="text" class="form-control" id="slug" name="slug"
                                   value="{{old('slug',$post->slug)}}">
                        </div>

                        {{-- excerpt --}}
                        <div class="mb-3 col-12">
                            <label class="form-label" for="excerpt">خلاصه</label>
                            <textarea class="form-control" id="excerpt" name="excerpt"
                                      rows="2">{{old('excerpt',$post->excerpt)}}</textarea>
                        </div>

                        {{-- image --}}
                        <div class="mb-3 col-lg-4">
                            <label for="image" class="form-label">تصویر جدید</label>
                            <input class="form-control" type="file" id="image" name="image" accept="image/png, image/gif, image/jpeg">
                        </div>
                        @if($post->image)
                            <div class="col-lg-3 mb-3">
                                <input type="hidden" id="remove_image" name="remove_image">
                                <div class="pt-4">
                                    <a href="{{$post->getImage()}}" target="_blank">
                                        <img src="{{$post->getImage('thumb')}}" alt="image"
                                             class="w-px-40 h-auto rounded" id="post-image">
                                    </a>
                                    <span class="btn btn-sm btn-danger remove-image-file"
                                          data-url="{{$post->image['original']}}"
                                          input-id="remove_image" image-id="post-image"><i
                                                class="bx bx-trash"></i></span>
                                </div>
                            </div>
                        @endif

                        {{-- alt --}}
                        <div class="mb-3 col-lg-6">
                            <label for="image_alt" class="form-label">متن جایگزین تصویر ALT</label>
                            <input type="text" class="form-control" id="image_alt" name="image_alt"
                                   value="{{old('image_alt',$post->image_alt)}}">
                        </div>

                        {{-- body --}}
                        <div class="mb-3">
                            <label class="form-label" for="body">محتوای مقاله</label>
                            <textarea type="hidden" name="body" id="body"
                                      class="tinymceeditor">{{old('body',$post->body)}}</textarea>
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
                <div class="collapse show">
                    <div class="card-body">

                        {{-- h1 title --}}
                        <div class="mb-3">
                            <label class="form-label" for="h1_hidden">تگ H1 مخفی</label>
                            <input id="h1_hidden" type="text" name="h1_hidden" class="form-control"
                                   value="{{old('h1_hidden',$post->h1_hidden)}}">
                        </div>

                        {{-- nav title --}}
                        <div class="mb-3">
                            <label class="form-label" for="nav_title">عنوان مخفی nav</label>
                            <input id="nav_title" type="text" name="nav_title" class="form-control"
                                   value="{{old('nav_title',$post->nav_title)}}">
                        </div>

                        {{-- title tag --}}
                        <div class="mb-3">
                            <label class="form-label" for="title_tag">تگ title</label>
                            <input id="title_tag" type="text" name="title_tag" class="form-control"
                                   value="{{old('title_tag',$post->title_tag)}}">
                        </div>

                        {{-- canonical --}}
                        <div class="mb-3">
                            <label class="form-label" for="canonical">canonical</label>
                            <input id="canonical" type="text" dir="ltr" name="canonical" class="form-control"
                                   value="{{old('canonical',$post->canonical)}}">
                        </div>

                        {{-- meta description --}}
                        <div class="mb-3">
                            <label class="form-label" for="meta_description">متای توضیحات</label>
                            <textarea id="meta_description" name="meta_description"
                                      class="form-control">{{old('meta_description',$post->meta_description)}}</textarea>
                        </div>

                        {{-- meta index --}}
{{--                        <label class="switch switch-square mb-4">--}}
{{--                            <input type="checkbox" class="switch-input" name="meta_index" {{$post->meta_index == 'index' ? 'checked' : ''}}>--}}
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
                               value="{{old('reading_time',$post->reading_time)}}" required>
                    </div>

                    {{-- categories --}}
                    <div class="mb-3">
                        <label class="form-label" for="categories">دسته بندی ها</label>
                        <select class="select2 form-select" id="categories" name="categories[]" data-allow-clear="true"
                                multiple>
                            @foreach(\Modules\Blog\Entities\PostCategory::all() as $category)
                                <option value="{{$category->id}}" {{ in_array($category->id,$post->categories->pluck('id')->toArray()) ? 'selected' : '' }}>{{$category->title}}</option>
                            @endforeach
                        </select>
                    </div>


                    {{-- keywords --}}
                    <div class="mb-3">
                        <label for="keywords" class="form-label">کلمات کلیدی</label>
                        <input id="keywords" class="form-control tagify-select" name="keywords"
                               value="{{old('keywords',$post->tags->pluck('name'))}}">
                        <small class="d-block text-muted mt-1">کلمه را بنوسید و سپس اینتر بزنید</small>
                    </div>

                    {{-- author --}}
                    @php $authAdmin = auth()->guard('admin')->user(); @endphp
                    <div class="mb-4">
                        @if($authAdmin->hasRole('super-admin') || $authAdmin->can('manage-admins'))
                            <label class="form-label" for="author_id">نویسنده</label>
                            <select class="select2 form-select" id="author_id" name="author_id" data-allow-clear="true">
                                @foreach(\Modules\Admins\Entities\Admin::all() as $admin)
                                    <option value="{{$admin->id}}" {{ $post->author_id == $admin->id ? 'selected' : '' }}>{{$admin->name . ' (' .$admin->email. ')'}}</option>
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
                                   name="sidebar" {{$post->sidebar ? 'checked' :''}}>
                            <label class="form-check-label" for="sidebar">نمایش سایدبار</label>
                        </div>
                    </div>

                    {{-- show_thumbnail --}}
                    <div class="mb-3">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="show_thumbnail"
                                   name="show_thumbnail" {{$post->show_thumbnail ? 'checked' :''}}>
                            <label class="form-check-label" for="show_thumbnail">نمایش تصویر در صفحه تکی</label>
                        </div>
                    </div>

                    <div class="row align-items-end">
                        {{-- status --}}
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="status">وضعیت</label>
                                <select class="select2 form-select" id="status" name="status">
                                    <option value="published" {{ $post->status == 'published' ? 'selected' : '' }}>منتشر
                                        شده
                                    </option>
                                    <option value="draft" {{ $post->status == 'draft' ? 'selected' : '' }}>پیش نویس
                                    </option>
                                    <option value="pending" {{ $post->status == 'pending' ? 'selected' : '' }}>در انتظار
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
                                           name="featured" {{$post->featured ? 'checked' :''}}>
                                    <label class="form-check-label" for="featured">مقاله ویژه</label>
                                </div>
                            </div>
                        </div>

                        {{-- display comments --}}
                        <div class="col-12">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="display_comments"
                                           name="display_comments" @if(old('display_comments')){{old('display_comments') == 'on' ? 'checked' :''}}@else {{$post->display_comments ? 'checked' :''}} @endif>
                                    <label class="form-check-label" for="display_comments">نمایش دیدگاه‌ها</label>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="mt-4">
                        <button type="submit" class="btn btn-success submit-button">ذخیره تغییرات</button>


                        <button type="button" class="btn btn-label-danger" id="edit-page-delete"
                                data-alert-message="بعد از حذف به زباله‌دان منتقل میشود."
                                data-model-id="{{$post->id}}" data-model="posts">
                            حذف این مقاله
                        </button>
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
