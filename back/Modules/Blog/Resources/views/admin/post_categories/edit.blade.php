@extends('admin.layouts.panel')
@section('content')
    <div class="d-flex align-items-center justify-content-between py-3 mb-4">
        <h4 class="m-0 breadcrumb-wrapper">
            <span class="text-muted fw-light"><a href="{{route('post-categories.index')}}">دسته بندی مقالات</a> /</span> ویرایش
        </h4>
        <div>
            <a href="{{route('post-categories.create')}}" class="btn btn-primary"><span><i class="bx bx-plus me-sm-2"></i> <span class="d-none d-sm-inline-block">افزودن دسته جدید</span></span></a>
        </div>
    </div>
    @include('admin.includes.alerts',['class' => 'mb-3'])
    <form action="{{route('post-categories.update',$postCategory)}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
        @csrf
        @method('PATCH')
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="title">عنوان</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{old('title',$postCategory->title)}}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="slug">نامک</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="{{old('slug',$postCategory->slug)}}">
                    </div>
                    <div class="col-12 mb-4">
                        <label class="form-label" for="parent_id">دسته والد <span class="text-muted font-13 mr-1">(اختیاری)</span></label>
                        <select class="form-select select2" name="parent_id" id="parent_id">
                            <option value="" selected>بدون والد</option>
                            @foreach(\Modules\Blog\Entities\PostCategory::where('parent_id',null)->where('id','!=',$postCategory->id)->get() as $cat)
                                <option value="{{$cat->id}}" class="level-0" {{$postCategory->parent_id == $cat->id ? 'selected' :''}}>{{$cat->title}}</option>
                                @foreach(\Modules\Blog\Entities\PostCategory::where('parent_id',$cat->id)->where('id','!=',$postCategory->id)->get() as $subcategory)
                                    <option value="{{$subcategory->id}}" class="level-1" {{$postCategory->parent_id == $subcategory->id ? 'selected' :''}}>- {{$subcategory->title}}</option>
                                    @foreach(\Modules\Blog\Entities\PostCategory::where('parent_id',$subcategory->id)->where('id','!=',$postCategory->id)->get() as $subsubcategory)
                                        <option value="{{$subsubcategory->id}}" class="level-2" {{$postCategory->parent_id == $subsubcategory->id ? 'selected' :''}}>-- {{$subsubcategory->title}}</option>
                                        @foreach(\Modules\Blog\Entities\PostCategory::where('parent_id',$subsubcategory->id)->where('id','!=',$postCategory->id)->get() as $subsubsubcategory)
                                            <option value="{{$subsubsubcategory->id}}" class="level-3" {{$postCategory->parent_id == $subsubsubcategory->id ? 'selected' :''}}>--- {{$subsubsubcategory->title}}</option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="mb- col-lg-8">
                            <label for="image" class="form-label">تصویر جدید</label>
                            <input class="form-control" type="file" id="image" name="image" accept="image/png, image/gif, image/jpeg">
                        </div>
                        @if($postCategory->image)
                            <div class="col-lg-4 mb-3">
                                <input type="hidden" id="remove_image" name="remove_image">
                                <div class="pt-4">
                                    <a href="{{$postCategory->getImage()}}" target="_blank">
                                        <img src="{{$postCategory->getImage()}}" alt="image" class="w-px-40 h-auto rounded" id="cat-image">
                                    </a>
                                    <span class="btn btn-sm btn-danger remove-image-file" data-url="{{$postCategory->image}}"
                                          input-id="remove_image" image-id="cat-image"><i class="bx bx-trash"></i></span>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="featured" name="featured" {{$postCategory->featured ? 'checked' : ''}}>
                            <label class="form-check-label" for="featured">دسته ویژه</label>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary submit-button">ذخیره تغییرات</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
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
                            <input id="h1_hidden" type="text" name="h1_hidden" class="form-control" value="{{old('h1_hidden',$postCategory->h1_hidden)}}">
                        </div>

                        {{-- nav title --}}
                        <div class="mb-3">
                            <label class="form-label" for="nav_title">عنوان مخفی nav</label>
                            <input id="nav_title" type="text" name="nav_title" class="form-control" value="{{old('nav_title',$postCategory->nav_title)}}">
                        </div>

                        {{-- title tag --}}
                        <div class="mb-3">
                            <label class="form-label" for="title_tag">تگ title</label>
                            <input id="title_tag" type="text" name="title_tag" class="form-control" value="{{old('title_tag',$postCategory->title_tag)}}">
                        </div>

                        {{-- canonical --}}
                        <div class="mb-3">
                            <label class="form-label" for="canonical">canonical</label>
                            <input id="canonical" type="text" dir="ltr" name="canonical" class="form-control" value="{{old('canonical',$postCategory->canonical)}}">
                        </div>

                        {{-- meta description --}}
                        <div class="mb-3">
                            <label class="form-label" for="meta_description">متای توضیحات</label>
                            <textarea id="meta_description" name="meta_description" class="form-control">{{old('meta_description',$postCategory->meta_description)}}</textarea>
                        </div>

                        {{-- seo description --}}
                        <div class="mb-3">
                            <label class="form-label" for="seo_description">توضیحات سئو</label>
                            <textarea class="tinymceeditor" name="seo_description" id="seo_description">{!! old('seo_description',$postCategory->seo_description) !!}</textarea>
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
