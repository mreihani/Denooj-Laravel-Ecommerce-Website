@extends('admin.layouts.panel')
@section('content')
    <div class="d-flex align-items-center justify-content-between py-3 mb-4">
        <h4 class="m-0 breadcrumb-wrapper">
            <span class="text-muted fw-light"><a href="{{route('categories.index')}}">دسته بندی محصولات</a> /</span>
            ویرایش
        </h4>
        <div>
            <a href="{{route('categories.create')}}" class="btn btn-primary"><span><i
                            class="bx bx-plus me-sm-2"></i> <span
                            class="d-none d-sm-inline-block">افزودن دسته جدید</span></span></a>
        </div>
    </div>
    @include('admin.includes.alerts',['class' => 'mb-3'])

    <form action="{{route('categories.update',$category)}}" method="post" enctype="multipart/form-data" class="row"
          id="mainForm">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-lg-5">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            {{-- title --}}
                            <div class="col-12 mb-4">
                                <label class="form-label" for="title">عنوان *</label>
                                <input id="title" type="text" name="title" class="form-control"
                                       value="{{old('title',$category->title)}}">
                            </div>

                            {{-- slug --}}
                            <div class="col-12 mb-4">
                                <label class="form-label" for="slug">نامک <span class="text-muted font-13 mr-1">(اختیاری)</span></label>
                                <input id="slug" type="text" name="slug" class="form-control"
                                       value="{{old('slug',$category->slug)}}">
                            </div>

                            {{-- parent --}}
                            <div class="col-12 mb-4">
                                <label class="form-label" for="parent_id">دسته والد <span
                                            class="text-muted font-13 mr-1">(اختیاری)</span></label>
                                <select class="form-select select2" name="parent_id" id="parent_id" data-allow-clear="true">
                                    <option value="" selected>بدون والد</option>
                                    @foreach(\Modules\Products\Entities\Category::where('parent_id',null)->where('id','!=',$category->id)->get() as $cat)
                                        <option value="{{$cat->id}}"
                                                class="level-0" {{$category->parent_id == $cat->id ? 'selected' :''}}>{{$cat->title}}</option>
                                        @foreach(\Modules\Products\Entities\Category::where('parent_id',$cat->id)->where('id','!=',$category->id)->get() as $subcategory)
                                            <option value="{{$subcategory->id}}"
                                                    class="level-1" {{$category->parent_id == $subcategory->id ? 'selected' :''}}>
                                                - {{$subcategory->title}}</option>
                                            @foreach(\Modules\Products\Entities\Category::where('parent_id',$subcategory->id)->where('id','!=',$category->id)->get() as $subsubcategory)
                                                <option value="{{$subsubcategory->id}}"
                                                        class="level-2" {{$category->parent_id == $subsubcategory->id ? 'selected' :''}}>
                                                    -- {{$subsubcategory->title}}</option>
                                                @foreach(\Modules\Products\Entities\Category::where('parent_id',$subsubcategory->id)->where('id','!=',$category->id)->get() as $subsubsubcategory)
                                                    <option value="{{$subsubsubcategory->id}}"
                                                            class="level-3" {{$category->parent_id == $subsubsubcategory->id ? 'selected' :''}}>
                                                        --- {{$subsubsubcategory->title}}</option>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>

                            {{-- image --}}
                            <div class="mb-3 col-lg-8">
                                <label for="image" class="form-label">تصویر جدید</label>
                                <input class="form-control" type="file" id="image" name="image" accept="image/png, image/gif, image/jpeg">
                            </div>
                            @if($category->image)
                                <div class="col-lg-4 mb-3">
                                    <input type="hidden" id="remove_image" name="remove_image">
                                    <div class="pt-4">
                                        <a href="{{$category->getImage()}}" target="_blank">
                                            <img src="{{$category->getImage()}}" alt="image"
                                                 class="w-px-40 h-auto rounded" id="cat-image">
                                        </a>
                                        <span class="btn btn-sm btn-danger remove-image-file"
                                              data-url="{{$category->image}}"
                                              input-id="remove_image" image-id="cat-image"><i
                                                    class="bx bx-trash"></i></span>
                                    </div>
                                </div>
                            @endif

                            {{-- featured --}}
                            <div class="col-12 mb-3 mt-4">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input check-toggle" type="checkbox" id="featured"
                                           data-toggle="#collapseFeatured"
                                           name="featured" {{$category->featured ? 'checked' :''}}>
                                    <label class="form-check-label" for="featured">دسته بندی ویژه</label>
                                </div>

                                <div id="collapseFeatured" class="{{$category->featured ? '' : 'd-none'}}">
                                    <div class="mb-0">
                                        <label class="form-label" for="featured_index">اولویت نمایش در صفحه اصلی</label>
                                        <small class="text-muted font-13 d-block mb-1">با وارد کردن یک عدد، اولویت
                                            نمایش این دسته را در صفحه اصلی مشخص کنید.</small>
                                        <input id="featured_index" type="number" name="featured_index" class="form-control"
                                               value="{{old('featured_index',$category->featured_index)}}">
                                    </div>
                                </div>
                            </div>


                            {{-- display in home --}}
                            <div class="col-12 mb-4">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input check-toggle" type="checkbox"
                                           data-toggle="#collapseDisplayInHome"
                                           id="display_in_home"
                                           name="display_in_home" {{$category->display_in_home ? 'checked' :''}}>
                                    <label class="form-check-label" for="display_in_home">نمایش در صفحه اصلی</label>
                                </div>

                                <div id="collapseDisplayInHome" class="{{$category->display_in_home ? '' : 'd-none'}}">
                                    <div class="row mt-3">
                                        <div class="col-12 mb-3">
                                            <div class="form-group">
                                                <label class="form-label" for="index">اولویت نمایش در صفحه اصلی</label>
                                                <small class="text-muted font-13 d-block mb-1">با وارد کردن یک عدد،
                                                    اولویت نمایش این دسته را در صفحه اصلی مشخص کنید.</small>
                                                <input id="index" type="number" name="index" class="form-control"
                                                       value="{{old('index',$category->index)}}">
                                            </div>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <div class="form-group">
                                                <label class="form-label" for="home_section_title">عنوان سکشن در صفحه
                                                    اصلی</label>
                                                <input id="home_section_title" type="text" name="home_section_title"
                                                       class="form-control"
                                                       value="{{old('home_section_title',$category->home_section_title)}}">
                                            </div>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <div class="form-group">
                                                <label class="form-label" for="section_subtitle">زیرعنوان سکشن در صفحه
                                                    اصلی</label>
                                                <input id="section_subtitle" type="text" name="section_subtitle"
                                                       class="form-control"
                                                       value="{{old('section_subtitle',$category->section_subtitle)}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                            <a href="javascript:void(0);" class="card-collapsible"><i
                                        class="tf-icons bx bx-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="collapse show">
                        <div class="card-body">

                            {{-- h1 title --}}
                            <div class="mb-3">
                                <label class="form-label" for="h1_hidden">تگ H1 مخفی</label>
                                <input id="h1_hidden" type="text" name="h1_hidden" class="form-control"
                                       value="{{old('h1_hidden',$category->h1_hidden)}}">
                            </div>

                            {{-- nav title --}}
                            <div class="mb-3">
                                <label class="form-label" for="nav_title">عنوان مخفی nav</label>
                                <input id="nav_title" type="text" name="nav_title" class="form-control"
                                       value="{{old('nav_title',$category->nav_title)}}">
                            </div>

                            {{-- title tag --}}
                            <div class="mb-3">
                                <label class="form-label" for="title_tag">تگ title</label>
                                <input id="title_tag" type="text" name="title_tag" class="form-control"
                                       value="{{old('title_tag',$category->title_tag)}}">
                            </div>

                            {{-- canonical --}}
                            <div class="mb-3">
                                <label class="form-label" for="canonical">canonical</label>
                                <input id="canonical" type="text" dir="ltr" name="canonical" class="form-control"
                                       value="{{old('canonical',$category->canonical)}}">
                            </div>

                            {{-- meta description --}}
                            <div class="mb-3">
                                <label class="form-label" for="meta_description">متای توضیحات</label>
                                <textarea id="meta_description" name="meta_description"
                                          class="form-control">{{old('meta_description',$category->meta_description)}}</textarea>
                            </div>

                            {{-- seo description --}}
                            <div class="mb-3">
                                <label class="form-label" for="seo_description">توضیحات</label>
                                <textarea type="hidden" name="seo_description" id="seo_description"
                                          class="tinymceeditor">{{old('seo_description',$category->seo_description)}}</textarea>
                            </div>

                            {{-- faq --}}
                            <div class="mb-3">
                                <label for="faq_title" class="form-label">سوالات متداول</label>
                                <div id="faq-items">
                                    @if($category->faq)
                                        @foreach($category->faq as $item)
                                            <?php $itemName = \Illuminate\Support\Str::random(6);?>
                                            <div class='row align-items-end' id='faq_row_{{$itemName}}'>
                                                <div class='mb-3 col-12'>
                                                    <label for="item_faq_{{$itemName}}" class="form-label">عنوان</label>
                                                    <input class="form-control text-start" type="text"
                                                           id="item_faq_{{$itemName}}" name="item_faq_{{$itemName}}[]"
                                                           value="{{old('item_faq_' . $itemName,$item[0])}}">
                                                </div>

                                                <div class='mb-3 col-12'>
                                                    <label for="item_faq_{{$itemName}}" class="form-label">متن</label>
                                                    <textarea class="form-control text-start" type="text"
                                                              id="item_faq_{{$itemName}}"
                                                              name="item_faq_{{$itemName}}[]">{{old('item_faq_' . $itemName,$item[1])}}</textarea>
                                                </div>

                                                <div class='mb-3 col-lg-2'>
                                                    <span class='btn btn-label-danger btn-remove-faq'
                                                          data-delete='faq_row_{{$itemName}}'><i
                                                                class='bx bx-trash'></i></span>
                                                </div>

                                                <div class='col-12'>
                                                    <hr>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <span class="btn btn-primary add-more-faq"><i class="bx bx-plus"></i> افزودن آیتم</span>
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
