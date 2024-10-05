@extends('admin.layouts.panel')
@section('content')
    <div class="d-flex align-items-center justify-content-between py-3 mb-4">
        <h4 class="m-0 breadcrumb-wrapper">
            <span class="text-muted fw-light">برگه ها /</span> ویرایش
        </h4>
        <div>
            <a href="{{route('page.show',$page)}}" class="btn btn-label-secondary" target="_blank"><span><i class="bx bx-show me-sm-2"></i> <span class="d-none d-sm-inline-block">مشاهده</span></span></a>
            <a href="{{route('pages.create')}}" class="dt-button create-new btn btn-primary"><span><i class="bx bx-plus me-sm-2"></i> <span class="d-none d-sm-inline-block">افزودن برگه جدید</span></span></a>
        </div>
    </div>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <form action="{{route('pages.update',$page)}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
        @csrf
        @method('PATCH')
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">

                        {{-- title --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="title">عنوان (ضروری)</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{old('title',$page->title)}}">
                        </div>

                        {{-- slug --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="slug">نامک</label>
                            <input type="text" class="form-control" id="slug" name="slug" value="{{old('slug',$page->slug)}}">
                        </div>


                        {{-- image --}}
                        <div class="mb-3 col-lg-4">
                            <label for="image" class="form-label">تصویر جدید</label>
                            <input class="form-control" type="file" id="image" name="image">
                        </div>

                        @if($page->image)
                            <div class="col-lg-3 mb-3">
                                <input type="hidden" id="remove_image" name="remove_image">
                                <div class="pt-4">
                                    <a href="{{$page->getImage()}}" target="_blank">
                                        <img src="{{$page->getImage('thumb')}}" alt="image" class="w-px-40 h-auto rounded" id="post-image">
                                    </a>
                                    <span class="btn btn-sm btn-danger remove-image-file" data-url="{{$page->image['original']}}"
                                          input-id="remove_image" image-id="post-image"><i class="bx bx-trash"></i></span>
                                </div>
                            </div>
                        @endif

                        {{-- alt --}}
                        <div class="mb-3 col-lg-6">
                            <label for="image_alt" class="form-label">متن جایگزین تصویر ALT</label>
                            <input type="text" class="form-control" id="image_alt" name="image_alt" value="{{old('image_alt',$page->image_alt)}}">
                        </div>

                        {{-- body --}}
                        <div class="mb-3">
                            <label class="form-label" for="body">محتوای برگه</label>
                            <textarea type="hidden" name="body" id="body" class="tinymceeditor">{{old('body',$page->body)}}</textarea>
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
                            <input id="h1_hidden" type="text" name="h1_hidden" class="form-control" value="{{old('h1_hidden',$page->h1_hidden)}}">
                        </div>

                        {{-- nav title --}}
                        <div class="mb-3">
                            <label class="form-label" for="nav_title">عنوان مخفی nav</label>
                            <input id="nav_title" type="text" name="nav_title" class="form-control" value="{{old('nav_title',$page->nav_title)}}">
                        </div>

                        {{-- title tag --}}
                        <div class="mb-3">
                            <label class="form-label" for="title_tag">تگ title</label>
                            <input id="title_tag" type="text" name="title_tag" class="form-control" value="{{old('title_tag',$page->title_tag)}}">
                        </div>

                        {{-- canonical --}}
                        <div class="mb-3">
                            <label class="form-label" for="canonical">canonical</label>
                            <input id="canonical" type="text" dir="ltr" name="canonical" class="form-control" value="{{old('canonical',$page->canonical)}}">
                        </div>

                        {{-- meta description --}}
                        <div class="mb-3">
                            <label class="form-label" for="meta_description">متای توضیحات</label>
                            <textarea id="meta_description" name="meta_description" class="form-control">{{old('meta_description',$page->meta_description)}}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">

                    {{-- sidebar --}}
                    <div class="mb-3">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="sidebar" name="sidebar" {{$page->sidebar ? 'checked' :''}}>
                            <label class="form-check-label" for="sidebar">نمایش سایدبار</label>
                        </div>
                    </div>

                    {{-- status --}}
                    <div class="mb-3">
                        <label class="form-label" for="status">وضعیت</label>
                        <select class="select2 form-select" id="status" name="status">
                            <option value="published" {{ $page->status == 'published' ? 'selected' : '' }}>منتشر شده</option>
                            <option value="draft" {{ $page->status == 'draft' ? 'selected' : '' }}>پیش نویس</option>
                            <option value="pending" {{ $page->status == 'pending' ? 'selected' : '' }}>در انتظار تایید</option>
                        </select>
                    </div>


                    <div class="mt-4">
                        <button type="submit" class="btn btn-success submit-button">ذخیره تغییرات</button>
                        <button type="button" class="btn btn-label-danger"
                                id="edit-page-delete" data-model-id="{{$page->id}}" data-model="pages">
                            حذف این برگه
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
