@extends('admin.layouts.panel')
@section('content')
    <div class="d-flex align-items-center justify-content-between py-3 mb-4">
        <h4 class="m-0 breadcrumb-wrapper">
            <span class="text-muted fw-light"><a href="{{route('stories.index')}}">داستان ها</a> /</span> ویرایش
        </h4>
        <div>
            <a href="{{route('stories.create')}}" class="btn btn-primary"><span><i class="bx bx-plus me-sm-2"></i> <span class="d-none d-sm-inline-block">افزودن داستان جدید</span></span></a>
        </div>
    </div>

    @include('admin.includes.alerts',['class' => 'mb-3'])

    <form action="{{route('stories.update',$story)}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
        @csrf
        @method('PATCH')
        <div class="col-lg-7">
            <div class="card mb-4">
                <div class="card-header">تنظیمات داستان</div>
                <div class="card-body">
                    <div class="row">
                        {{-- title --}}
                        <div class="col-lg-6 mb-4">
                            <label class="form-label" for="title">عنوان *</label>
                            <input id="title" type="text" name="title" class="form-control" value="{{old('title',$story->title)}}">
                        </div>

                        {{-- type --}}
                        <div class="col-lg-3 mb-4">
                            <label class="form-label" for="type">نوع داستان</label>
                            <select class="form-select" name="type" id="type">
                                <option value="image" {{$story->type == 'image' ? 'selected' : ''}}>عکس</option>
                                <option value="video" {{$story->type == 'video' ? 'selected' : ''}}>ویدیو</option>
                            </select>
                        </div>

                        {{-- status --}}
                        <div class="col-lg-3 mb-4">
                            <label class="form-label" for="status">وضعیت</label>
                            <select class="form-select" name="status" id="status">
                                <option value="published" {{$story->status == 'published' ? 'selected' : ''}}>منتشر شده</option>
                                <option value="draft" {{$story->status == 'draft' ? 'selected' : ''}}>پیش نویس</option>
                            </select>
                        </div>

                        {{-- thumbnail --}}
                        <div class="col-lg-6 mb-4">
                            <div class="image-chooser">
                                <label class="form-label" for="thumbnail">آدرس تصویر بندانگشتی</label>
                                <small class="d-block text-muted mb-2">بهتر است یک تصویر با ابعاد مربعی 1:1 یا سایز 100*100 پیکسل انتخاب شود.</small>
                                @if($story->thumbnail != null)
                                    <img src="{{$story->getThumbnail()}}" alt="img" class="img-fluid" id="image-thumbnail">
                                    <button type="button" class="btn btn-sm btn-label-danger mb-3 remove-image-file"
                                            data-url="{{$story->thumbnail}}"
                                            image-id="image-thumbnail" data-input-id="thumbnail">
                                        <i class="bx bxs-trash"></i>
                                        <span>حذف تصویر</span>
                                    </button>
                                @endif
                                <input type="text" name="thumbnail" class="form-control" dir="ltr"
                                       id="thumbnail" value="{{old('thumbnail',$story->thumbnail)}}">
                            </div>
                        </div>

                        {{-- author --}}
                        @php $authAdmin = auth()->guard('admin')->user(); @endphp
                        <div class="col-lg-6 mb-4">
                            @if($authAdmin->hasRole('super-admin') || $authAdmin->can('manage-admins'))
                                <label class="form-label" for="author_id">نویسنده</label>
                                <select class="select2 form-select" id="author_id" name="author_id" data-allow-clear="true">
                                    @foreach(\Modules\Admins\Entities\Admin::all() as $admin)
                                        <option value="{{$admin->id}}" {{ $story->author_id == $admin->id ? 'selected' : '' }}>{{$admin->name . ' (' .$admin->email. ')'}}</option>
                                    @endforeach
                                </select>
                            @else
                                <input type="hidden" value="{{$authAdmin->id}}" name="author_id" id="author_id">
                            @endif
                        </div>

                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-success me-2 submit-button">ذخیره اطلاعات</button>
                        <a href="{{route('admin.dashboard')}}" class="btn btn-label-secondary">انصراف</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">محتوای روی داستان</div>
                <div class="card-body">
                    {{-- image_url --}}
                    <div class="mb-4 {{(!empty(old('type')) && old('type') == 'video') || $story->type == 'video' ? 'd-none' : '' }}" id="imageFieldContainer">
                        <div class="image-chooser">
                            <label class="form-label" for="image_url">آدرس تصویر داستان</label>
                            <small class="d-block text-muted mb-2">برای نمایش صحیح تصویر بهتر است تصویر با ابعاد 16:9 یا 1080*1920 پیکس انتخاب شود.</small>
                            @if($story->image_url != null)
                                <img src="{{$story->getImage()}}" alt="img" class="img-fluid" id="image-image_url">
                            @endif
                            <input type="text" name="image_url" class="form-control" dir="ltr"
                                   id="image_url" value="{{old('image_url',$story->image_url)}}">
                        </div>
                    </div>

                    {{-- video_url --}}
                    <div class="mb-4 {{(!empty(old('type')) && old('type') == 'video') || $story->type == 'video' ? '' : 'd-none' }}" id="videoFieldContainer">
                        <div class="image-chooser">
                            <label class="form-label" for="video_url">آدرس ویدیو داستان</label>
                            <small class="d-block text-muted mb-2">برای افزایش سرعت لود بهتر است حجم ویدیو را بهینه کنید.</small>
                            @if($story->video_url != null)
                                <video width="180" height="100" controls class="mb-2">
                                    <source src="{{$story->video_url}}" type="video/mp4">
                                </video>
                            @endif
                            <input type="text" name="video_url" class="form-control" dir="ltr"
                                   id="video_url" value="{{old('video_url',$story->video_url)}}">
                        </div>
                    </div>

                    {{-- show_button --}}
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="show_button"
                                   name="show_button" {{(old('show_button') == 'on') || $story->show_button ? 'checked' :''}}>
                            <label class="form-check-label" for="show_button">نمایش دکمه روی استوری</label>
                        </div>
                    </div>

                    {{-- button fields --}}
                    <div class="{{$story->show_button ? '' : 'd-none'}} mb-3" id="buttonFields">
                        {{-- button_text --}}
                        <div class="mb-4">
                            <label class="form-label" for="button_text">متن دکمه</label>
                            <input id="button_text" type="text" name="button_text" class="form-control" value="{{old('button_text',$story->button_text)}}">
                        </div>

                        {{-- button_link --}}
                        <div class="mb-4">
                            <label class="form-label" for="button_link">لینک دکمه</label>
                            <input id="button_link" type="text" dir="ltr" name="button_link" class="form-control" value="{{old('button_link',$story->button_link)}}">
                        </div>
                    </div>

                    {{-- description --}}
                    <div class="mb-4">
                        <label for="description" class="form-label">توضیحات کوتاه (اختیاری)</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{old('description',$story->description)}}</textarea>
                    </div>

                    {{-- category --}}
                    <div class="select2-primary mb-3">
                        <label class="form-label" for="products">محصولات مرتبط (اختیاری)</label>
                        <small class="d-block mb-2 text-muted">در صورت تمایل میتوانید یک یا چند محصول را روی استوری نمایش دهید.</small>
                        <select class="select2 form-select" id="products" name="products[]" data-allow-clear="true"
                                multiple>
                            @foreach(\Modules\Products\Entities\Product::all() as $product)
                                <option value="{{$product->id}}" @if(old('products'))
                                    {{ in_array($product->id,old('products')) ? 'selected' : '' }}
                                    @else
                                    {{ in_array($product->id, $story->products->pluck('id')->toArray()) ? 'selected' : '' }}
                                    @endif>{{$product->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('styles')
@endsection
@section('scripts')
    <script>
        $('#type').change(function (){
            let type = $(this).val();
            if(type === 'video'){
                $('#imageFieldContainer').addClass('d-none');
                $('#videoFieldContainer').removeClass('d-none');
            }else {
                $('#imageFieldContainer').removeClass('d-none');
                $('#videoFieldContainer').addClass('d-none');
            }
        });

        $('#show_button').change(function (){
            if($(this).is(':checked')){
                $('#buttonFields').removeClass('d-none');
            }else {
                $('#buttonFields').addClass('d-none');
            }
        });
    </script>
@endsection
