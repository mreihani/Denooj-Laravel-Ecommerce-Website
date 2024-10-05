@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light"><a href="{{route('products.index')}}">محصولات</a> /</span> افزودن محصول جدید
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <form action="{{route('products.store')}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
        @csrf
        <div class="col-lg-8">
            {{-- general info --}}
            <div class="card mb-4">
                <h5 class="card-header">اطلاعات محصول</h5>
                <div class="card-body">
                    <div class="row align-items-end">

                        {{-- title --}}
                        <div class="mb-3 col-12">
                            <label class="form-label" for="title">عنوان (ضروری)</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}"
                                   required autofocus>
                        </div>

                        {{-- latin title --}}
                        <div class="mb-3 col-12">
                            <label class="form-label" for="title_latin">عنوان لاتین</label>
                            <input type="text" dir="ltr" class="form-control" id="title_latin" name="title_latin"
                                   value="{{old('title_latin')}}">
                        </div>

                        {{-- torob title --}}
                        <div class="mb-3 col-12">
                            <label class="form-label" for="torob_title">عنوان اختصاصی ترب</label>
                            <input type="text" class="form-control" id="torob_title" name="torob_title" value="{{old('torob_title')}}">
                        </div>


                        {{-- slug --}}
                        <div class="mb-3 col-12">
                            <label class="form-label" for="slug">نامک</label>
                            <input type="text" class="form-control" id="slug" name="slug" value="{{old('slug')}}">
                        </div>

                        {{-- body --}}
                        <div class="mb-3">
                            <label class="form-label" for="body">توضیحات</label>
                            <textarea type="hidden" name="body" id="body" class="tinymceeditor">{{old('body')}}</textarea>
                        </div>

                    </div>
                </div>
            </div>

            {{-- product info --}}
            <div class="card card-action mb-4">
                <div class="card-header d-flex align-items-center">
                    <div class="card-action-title flex-grow-0">اطلاعات محصول</div>
                    <select aria-label="product_type" class="form-select form-select-sm w-auto ms-3" name="product_type" id="product_type">
                        <option value="simple" {{old('product_type') == 'simple' ? 'selected' :''}}>ساده</option>
                        <option value="variation" {{old('product_type') == 'variation' ? 'selected' :''}}>محصول متغیر</option>
                    </select>
                    <div class="card-action-element ms-auto">
                        <a href="javascript:void(0);" class="card-collapsible"><i class="tf-icons bx bx-chevron-up"></i></a>
                    </div>
                </div>

                <div class="collapse show">
                    <div class="card-body">
                        <div class="nav-align-left">
                            <ul class="nav nav-pills nav-pills-product border-end" id="productTabs" role="tablist">
                                <li class="nav-item simple-product-field">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-general" aria-controls="navs-general" aria-selected="true">
                                        <i class="bx bxs-cog"></i><span>همگانی</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-inventory" aria-controls="navs-inventory" aria-selected="false">
                                        <i class="bx bx-list-check"></i><span>فهرست موجودی</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-shipping" aria-controls="navs-shipping" aria-selected="false">
                                        <i class="bx bxs-truck"></i><span>حمل و نقل</span>
                                    </button>
                                </li>
                                <li class="nav-item variation-product-fields d-none">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-variables" aria-controls="navs-variables" aria-selected="false">
                                        <i class="bx bxs-grid-alt"></i><span>متغیرها</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-total-attributes" aria-controls="navs-total-attributes" aria-selected="false">
                                        <i class="bx bxs-folder-plus"></i><span>مشخصات کلی</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-attributes" aria-controls="navs-attributes" aria-selected="false">
                                        <i class="bx bxs-category"></i><span>ویژگی‌های برتر</span>
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content shadow-none">
                                {{-- general tab content --}}
                                <div class="tab-pane fade active show simple-product-field" id="navs-general" role="tabpanel">
                                    {{-- price --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="price">قیمت (ضروری)</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="price" name="price" value="{{old('price')}}"
                                                {{old('product_type') == 'simple' ? 'required' : ''}}>
                                            <span class="input-group-text">تومان</span>
                                        </div>
                                    </div>

                                    {{-- sale price --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="sale_price">قیمت فروش ویژه (اختیاری)</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="sale_price" name="sale_price"
                                                   value="{{old('sale_price')}}">
                                            <span class="input-group-text">تومان</span>
                                        </div>
                                        <small class="text-muted font-13">درصورت وارد کردن، محصول با این قیمت فروخته خواهد شد.</small>
                                    </div>
                                </div>

                                {{-- inventory tab content --}}
                                <div class="tab-pane fade" id="navs-inventory" role="tabpanel">

                                    {{-- sku --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="sku">شناسه محصول (sku)</label>
                                        <input type="text" class="form-control" id="sku" name="sku" value="{{old('sku')}}">
                                        <small class="text-muted font-13">درصورت تمایل میتوانید شناسه انحصاری محصول را وارد
                                            کنید.</small>
                                    </div>

                                    <div class="simple-product-field">
                                        {{-- manage stock --}}
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input check-toggle" type="checkbox" data-toggle="#stockContainer"
                                                       data-toggle-reverse="#stockStatusContainer"
                                                       id="manage_stock"
                                                       name="manage_stock" {{old('manage_stock') == 'on' ? 'checked' :''}}>
                                                <label class="form-check-label" for="manage_stock">مدیریت موجودی</label>
                                            </div>
                                        </div>

                                        {{-- stock --}}
                                        <div id="stockContainer" class="mb-3 {{old('manage_stock') == 'on' ? '' :'d-none'}}">
                                            <label class="form-label" for="stock">موجودی</label>
                                            <input type="number" class="form-control" id="stock" name="stock" value="{{old('stock',0)}}">
                                        </div>

                                        {{-- stock_status --}}
                                        <div class="mb-3 {{old('manage_stock') == 'on' ? 'd-none' :''}}" id="stockStatusContainer">
                                            <label class="form-label" for="stock_status">وضعیت موجودی</label>
                                            <select class="form-select" name="stock_status" id="stock_status">
                                                <option value="in_stock" {{old('stock_status') == 'in_stock' ? 'selected' : ''}}>موجود در
                                                    انبار
                                                </option>
                                                <option value="out_of_stock" {{old('stock_status') == 'out_of_stock' ? 'selected' : ''}}>
                                                    ناموجود
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- shipping tab content --}}
                                <div class="tab-pane fade" id="navs-shipping" role="tabpanel">

                                    <div class="alert alert-info font-14">
                                        <p>در صورت تمایل میتوانید وزن محصول را وارد کنید، در صورتی که وزن محصول بیشتر از یک کیلوگرم باشد، طبق هزینه های وارد شده در تنظیمات حمل و نقل به ازای هر کیلوگرم محاسبه میگردد.</p>
                                        <p class="mb-0">همچنین در صورتی که این محصول هزینه های اضافی دیگری دارد میتوانید آن را در فیلد زیر (هزینه های اضافه) وارد کرده تا هنگام محاسبه هزینه اعمال گردد.</p>
                                    </div>

                                    {{-- weight --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="weight">وزن محصول (گرم)</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="weight" name="weight" value="{{old('weight')}}">
                                            <span class="input-group-text">گرم</span>
                                        </div>
                                        <small class="text-muted d-block mt-1">برای محاسبه هزینه ارسال استفاده میشود.</small>
                                    </div>

                                    {{-- extra shipping prices --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="extra_shipping_cost">هزینه‌های اضافه</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="extra_shipping_cost" name="extra_shipping_cost" value="{{old('extra_shipping_cost')}}">
                                            <span class="input-group-text">تومان</span>
                                        </div>
                                        <small class="text-muted d-block mt-1">این مبلغ به هزینه ارسال محصول اضافه میشود. برای مثال: هزینه بسته بندی و نگهداری</small>
                                    </div>

                                    {{-- shipping time --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="shipping_time">زمان ارسال</label>
                                        <input type="text" class="form-control" id="shipping_time" name="shipping_time" value="{{old('shipping_time')}}">
                                        <small class="text-muted d-block mt-1">درصورت تمایل میتوانید زمان ارسال محصول را وارد کنید، این مقدار در صفحه محصول نمایش داده خواهد شد.</small>
                                    </div>

                                </div>

                                {{-- variables tab content --}}
                                <div class="tab-pane fade variation-product-fields d-none" id="navs-variables" role="tabpanel">

                                    <select class="form-select w-auto mb-4" name="variation_type" id="variation_type" aria-label="variation_type">
                                        <option value="color" selected>محصول دارای رنگ</option>
                                        <option value="size">محصول دارای سایز</option>
                                        <option value="color_size">محصول دارای رنگ و سایز</option>
                                    </select>

                                    {{-- colors --}}
                                    <div class="select2-primary mb-3" id="colorsSelectContainer">
                                        <label class="form-label" for="colors">انتخاب رنگ‌ها</label>
                                        <select class="form-control select2" name="colors[]" id="colors" multiple>
                                            @foreach(\Modules\Products\Entities\ProductColor::all() as $color)
                                                @php $val = $color->name . '|' . $color->hex_code; @endphp
                                                <option value="{{$val}}" @if(old('colors'))
                                                    {{in_array($val,old('colors')) ? 'selected' : ''}}
                                                    @endif>{{$color->label}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- sizes --}}
                                    <div class="select2-primary mb-3 d-none" id="sizesSelectContainer">
                                        <label class="form-label" for="sizes">انتخاب سایزها</label>
                                        <select class="form-control select2" name="sizes[]" id="sizes" multiple>
                                            @foreach(\Modules\Products\Entities\ProductSize::all() as $size)
                                                <option value="{{$size->name}}" @if(old('sizes'))
                                                    {{in_array($size->name,old('sizes')) ? 'selected' : ''}}
                                                    @endif>{{$size->label}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <button type="button" id="generateVariations" class="btn btn-outline-primary">تولید متغیرها</button>


                                    <div class="accordion mt-3 accordion-header-primary accordion-outlined" id="variationsAccordion"></div>
                                </div>

                                {{-- attributes tab content --}}
                                <div class="tab-pane fade" id="navs-attributes" role="tabpanel">
                                    <small class="alert alert-info font-14">میتوانید چند ویژگی برتر محصول را که میخواهید بیشتر جلوی چشم مشتری باشد را انتخاب کنید.</small>
                                    <div class="select2-primary mb-3">
                                        <label class="form-label" for="attributes">انتخاب ویژگی ها</label>
                                        <select class="form-control select2" name="attributes[]" id="attributes" multiple>
                                            @foreach(\Modules\Products\Entities\Attribute::all() as $attr)
                                                <?php $val = $attr->code . '-' . $attr->frontend_type . '-' . $attr->required . '-' . $attr->label;?>
                                                <option value="{{$val}}" @if(old('attributes'))
                                                    {{in_array($val,old('attributes')) ? 'selected' : ''}}
                                                    @endif>{{$attr->label}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="attributesContainer">
                                        @if(old('attributes'))
                                            @foreach(old('attributes') as $attr)
                                                <?php
                                                $arr = explode('-', $attr);
                                                $code = $arr[0];
                                                $frontendType = $arr[1];
                                                $required = $arr[2] === 1;
                                                $requiredVal = $arr[2];
                                                $label = $arr[3];
                                                $fieldName = 'attr_' . $code . '_' . $frontendType . '_' . $requiredVal . '_' . $label;?>
                                                @if($frontendType == 'text' || $frontendType == 'number')
                                                    <div class="mb-3" id="{{'attr_'.$code.'_container'}}">
                                                        <label class="form-label" for="{{'attr_' . $code}}">{{$label}}</label>
                                                        <input type="{{$frontendType}}" class="form-control" id="{{'attr_' . $code}}"
                                                               name="{{$fieldName}}" value="{{old($fieldName)}}">
                                                    </div>

                                                @elseif($frontendType == 'textarea')
                                                    <div class="mb-3" id="{{'attr_'.$code.'_container'}}">
                                                        <label class="form-label" for="{{'attr_' . $code}}">{{$label}}</label>
                                                        <textarea class="form-control" id="{{'attr_' . $code}}"
                                                                  name="{{$fieldName}}">{{old($fieldName)}}</textarea>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                {{-- total attributes tab content --}}
                                <div class="tab-pane fade" id="navs-total-attributes" role="tabpanel">
                                    <div class="alert alert-info font-14">ویژگی های کلی محصول را انتخاب یا از گروه ویژگی ها استفاده کنید، این لیست در قسمت <b>مشخصات کلی در صفحه محصول</b> نمایش داده
                                        خواهد شد.</div>

                                    <div class="select2-primary mb-3">
                                        <label class="form-label d-flex align-items-center justify-content-between" for="attribute_list">انتخاب از گروه ویژگی <a
                                                href="{{route('attribute-categories.index')}}">ویرایش گروه های ویژگی</a></label>
                                        <select class="form-control select2" id="attribute_list">
                                            <option value="" selected>انتخاب کنید</option>
                                            @foreach(\Modules\Products\Entities\AttributeCategory::all() as $attrCat)
                                                <option value="{{$attrCat->id}}">{{$attrCat->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="select2-primary mb-3">
                                        <label class="form-label" for="total_attributes">انتخاب ویژگی ها</label>
                                        <select class="form-control select2" name="total_attributes[]" id="total_attributes" multiple>
                                            @foreach(\Modules\Products\Entities\Attribute::all() as $attr)
                                                <?php $val = 'total-' . $attr->code . '-' . $attr->frontend_type . '-' . $attr->required . '-' . $attr->label;?>
                                                <option value="{{$val}}" @if(old('total_attributes'))
                                                    {{in_array($val,old('total_attributes')) ? 'selected' : ''}}
                                                    @endif>{{$attr->label}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="totalAttributesContainer">
                                        @if(old('total_attributes'))
                                            @foreach(old('total_attributes') as $attr)
                                                <?php
                                                $arr = explode('-', $attr);
                                                $code = $arr[0];
                                                $frontendType = $arr[1];
                                                $required = $arr[2] === 1;
                                                $requiredVal = $arr[2];
                                                $label = $arr[3];
                                                $fieldName = 'total_attr_' . $code . '_' . $frontendType . '_' . $requiredVal . '_' . $label;?>
                                                @if($frontendType == 'text' || $frontendType == 'number')
                                                    <div class="mb-3" id="{{'total_attr_'.$code.'_container'}}">
                                                        <label class="form-label" for="{{'total_attr_' . $code}}">{{$label}}</label>
                                                        <input type="{{$frontendType}}" class="form-control"
                                                               id="{{'total_attr_' . $code}}" name="{{$fieldName}}"
                                                               value="{{old($fieldName)}}" {{$required ? 'required' : ''}}>
                                                    </div>

                                                @elseif($frontendType == 'textarea')
                                                    <div class="mb-3" id="{{'total_attr_'.$code.'_container'}}">
                                                        <label class="form-label" for="{{'total_attr_' . $code}}">{{$label}}</label>
                                                        <textarea class="form-control" id="{{'total_attr_' . $code}}"
                                                                  name="{{$fieldName}}" {{$required ? 'required' : ''}}>{{old($fieldName)}}</textarea>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            {{-- short description --}}
            <div class="card card-action mb-4">
                <div class="card-header">
                    <div class="card-action-title">توضیحات کوتاه</div>
                    <div class="card-action-element">
                        <a href="javascript:void(0);" class="card-collapsible"><i class="tf-icons bx bx-chevron-up"></i></a>
                    </div>
                </div>
                <div class="collapse show">
                    <div class="card-body">
                        <label class="form-label" for="short_description">توضیحات کوتاه محصول</label>
                        <textarea class="form-control tinymceeditor-sm" id="short_description" name="short_description"
                                  rows="2">{{old('short_description')}}</textarea>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-4">


            {{-- options --}}
            <div class="card mb-4">
                <div class="card-body">

                    {{-- label --}}
                    <div class="mb-3">
                        <label class="form-label" for="label">لیبل محصول</label>
                        <input type="text" class="form-control" id="label" name="label" value="{{old('label')}}"
                               placeholder="برای مثال: اصل، کپی، ویژه و...">
                    </div>

                    {{-- category --}}
                    <div class="select2-primary mb-3">
                        <label class="form-label" for="categories">دسته‌بندی‌ها (ضروری)</label>
                        <select class="select2 form-select" id="categories" name="categories[]" data-allow-clear="true"
                                multiple required>
                            @foreach(\Modules\Products\Entities\Category::all() as $category)
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
                            <input type="hidden" name="author_id" value="{{$authAdmin->id}}">
                        @endif
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
                                </select>
                            </div>
                        </div>

                        {{-- featured --}}
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="recommended"
                                           name="recommended" {{old('recommended') == 'on' ? 'checked' :''}}>
                                    <label class="form-check-label" for="recommended">محصول ویژه</label>
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

                        {{-- display questions --}}
                        <div class="col-12">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="display_questions"
                                           name="display_questions" @if(old('display_questions')){{old('display_questions') == 'on' ? 'checked' :''}}@else checked @endif>
                                    <label class="form-check-label" for="display_questions">نمایش پرسش‌وپاسخ‌ها</label>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary submit-button">ذخیره محصول</button>
                    </div>
                </div>
            </div>

            {{-- cart buttto --}}
            <div class="card card-action mb-4">
                <div class="card-header">
                    <div class="card-action-title">دکمه سبد خرید</div>
                    <div class="card-action-element">
                        <a href="javascript:void(0);" class="card-collapsible"><i class="tf-icons bx bx-chevron-up"></i></a>
                    </div>
                </div>
                <div class="collapse show">
                    <div class="card-body">
                        {{-- cart button link --}}
                        <div class="mb-3">
                            <label class="form-label" for="cart_button_link">لینک سفارشی دکمه خرید</label>
                            <small class="d-block text-muted mb-1">در صورت وارد کرد این مقدار، با کلیک روی دکمه سبد خرید کاربر به آدرس وارد شده هدایت میشود.</small>
                            <input type="text" dir="ltr" class="form-control" id="cart_button_link" name="cart_button_link" value="{{old('cart_button_link')}}"
                                   placeholder="https://yourlink.com">
                        </div>

                        {{-- cart button text --}}
                        <div class="mb-3">
                            <label class="form-label" for="cart_button_text">متن سفارشی دکمه خرید</label>
                            <input type="text" class="form-control" id="cart_button_text" name="cart_button_text" value="{{old('cart_button_text')}}" placeholder="پیشفرض: افزودن به سبد خرید">
                        </div>
                    </div>
                </div>
            </div>

            {{-- main image --}}
            <div class="card card-action mb-4">
                <div class="card-header">
                    <div class="card-action-title">تصویر اصلی محصول</div>
                    <div class="card-action-element">
                        <a href="javascript:void(0);" class="card-collapsible"><i class="tf-icons bx bx-chevron-up"></i></a>
                    </div>
                </div>
                <div class="collapse show">
                    <div class="card-body">
                        <label for="image" class="form-label">تصویر اصلی محصول</label>
                        <input class="form-control" type="file" id="image" name="image"
                               accept="image/png, image/gif, image/jpeg, image/webp">
                        <small class="text-muted font-13">حداکثر حجم تصویر 5 مگابایت</small>
                    </div>
                </div>
            </div>

            {{-- gallery images --}}
            <div class="card card-action mb-4">
                <div class="card-header">
                    <div class="card-action-title">گالری تصاویر</div>
                    <div class="card-action-element">
                        <a href="javascript:void(0);" class="card-collapsible"><i class="tf-icons bx bx-chevron-up"></i></a>
                    </div>
                </div>
                <div class="collapse show">
                    <div class="card-body">
                        <label for="images" class="form-label">گالری تصاویر</label>
                        <input class="form-control" type="file" id="images" name="images[]"
                               accept="image/png, image/gif, image/jpeg, image/webp" multiple>
                        <small class="text-muted font-13">حداکثر 15 تصویر، حداکثر حجم هر تصویر 5 مگابایت</small>
                    </div>
                </div>
            </div>

            {{-- seo --}}
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

                    </div>
                </div>
            </div>

            {{-- faq --}}
            <div class="card card-action mb-4">
                <div class="card-header">
                    <div class="card-action-title">سوالات متداول</div>
                    <div class="card-action-element">
                        <a href="javascript:void(0);" class="card-collapsible"><i class="tf-icons bx bx-chevron-up"></i></a>
                    </div>
                </div>
                <div class="collapse">
                    <div class="card-body">
                        <div id="faq-items">
                        </div>
                        <span class="btn btn-primary add-more-faq"><i class="bx bx-plus"></i> افزودن آیتم</span>
                    </div>
                </div>
            </div>

        </div>
    </form>

@endsection


@section('styles')
@endsection
@section('scripts')
    <script src="{{asset('admin/assets/js/custom/products.js')}}"></script>
    <script src="{{asset('admin/assets/js/custom/product_variation.js')}}"></script>
@endsection
