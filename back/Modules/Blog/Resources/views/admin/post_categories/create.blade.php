@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light"><a href="{{route('post-categories.index')}}">دسته بندی مقالات</a> /</span> دسته جدید
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <form action="{{route('post-categories.store')}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
        @csrf
        <div class="col-lg-5">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="title">عنوان (ضروری)</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}">
                    </div>
                    <div class="mb-4">
                        <label for="image" class="form-label">تصویر دسته</label>
                        <input class="form-control" type="file" id="image" name="image" accept="image/png, image/gif, image/jpeg">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="parent_id">دسته والد <span class="text-muted font-13 mr-1">(اختیاری)</span></label>
                        <select class="form-select select2" name="parent_id" id="parent_id">
                            <option value="" selected>بدون والد</option>
                            @foreach(\Modules\Blog\Entities\PostCategory::where('parent_id',null)->get() as $category)
                                <option value="{{$category->id}}" class="level-0">{{$category->title}}</option>
                                @foreach(\Modules\Blog\Entities\PostCategory::where('parent_id',$category->id)->get() as $subcategory)
                                    <option value="{{$subcategory->id}}" class="level-1">- {{$subcategory->title}}</option>
                                    @foreach(\Modules\Blog\Entities\PostCategory::where('parent_id',$subcategory->id)->get() as $subsubcategory)
                                        <option value="{{$subsubcategory->id}}" class="level-2">-- {{$subsubcategory->title}}</option>
                                        @foreach(\Modules\Blog\Entities\PostCategory::where('parent_id',$subsubcategory->id)->get() as $subsubsubcategory)
                                            <option value="{{$subsubsubcategory->id}}" class="level-3">--- {{$subsubsubcategory->title}}</option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="featured" name="featured" {{old('featured') == 'on' ? 'checked' :''}}>
                            <label class="form-check-label" for="featured">دسته ویژه</label>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-success me-2 submit-button">ذخیره تغییرات</button>
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

                        {{-- seo description --}}
                        <div class="mb-3">
                            <label class="form-label" for="seo_description">توضیحات سئو</label>
                            <textarea class="tinymceeditor" name="seo_description" id="seo_description">{!! old('seo_description') !!}</textarea>
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
