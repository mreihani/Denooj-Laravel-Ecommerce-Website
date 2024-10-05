@extends('admin.layouts.panel')
@section('content')
    <div class="d-flex align-items-center justify-content-between py-3 mb-4">
        <h4 class="m-0 breadcrumb-wrapper">
            <span class="text-muted fw-light"><a href="{{route('post-tags.index')}}">برچسب مقالات</a> /</span> ویرایش
        </h4>
    </div>
    @include('admin.includes.alerts',['class' => 'mb-3'])

    <form action="{{route('post-tags.update',$post_tag)}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-lg-5">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            {{-- title --}}
                            <div class="col-12 mb-4">
                                <label class="form-label" for="name">عنوان *</label>
                                <input id="name" type="text" name="name" class="form-control" value="{{old('name',$post_tag->name)}}">
                            </div>

                            {{-- slug --}}
                            <div class="col-12 mb-4">
                                <label class="form-label" for="slug">نامک <span class="text-muted font-13 mr-1">(اختیاری)</span></label>
                                <input id="slug" type="text" name="slug" class="form-control" value="{{old('slug',$post_tag->slug)}}">
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary submit-button">ذخیره تغییرات</button>
                            </div>
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
                                <input id="h1_hidden" type="text" name="h1_hidden" class="form-control" value="{{old('h1_hidden',$post_tag->h1_hidden)}}">
                            </div>

                            {{-- nav title --}}
                            <div class="mb-3">
                                <label class="form-label" for="nav_title">عنوان مخفی nav</label>
                                <input id="nav_title" type="text" name="nav_title" class="form-control" value="{{old('nav_title',$post_tag->nav_title)}}">
                            </div>

                            {{-- title tag --}}
                            <div class="mb-3">
                                <label class="form-label" for="title_tag">تگ title</label>
                                <input id="title_tag" type="text" name="title_tag" class="form-control" value="{{old('title_tag',$post_tag->title_tag)}}">
                            </div>

                            {{-- canonical --}}
                            <div class="mb-3">
                                <label class="form-label" for="canonical">canonical</label>
                                <input id="canonical" type="text" dir="ltr" name="canonical" class="form-control" value="{{old('canonical',$post_tag->canonical)}}">
                            </div>

                            {{-- meta description --}}
                            <div class="mb-3">
                                <label class="form-label" for="meta_description">متای توضیحات</label>
                                <textarea id="meta_description" name="meta_description" class="form-control">{{old('meta_description',$post_tag->meta_description)}}</textarea>
                            </div>

                            {{-- seo description --}}
                            <div class="mb-3">
                                <label class="form-label" for="seo_description">توضیحات سئو</label>
                                <textarea type="hidden" name="seo_description" id="seo_description" class="tinymceeditor">{{old('seo_description',$post_tag->seo_description)}}</textarea>
                            </div>

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
