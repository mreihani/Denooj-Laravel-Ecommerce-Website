@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">تنظیمات /</span> سئو
    </h4>
    @include('admin.includes.alerts')
    <div class="row">
        <div class="col-md-12">
            @include('settings::nav')
            <form action="{{route('settings.seo_update',$settings)}}" method="post" enctype="multipart/form-data" id="mainForm">
                @csrf
                <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <h5 class="card-header">پیوندهای یکتا</h5>
                            <div class="card-body">
                                <div class="mb-4">
                                    <label for="product_base" class="form-label">مبنای صفحه محصول</label>
                                    <input type="text" class="form-control" dir="ltr" id="product_base" name="product_base" value="{{old('product_base',$settings->product_base)}}">
                                </div>
                                <div class="mb-4">
                                    <label for="category_base" class="form-label">مبنای دسته محصول</label>
                                    <input type="text" class="form-control" dir="ltr" id="category_base" name="category_base" value="{{old('category_base',$settings->category_base)}}">
                                </div>
                                <div class="mb-4">
                                    <label for="tag_base" class="form-label">مبنای برچسب محصول</label>
                                    <input type="text" class="form-control" dir="ltr" id="tag_base" name="tag_base" value="{{old('tag_base',$settings->tag_base)}}">
                                </div>
                                <div class="mb-4">
                                    <label for="post_base" class="form-label">مبنای صفحه مقاله</label>
                                    <input type="text" class="form-control" dir="ltr" id="post_base" name="post_base" value="{{old('post_base',$settings->post_base)}}">
                                </div>
                                <div class="mb-4">
                                    <label for="post_category_base" class="form-label">مبنای دسته مقاله</label>
                                    <input type="text" class="form-control" dir="ltr" id="post_category_base" name="post_category_base" value="{{old('post_category_base',$settings->post_category_base)}}">
                                </div>
                                <div class="mb-4">
                                    <label for="post_tag_base" class="form-label">مبنای برچسب مقاله</label>
                                    <input type="text" class="form-control" dir="ltr" id="post_tag_base" name="post_tag_base" value="{{old('post_tag_base',$settings->post_tag_base)}}">
                                </div>

                                <div class="mb-4">
                                    <label for="page_base" class="form-label">مبنای برگه</label>
                                    <input type="text" class="form-control" dir="ltr" id="page_base" name="page_base" value="{{old('page_base',$settings->page_base)}}">
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-success me-2 submit-button">ذخیره تغییرات</button>
                                    <a href="{{route('admin.dashboard')}}" class="btn btn-label-secondary">انصراف</a>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="m-0">نقشه سایت (sitemap)</h5>
                            <a href="{{route('sitemap')}}" class="btn btn-label-primary btn-sm" target="_blank">
                                <i class="bx bx-link"></i>
                                <span class="ms-1">مشاهده سایت مپ</span>
                            </a>
                        </div>
                        <div class="card-body">
                            <p class="mb-4">مشخص کنید کدام یک از موارد زیر در سایت مپ نشان اضافه شود.</p>

                            <label class="switch switch-square mb-4">
                                <input type="checkbox" class="switch-input" name="post_sitemap_inc" {{$settings->post_sitemap_inc ? 'checked' : ''}}>
                                <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                <span class="switch-label">مقاله</span>
                            </label>
                            <label class="switch switch-square mb-4">
                                <input type="checkbox" class="switch-input" name="post_cat_sitemap_inc" {{$settings->post_cat_sitemap_inc ? 'checked' : ''}}>
                                <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                <span class="switch-label">دسته‌بندی مقاله</span>
                            </label>
                            <label class="switch switch-square mb-4">
                                <input type="checkbox" class="switch-input" name="post_tag_sitemap_inc" {{$settings->post_tag_sitemap_inc ? 'checked' : ''}}>
                                <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                <span class="switch-label">برچسب مقاله</span>
                            </label>
                            <br>
                            <label class="switch switch-square mb-4">
                                <input type="checkbox" class="switch-input" name="product_sitemap_inc" {{$settings->product_sitemap_inc ? 'checked' : ''}}>
                                <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                <span class="switch-label">محصول</span>
                            </label>
                            <label class="switch switch-square mb-4">
                                <input type="checkbox" class="switch-input" name="product_cat_sitemap_inc" {{$settings->product_cat_sitemap_inc ? 'checked' : ''}}>
                                <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                <span class="switch-label">دسته‌بندی محصول</span>
                            </label>
                            <label class="switch switch-square mb-4">
                                <input type="checkbox" class="switch-input" name="product_tag_sitemap_inc" {{$settings->product_tag_sitemap_inc ? 'checked' : ''}}>
                                <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                <span class="switch-label">برچسب محصول</span>
                            </label>
                            <br>
                            <label class="switch switch-square mb-4">
                                <input type="checkbox" class="switch-input" name="page_sitemap_inc" {{$settings->page_sitemap_inc ? 'checked' : ''}}>
                                <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                <span class="switch-label">برگه</span>
                            </label>
                            <br>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-success me-2 submit-button">ذخیره تغییرات</button>
                                <a href="{{route('admin.dashboard')}}" class="btn btn-label-secondary">انصراف</a>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <h5 class="card-header">متاتگ ایندکس</h5>

                        <div class="card-body">
                            <p>با غیر فعالسازی این گزینه، هیچکدام از صفحات سایت در موتورهای جستجو ثبت نمیشود!</p>

                            <label class="switch switch-square mb-4">
                                <input type="checkbox" class="switch-input" name="site_index" {{$settings->site_index == 'index' ? 'checked' : ''}}>
                                <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                <span class="switch-label">نمایش به موتورهای جستجو</span>
                            </label>


                            <div class="mt-4">
                                <button type="submit" class="btn btn-success me-2 submit-button">ذخیره تغییرات</button>
                                <a href="{{route('admin.dashboard')}}" class="btn btn-label-secondary">انصراف</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection
