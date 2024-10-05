@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light"><a href="{{route('categories.index')}}">دسته بندی محصولات</a> /</span> دسته
        جدید
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <form action="{{route('categories.store')}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
        @csrf
        <div class="col-lg-5">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        {{-- title --}}
                        <div class="col-12 mb-4">
                            <label class="form-label" for="title">عنوان *</label>
                            <input id="title" type="text" name="title" class="form-control" value="{{old('title')}}">
                        </div>

                        {{-- slug --}}
                        <div class="col-12 mb-4">
                            <label class="form-label" for="slug">نامک <span
                                        class="text-muted font-13 mr-1">(اختیاری)</span></label>
                            <input id="slug" type="text" name="slug" class="form-control" value="{{old('slug')}}">
                        </div>

                        {{-- parent --}}
                        <div class="col-12 mb-4">
                            <label class="form-label" for="parent_id">دسته والد <span class="text-muted font-13 mr-1">(اختیاری)</span></label>
                            <select class="form-select select2" name="parent_id" id="parent_id">
                                <option value="" selected>بدون والد</option>
                                @foreach(\Modules\Products\Entities\Category::where('parent_id',null)->get() as $category)
                                    <option value="{{$category->id}}" class="level-0">{{$category->title}}</option>
                                    @foreach(\Modules\Products\Entities\Category::where('parent_id',$category->id)->get() as $subcategory)
                                        <option value="{{$subcategory->id}}" class="level-1">
                                            - {{$subcategory->title}}</option>
                                        @foreach(\Modules\Products\Entities\Category::where('parent_id',$subcategory->id)->get() as $subsubcategory)
                                            <option value="{{$subsubcategory->id}}" class="level-2">
                                                -- {{$subsubcategory->title}}</option>
                                            @foreach(\Modules\Products\Entities\Category::where('parent_id',$subsubcategory->id)->get() as $subsubsubcategory)
                                                <option value="{{$subsubsubcategory->id}}" class="level-3">
                                                    --- {{$subsubsubcategory->title}}</option>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        {{-- image --}}
                        <div class="mb-3 col-12">
                            <label for="image" class="form-label">تصویر دسته</label>
                            <input class="form-control" type="file" id="image" name="image" accept="image/png, image/gif, image/jpeg">
                        </div>

                        {{-- featured --}}
                        <div class="col-12 mb-4 mt-3">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input check-toggle" type="checkbox" id="featured"
                                       data-toggle="#collapseFeatured"
                                       name="featured" {{old('featured') == 'on' ? 'checked' :''}}>
                                <label class="form-check-label" for="featured">دسته بندی ویژه</label>
                            </div>

                            <div id="collapseFeatured" class="{{old('featured') == 'on' ? '' : 'd-none'}}">
                                <div class="mb-0">
                                    <label class="form-label" for="featured_index">اولویت نمایش در صفحه اصلی</label>
                                    <small class="text-muted font-13 d-block mb-1">با وارد کردن یک عدد، اولویت
                                        نمایش این دسته را در صفحه اصلی مشخص کنید.</small>
                                    <input id="featured_index" type="number" name="featured_index" class="form-control"
                                           value="{{old('featured_index',0)}}">
                                </div>
                            </div>
                        </div>



                        {{-- display in home --}}
                        <div class="col-12 mb-4">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input check-toggle" type="checkbox"
                                       data-toggle="#collapseDisplayInHome"
                                       id="display_in_home"
                                       name="display_in_home" {{old('display_in_home') == 'on' ? 'checked' :''}}>
                                <label class="form-check-label" for="display_in_home">نمایش محصولات این دسته در صفحه اصلی</label>
                            </div>

                            <div id="collapseDisplayInHome" class="{{old('display_in_home') == 'on' ? '' : 'd-none'}}">
                                <div class="row mt-3">
                                    <div class="col-12 mb-3">
                                        <div class="form-group">
                                            <label class="form-label" for="index">اولویت نمایش در صفحه اصلی</label>
                                            <small class="text-muted font-13 d-block mb-1">با وارد کردن یک عدد، اولویت
                                                نمایش این دسته را در صفحه اصلی مشخص کنید.</small>
                                            <input id="index" type="number" name="index" class="form-control"
                                                   value="{{old('index',0)}}">
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <div class="form-group">
                                            <label class="form-label" for="home_section_title">عنوان سکشن در صفحه
                                                اصلی</label>
                                            <input id="home_section_title" type="text" name="home_section_title"
                                                   class="form-control" value="{{old('home_section_title')}}">
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <div class="form-group">
                                            <label class="form-label" for="section_subtitle">زیرعنوان سکشن در صفحه
                                                اصلی</label>
                                            <input id="section_subtitle" type="text" name="section_subtitle"
                                                   class="form-control" value="{{old('section_subtitle')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <button type="submit" class="btn btn-success me-2 submit-button">ایجاد دسته</button>
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
                <div class="collapse">
                    <div class="card-body">
                        <div class="row">

                            {{-- h1 title --}}
                            <div class="col-12 mb-4">
                                <label class="form-label" for="h1_hidden">تگ H1 مخفی</label>
                                <input id="h1_hidden" type="text" name="h1_hidden" class="form-control"
                                       value="{{old('h1_hidden')}}">
                            </div>

                            {{-- nav title --}}
                            <div class="col-12 mb-4">
                                <label class="form-label" for="nav_title">عنوان مخفی nav</label>
                                <input id="nav_title" type="text" name="nav_title" class="form-control"
                                       value="{{old('nav_title')}}">
                            </div>

                            {{-- title tag --}}
                            <div class="col-12 mb-4">
                                <label class="form-label" for="title_tag">تگ title</label>
                                <input id="title_tag" type="text" name="title_tag" class="form-control"
                                       value="{{old('title_tag')}}">
                            </div>

                            {{-- canonical --}}
                            <div class="col-12 mb-4">
                                <label class="form-label" for="canonical">canonical</label>
                                <input id="canonical" type="text" name="canonical" class="form-control"
                                       value="{{old('canonical')}}">
                            </div>

                            {{-- image alt --}}
                            <div class="col-12 mb-4">
                                <label class="form-label" for="image_alt">مقدار Alt تصویر اصلی</label>
                                <input id="image_alt" type="text" name="image_alt" class="form-control"
                                       value="{{old('image_alt')}}">
                            </div>

                            {{-- meta description --}}
                            <div class="col-12 mb-4">
                                <label class="form-label" for="meta_description">متای توضیحات</label>
                                <textarea id="meta_description" name="meta_description"
                                          class="form-control">{{old('meta_description')}}</textarea>
                            </div>

                            {{-- seo description --}}
                            <div class="mb-3">
                                <label class="form-label" for="seo_description">توضیحات</label>
                                <textarea type="hidden" name="seo_description" id="seo_description"
                                          class="tinymceeditor">{{old('seo_description')}}</textarea>
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
