@extends('admin.layouts.panel')
@section('content')
    <div class="d-flex align-items-center justify-content-between py-3 mb-4">
        <h4 class="m-0 breadcrumb-wrapper">
            <span class="text-muted fw-light"><a href="{{route('products.index')}}">محصولات</a> /</span> ویرایش
        </h4>
        <div>
            <a href="{{route('product.show',$product)}}" class="btn btn-label-secondary" target="_blank"><span><i
                        class="bx bx-show me-sm-2"></i> <span class="d-none d-sm-inline-block">مشاهده</span></span></a>
            <a href="{{route('products.create')}}" class="btn btn-primary"><span><i
                        class="bx bx-plus me-sm-2"></i> <span
                        class="d-none d-sm-inline-block">افزودن محصول جدید</span></span></a>
        </div>
    </div>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <form action="{{route('products.update',$product)}}" method="post" enctype="multipart/form-data" class="row"
          id="mainForm">
        @csrf
        @method('PATCH')
        <div class="col-lg-8">

            {{-- general info --}}
            <div class="card mb-4">
                <h5 class="card-header">اطلاعات محصول</h5>
                <div class="card-body">
                    <div class="row align-items-end">

                        {{-- title --}}
                        <div class="mb-3 col-12">
                            <label class="form-label" for="title">عنوان (ضروری)</label>
                            <input type="text" class="form-control" id="title" name="title"
                                   value="{{old('title',$product->title)}}" required>
                        </div>

                        {{-- latin title --}}
                        <div class="mb-3 col-12">
                            <label class="form-label" for="title_latin">عنوان لاتین</label>
                            <input type="text" class="form-control" id="title_latin" name="title_latin"
                                   value="{{old('title_latin',$product->title_latin)}}">
                        </div>

                        {{-- torob title --}}
                        <div class="mb-3 col-12">
                            <label class="form-label" for="torob_title">عنوان اختصاصی ترب</label>
                            <input type="text" class="form-control" id="torob_title" name="torob_title" value="{{old('torob_title',$product->torob_title)}}">
                        </div>

                        {{-- slug --}}
                        <div class="mb-3 col-12">
                            <label class="form-label" for="slug">نامک</label>
                            <input type="text" class="form-control" id="slug" name="slug"
                                   value="{{old('slug',$product->slug)}}">
                        </div>

                        {{-- body --}}
                        <div class="mb-3">
                            <label class="form-label" for="body">توضیحات</label>
                            <textarea type="hidden" name="body" id="body" class="tinymceeditor">{{old('body',$product->body)}}</textarea>
                        </div>

                    </div>
                </div>
            </div>

            {{-- product info --}}
            <div class="card card-action mb-4">
                <div class="card-header d-flex align-items-center">
                    <div class="card-action-title flex-grow-0">اطلاعات محصول</div>
                    <select aria-label="product_type" class="form-select form-select-sm w-auto ms-3" name="product_type"
                            id="product_type">
                        <option value="simple" {{$product->product_type == 'simple' ? 'selected' :''}}>ساده</option>
                        <option value="variation" {{$product->product_type == 'variation' ? 'selected' :''}}>محصول
                            متغیر
                        </option>
                    </select>
                    <div class="card-action-element ms-auto">
                        <a href="javascript:void(0);" class="card-collapsible"><i class="tf-icons bx bx-chevron-up"></i></a>
                    </div>
                </div>

                <div class="collapse show">
                    <div class="card-body">
                        <div class="nav-align-left">
                            <ul class="nav nav-pills nav-pills-product border-end" id="productTabs" role="tablist">
                                <li class="nav-item simple-product-field {{$product->product_type == 'variation' ? 'd-none' :''}}">
                                    <button type="button"
                                            class="nav-link {{$product->product_type == 'simple' ? 'active' :''}}"
                                            role="tab" data-bs-toggle="tab" data-bs-target="#navs-general"
                                            aria-controls="navs-general" aria-selected="true">
                                        <i class="bx bxs-cog"></i><span>همگانی</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button"
                                            class="nav-link {{$product->product_type == 'variation' ? 'active' :''}}"
                                            role="tab" data-bs-toggle="tab" data-bs-target="#navs-inventory"
                                            aria-controls="navs-inventory" aria-selected="false">
                                        <i class="bx bx-list-check"></i><span>فهرست موجودی</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-shipping" aria-controls="navs-shipping" aria-selected="false">
                                        <i class="bx bxs-truck"></i><span>حمل و نقل</span>
                                    </button>
                                </li>
                                <li class="nav-item variation-product-fields {{$product->product_type == 'simple' ? 'd-none': ''}}">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-variables" aria-controls="navs-variables"
                                            aria-selected="false">
                                        <i class="bx bxs-grid-alt"></i><span>متغیرها</span>
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-total-attributes"
                                            aria-controls="navs-total-attributes" aria-selected="false">
                                        <i class="bx bxs-folder-plus"></i><span>مشخصات کلی</span>
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-attributes" aria-controls="navs-attributes"
                                            aria-selected="false">
                                        <i class="bx bxs-category"></i><span>ویژگی‌های برتر</span>
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content shadow-none">
                                {{-- general tab content --}}
                                <div
                                    class="tab-pane fade {{$product->product_type == 'simple' ? 'active show' :''}} simple-product-field"
                                    id="navs-general" role="tabpanel">
                                    {{-- price --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="price">قیمت (ضروری)</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="price" name="price"
                                                   value="{{old('price',$product->price)}}" required>
                                            <span class="input-group-text">تومان</span>
                                        </div>
                                    </div>

                                    {{-- sale price --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="sale_price">قیمت فروش ویژه (اختیاری)</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="sale_price" name="sale_price"
                                                   value="{{old('sale_price',$product->sale_price)}}">
                                            <span class="input-group-text">تومان</span>
                                        </div>
                                        <small class="text-muted font-13">درصورت وارد کردن، محصول با این قیمت فروخته
                                            خواهد شد.</small>
                                    </div>
                                </div>

                                {{-- inventory tab content --}}
                                <div class="tab-pane fade {{$product->product_type == 'variation' ? 'active show' :''}}"
                                     id="navs-inventory" role="tabpanel">

                                    {{-- sku --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="sku">شناسه محصول (sku)</label>
                                        <input type="text" class="form-control" id="sku" name="sku"
                                               value="{{old('sku',$product->sku)}}">
                                        <small class="text-muted font-13">درصورت تمایل میتوانید شناسه انحصاری محصول را
                                            وارد
                                            کنید.</small>
                                    </div>

                                    <div
                                        class="simple-product-field {{$product->product_type == 'variation' ? 'd-none': ''}}">

                                        {{-- manage stock --}}
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input check-toggle" type="checkbox"
                                                       data-toggle="#stockContainer"
                                                       data-toggle-reverse="#stockStatusContainer"
                                                       id="manage_stock"
                                                       name="manage_stock" {{$product->manage_stock ? 'checked' :''}}>
                                                <label class="form-check-label" for="manage_stock">مدیریت موجودی</label>
                                            </div>
                                        </div>

                                        {{-- stock --}}
                                        <div id="stockContainer" class="mb-3 {{$product->manage_stock ? '' :'d-none'}}">
                                            <label class="form-label" for="stock">موجودی</label>
                                            <input type="number" class="form-control" id="stock" name="stock"
                                                   value="{{old('stock',$product->stock)}}">
                                        </div>

                                        {{-- stock_status --}}
                                        <div class="mb-3 {{$product->manage_stock ? 'd-none' :''}}"
                                             id="stockStatusContainer">
                                            <label class="form-label" for="stock_status">وضعیت موجودی</label>
                                            <select class="form-select" name="stock_status" id="stock_status">
                                                <option
                                                    value="in_stock" {{$product->stock_status == 'in_stock' ? 'selected' : ''}}>
                                                    موجود در
                                                    انبار
                                                </option>
                                                <option
                                                    value="out_of_stock" {{$product->stock_status == 'out_of_stock' ? 'selected' : ''}}>
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
                                            <input type="number" class="form-control" id="weight" name="weight" value="{{old('weight',$product->weight)}}">
                                            <span class="input-group-text">گرم</span>
                                        </div>
                                        <small class="text-muted d-block mt-1">برای محاسبه هزینه ارسال استفاده میشود.</small>
                                    </div>

                                    {{-- extra shipping prices --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="extra_shipping_cost">هزینه‌های اضافه</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="extra_shipping_cost" name="extra_shipping_cost" value="{{old('extra_shipping_cost',$product->extra_shipping_cost)}}">
                                            <span class="input-group-text">تومان</span>
                                        </div>
                                        <small class="text-muted d-block mt-1">این مبلغ به هزینه ارسال محصول اضافه میشود. برای مثال: هزینه بسته بندی و نگهداری</small>
                                    </div>

                                    {{-- shipping time --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="shipping_time">زمان ارسال</label>
                                        <input type="text" class="form-control" id="shipping_time" name="shipping_time" value="{{old('shipping_time',$product->shipping_time)}}">
                                        <small class="text-muted d-block mt-1">درصورت تمایل میتوانید زمان ارسال محصول را وارد کنید، این مقدار در صفحه محصول نمایش داده خواهد شد.</small>
                                    </div>


                                </div>


                                {{-- variables tab content --}}
                                <div
                                    class="tab-pane fade {{$product->product_type == 'simple' ? 'd-none': ''}} variation-product-fields"
                                    id="navs-variables" role="tabpanel">

                                    <select class="form-select w-auto mb-4" name="variation_type" id="variation_type"
                                            aria-label="variation_type">
                                        <option value="color" {{$product->variation_type == 'color' ? 'selected': ''}}>
                                            محصول دارای رنگ
                                        </option>
                                        <option value="size" {{$product->variation_type == 'size' ? 'selected': ''}}>
                                            محصول دارای سایز
                                        </option>
                                        <option
                                            value="color_size" {{$product->variation_type == 'color_size' ? 'selected': ''}}>
                                            محصول دارای رنگ و سایز
                                        </option>
                                    </select>

                                    {{-- colors --}}
                                    <div
                                        class="select2-primary mb-3 {{$product->variation_type == 'color' || $product->variation_type == 'color_size' ? '': 'd-none'}}"
                                        id="colorsSelectContainer">
                                        <label class="form-label" for="colors">انتخاب رنگ‌ها</label>
                                        <select class="form-control select2" name="colors[]" id="colors" multiple>
                                            @foreach(\Modules\Products\Entities\ProductColor::all() as $color)
                                                @php $val = $color->name . '|' . $color->hex_code; @endphp
                                                <option value="{{$val}}" {{in_array($color->id,$product->getInventoryColors()) ? 'selected':''}}>{{$color->label}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- sizes --}}
                                    <div
                                        class="select2-primary mb-3 {{$product->variation_type == 'size' || $product->variation_type == 'color_size' ? '': 'd-none'}}"
                                        id="sizesSelectContainer">
                                        <label class="form-label" for="sizes">انتخاب سایزها</label>
                                        <select class="form-control select2" name="sizes[]" id="sizes" multiple>
                                            @foreach(\Modules\Products\Entities\ProductSize::all() as $size)
                                                <option value="{{$size->name}}" {{in_array($size->id,$product->getInventorySizes()) ? 'selected':''}}>{{$size->label}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <button type="button" id="generateVariations" class="btn btn-outline-primary">تولید
                                        متغیرها
                                    </button>

                                    @include('products::admin.products.edit_variations',['product' => $product])
                                </div>

                                {{-- attributes tab content --}}
                                <div class="tab-pane fade" id="navs-attributes" role="tabpanel">
                                    <div class="alert alert-info font-14">میتوانید چند ویژگی برتر محصول را که میخواهید بیشتر جلوی چشم مشتری باشد را انتخاب کنید.</div>

                                    <div class="select2-primary mb-3">
                                        <label class="form-label" for="attributes">انتخاب ویژگی ها</label>
                                        <select class="form-control select2" name="attributes[]" id="attributes"
                                                multiple>
                                            @foreach(\Modules\Products\Entities\Attribute::all() as $attr)
                                                <?php $val = $attr->code . '-' . $attr->frontend_type . '-' . $attr->required . '-' . $attr->label;?>
                                                <option value="{{$val}}" @if(old('attributes'))
                                                    {{in_array($val,old('attributes')) ? 'selected' : ''}}
                                                    @else
                                                    {{$product->hasAttribute($attr->code) ? 'selected' : ''}}
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
                                                $fieldName = 'total_attr_' . $code . '_' . $frontendType . '_' . $requiredVal . '_' . $label;?>
                                                @if($frontendType == 'text' || $frontendType == 'number')
                                                    <div class="mb-3" id="{{'attr_'.$code.'_container'}}">
                                                        <label class="form-label"
                                                               for="{{'attr_' . $code}}">{{$label}}</label>
                                                        <input type="{{$frontendType}}" class="form-control"
                                                               id="{{'attr_' . $code}}"
                                                               name="{{$fieldName}}"
                                                               value="{{old($fieldName)}}" {{$required ? 'required' : ''}}>
                                                    </div>

                                                @elseif($frontendType == 'textarea')
                                                    <div class="mb-3" id="{{'attr_'.$code.'_container'}}">
                                                        <label class="form-label"
                                                               for="{{'attr_' . $code}}">{{$label}}</label>
                                                        <textarea class="form-control" id="{{'attr_' . $code}}"
                                                                  name="{{$fieldName}}" {{$required ? 'required' : ''}}>{{old($fieldName)}}</textarea>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach($product->attributes as $attr)

                                                <?php $fieldName = 'attr_' . $attr['code'] . '_' . $attr['frontend_type'] . '_' . $attr['required'] . '_' . $attr['label'];?>

                                                @if($attr['frontend_type'] == 'text' || $attr['frontend_type'] == 'number')
                                                    <div class="mb-3" id="{{'attr_'.$attr['code'].'_container'}}">
                                                        <label class="form-label"
                                                               for="{{'attr_' . $attr['code']}}">{{$attr['label']}}</label>
                                                        <input type="{{$attr['frontend_type']}}" class="form-control"
                                                               id="{{'attr_' . $attr['code']}}" name="{{$fieldName}}"
                                                               value="{{old($fieldName,$attr['value'])}}" {{$attr['required'] ? 'required' : ''}}>
                                                    </div>

                                                @elseif($attr['frontend_type'] == 'textarea')
                                                    <div class="mb-3" id="{{'attr_'.$attr['code'].'_container'}}">
                                                        <label class="form-label"
                                                               for="{{'attr_' . $attr['code']}}">{{$attr['label']}}</label>
                                                        <textarea class="form-control" id="{{'attr_' . $attr['code']}}"
                                                                  name="{{$fieldName}}" {{$attr['required'] ? 'required' : ''}}>{{old($fieldName,$attr['value'])}}</textarea>
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
                                        <select class="form-control select2" name="total_attributes[]"
                                                id="total_attributes" multiple>
                                            @foreach(\Modules\Products\Entities\Attribute::all() as $attr)
                                                <?php $val = 'total-' . $attr->code . '-' . $attr->frontend_type . '-' . $attr->required . '-' . $attr->label;?>
                                                <option value="{{$val}}" @if(old('total_attributes'))
                                                    {{in_array($val,old('total_attributes')) ? 'selected' : ''}}
                                                    @else
                                                    {{$product->hasTotalAttribute($attr->code) ? 'selected' : ''}}
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
                                                        <label class="form-label"
                                                               for="{{'total_attr_' . $code}}">{{$label}}</label>
                                                        <input type="{{$frontendType}}" class="form-control"
                                                               id="{{'total_attr_' . $code}}" name="{{$fieldName}}"
                                                               value="{{old($fieldName)}}" {{$required ? 'required' : ''}}>
                                                    </div>

                                                @elseif($frontendType == 'textarea')
                                                    <div class="mb-3" id="{{'total_attr_'.$code.'_container'}}">
                                                        <label class="form-label"
                                                               for="{{'total_attr_' . $code}}">{{$label}}</label>
                                                        <textarea class="form-control" id="{{'total_attr_' . $code}}"
                                                                  name="{{$fieldName}}" {{$required ? 'required' : ''}}>{{old($fieldName)}}</textarea>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach($product->total_attributes as $attr)

                                                <?php $fieldName = 'total_attr_' . $attr['code'] . '_' . $attr['frontend_type'] . '_' . $attr['required'] . '_' . $attr['label'];?>

                                                @if($attr['frontend_type'] == 'text' || $attr['frontend_type'] == 'number')
                                                    <div class="mb-3" id="{{'total_attr_'.$attr['code'].'_container'}}">
                                                        <label class="form-label"
                                                               for="{{'total_attr_' . $attr['code']}}">{{$attr['label']}}</label>
                                                        <input type="{{$attr['frontend_type']}}" class="form-control"
                                                               id="{{'total_attr_' . $attr['code']}}"
                                                               name="{{$fieldName}}"
                                                               value="{{old($fieldName,$attr['value'])}}" {{$attr['required'] ? 'required' : ''}}>
                                                    </div>

                                                @elseif($attr['frontend_type'] == 'textarea')
                                                    <div class="mb-3" id="{{'total_attr_'.$attr['code'].'_container'}}">
                                                        <label class="form-label"
                                                               for="{{'total_attr_' . $attr['code']}}">{{$attr['label']}}</label>
                                                        <textarea class="form-control"
                                                                  id="{{'total_attr_' . $attr['code']}}"
                                                                  name="{{$fieldName}}" {{$attr['required'] ? 'required' : ''}}>{{old($fieldName,$attr['value'])}}</textarea>
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
                                  rows="2">{{old('short_description',$product->short_description)}}</textarea>
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
                        <input type="text" class="form-control" id="label" name="label"
                               value="{{old('label',$product->label)}}" placeholder="برای مثال: اصل، کپی، ویژه و...">
                    </div>

                    {{-- category --}}
                    <div class="select2-primary mb-3">
                        <label class="form-label" for="categories">دسته‌بندی‌ها (ضروری)</label>
                        <select class="select2 form-select" id="categories" name="categories[]" data-allow-clear="true"
                                multiple required>
                            @foreach(\Modules\Products\Entities\Category::all() as $category)
                                <option value="{{$category->id}}" @if(old('categories'))
                                    {{ in_array($category->id,old('categories')) ? 'selected' : '' }}
                                    @else
                                    {{ in_array($category->id, $product->categories->pluck('id')->toArray()) ? 'selected' : '' }}
                                    @endif>{{$category->title}}</option>
                            @endforeach
                        </select>
                    </div>


                    {{-- keywords --}}
                    <div class="mb-3">
                        <label for="keywords" class="form-label">کلمات کلیدی</label>
                        <input id="keywords" class="form-control tagify-select" name="keywords"
                               value="{{old('keywords',$product->tags->pluck('name'))}}">
                        <small class="d-block text-muted mt-1">کلمه را بنوسید و سپس اینتر بزنید</small>
                    </div>

                    {{-- author --}}
                    @php $authAdmin = auth()->guard('admin')->user(); @endphp
                    <div class="select2-primary mb-3">
                        @if($authAdmin->hasRole('super-admin') || $authAdmin->can('manage-admins'))
                            <label class="form-label" for="author_id">نویسنده</label>
                            <select class="select2 form-select" id="author_id" name="author_id" data-allow-clear="true">
                                @foreach(\Modules\Admins\Entities\Admin::all() as $admin)
                                    <option value="{{$admin->id}}" @if(old('author_id'))
                                        {{ old('author_id') == $admin->id ? 'selected' : '' }}
                                        @else
                                        {{ $product->author_id == $admin->id ? 'selected' : '' }}
                                        @endif>{{$admin->name . ' (' .$admin->email. ')'}}</option>
                                @endforeach
                            </select>
                        @else
                            <input type="hidden" value="{{$authAdmin->id}}" name="author_id" id="author_id">
                        @endif
                    </div>

                    <div class="row align-items-end">
                        {{-- status --}}
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="status">وضعیت</label>
                                <select class="select2 form-select" id="status" name="status">
                                    <option value="published" {{ $product->status == 'published' ? 'selected' : '' }}>
                                        منتشر شده
                                    </option>
                                    <option value="draft" {{ $product->status == 'draft' ? 'selected' : '' }}>پیش نویس
                                    </option>
                                </select>
                            </div>
                        </div>

                        {{-- featured --}}
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="recommended"
                                           name="recommended" @if(old('recommended'))
                                        {{old('recommended') == 'on' ? 'checked' :''}}
                                        @else
                                        {{$product->recommended ? 'checked' :''}}
                                        @endif>
                                    <label class="form-check-label" for="recommended">محصول ویژه</label>
                                </div>
                            </div>
                        </div>

                        {{-- display comments --}}
                        <div class="col-12">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="display_comments"
                                           name="display_comments" @if(old('display_comments')){{old('display_comments') == 'on' ? 'checked' :''}}@else {{$product->display_comments ? 'checked' :''}} @endif>
                                    <label class="form-check-label" for="display_comments">نمایش دیدگاه‌ها</label>
                                </div>
                            </div>
                        </div>

                        {{-- display questions --}}
                        <div class="col-12">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="display_questions"
                                           name="display_questions" @if(old('display_questions')){{old('display_questions') == 'on' ? 'checked' :''}}@else {{$product->display_questions ? 'checked' :''}} @endif>
                                    <label class="form-check-label" for="display_questions">نمایش پرسش‌وپاسخ‌ها</label>
                                </div>
                            </div>
                        </div>


                    </div>


                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary submit-button">ذخیره محصول</button>
                        <button type="button" class="btn btn-label-danger" id="edit-page-delete"
                                data-alert-message="بعد از حذف به زباله‌دان منتقل میشود."
                                data-model-id="{{$product->id}}" data-model="products"><i class="bx bx-trash"></i> حذف
                        </button>
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
                            <input type="text" dir="ltr" class="form-control" id="cart_button_link" name="cart_button_link" value="{{old('cart_button_link',$product->cart_button_link)}}"
                                   placeholder="https://yourlink.com">
                        </div>

                        {{-- cart button text --}}
                        <div class="mb-3">
                            <label class="form-label" for="cart_button_text">متن سفارشی دکمه خرید</label>
                            <input type="text" class="form-control" id="cart_button_text" name="cart_button_text" value="{{old('cart_button_text',$product->cart_button_text)}}" placeholder="پیشفرض: افزودن به سبد خرید">
                        </div>
                    </div>
                </div>
            </div>

            {{-- main image --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">تصویر اصلی</h5>
                </div>

                <div class="card-body">
                    {{-- image --}}
                    <div class="mb-3">
                        <label for="image" class="form-label">تصویر اصلی</label>
                        <input class="form-control" type="file" id="image" name="image">
                        <small class="text-muted font-13">حداکثر حجم تصویر 5 مگابایت</small>
                    </div>
                    @if($product->image)
                        <div class="mb-4">
                            <input type="hidden" id="remove_image" name="remove_image">
                            <div class="pt-4">
                                <a href="{{$product->getImage()}}" target="_blank">
                                    <img src="{{$product->getImage('thumb')}}" alt="image"
                                         class="w-px-100 h-auto rounded" id="product-image">
                                </a>
                                <span class="btn btn-sm btn-danger remove-image-file"
                                      data-url="{{$product->image['original']}}"
                                      input-id="remove_image" image-id="product-image"><i
                                        class="bx bx-trash"></i></span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- gallery images --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">گالری تصاویر</h5>
                </div>

                <div class="card-body">
                    {{-- images --}}
                    <label for="images" class="form-label">گالری تصاویر</label>
                    @if($product->images != null)
                        <input type="hidden" id="imagesValue" value="{{json_encode($product->images)}}">
                        <div class="d-flex flex-wrap mb-2">
                            @foreach($product->images as $i => $img)
                                <div class="d-flex flex-column me-2 mb-2 pImage-container">
                                    <div class="">
                                        <input type="hidden" id="{{'image'.$i}}" value="{{json_encode($img)}}">
                                        <a href="{{'/storage' . $img['original']}}" target="_blank">
                                            <img src="{{'/storage' . $img['thumb']}}" alt="image"
                                                 class="rounded mb-2"
                                                 style="width: 80px;">
                                        </a>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-label-danger btn-delete-image"
                                            target-id="{{'image'.$i}}">
                                        <i class="bx bx-trash"></i> حذف
                                    </button>

                                </div>
                            @endforeach
                        </div>
                    @endif

                    <input type="hidden" name="old_images" id="old_images"
                           value="{{json_encode($product->images)}}">
                    <input class="form-control" type="file" id="images" name="images[]"
                           accept="image/png, image/gif, image/jpeg" multiple>
                    <small class="text-muted font-13">حداکثر 15 تصویر، حداکثر حجم هر تصویر 5 مگابایت</small>
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
                <div class="collapse ">
                    <div class="card-body">

                        {{-- h1 title --}}
                        <div class="mb-3">
                            <label class="form-label" for="h1_hidden">تگ H1 مخفی</label>
                            <input id="h1_hidden" type="text" name="h1_hidden" class="form-control"
                                   value="{{old('h1_hidden',$product->h1_hidden)}}">
                        </div>

                        {{-- nav title --}}
                        <div class="mb-3">
                            <label class="form-label" for="nav_title">عنوان مخفی nav</label>
                            <input id="nav_title" type="text" name="nav_title" class="form-control"
                                   value="{{old('nav_title',$product->nav_title)}}">
                        </div>

                        {{-- title tag --}}
                        <div class="mb-3">
                            <label class="form-label" for="title_tag">تگ title</label>
                            <input id="title_tag" type="text" name="title_tag" class="form-control"
                                   value="{{old('title_tag',$product->title_tag)}}">
                        </div>

                        {{-- canonical --}}
                        <div class="mb-3">
                            <label class="form-label" for="canonical">canonical</label>
                            <input id="canonical" type="text" dir="ltr" name="canonical" class="form-control"
                                   value="{{old('canonical',$product->canonical)}}">
                        </div>

                        {{-- meta description --}}
                        <div class="mb-3">
                            <label class="form-label" for="meta_description">متای توضیحات</label>
                            <textarea id="meta_description" name="meta_description"
                                      class="form-control">{{old('meta_description',$product->meta_description)}}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- faq --}}
            <div class="card card-action mb-4">
                <div class="card-header {{$product->faq ? 'collapsed' : ''}}">
                    <div class="card-action-title">سوالات متداول</div>
                    <div class="card-action-element">
                        <a href="javascript:void(0);" class="card-collapsible"><i class="tf-icons bx bx-chevron-up"></i></a>
                    </div>
                </div>
                <div class="collapse {{$product->faq ? 'show' : ''}}">
                    <div class="card-body">
                        <div id="faq-items">
                            @if($product->faq)
                                @foreach($product->faq as $item)
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
                                                  data-delete='faq_row_{{$itemName}}'><i class='bx bx-trash'></i></span>
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
    </form>

@endsection

@section('styles')
@endsection
@section('scripts')
    <script src="{{asset('admin/assets/js/custom/products.js')}}"></script>
    <script src="{{asset('admin/assets/js/custom/product_variation.js')}}"></script>
@endsection
