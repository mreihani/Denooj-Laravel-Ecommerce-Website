<div class="card accordion-item row-container" data-order="{{$row->order}}" data-row-id="{{$row->id}}">
    <div class="row-container-option">
                                            <span class="row-option-delete" data-row-id="{{$row->id}}"><i
                                                    class="bx bx-trash"></i></span>
    </div>
    <h2 class="accordion-header d-flex align-items-center">
        <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordion-{{$row->id}}" aria-expanded="true">
            <i class="bx bx-move-vertical me-5 font-24"></i>
            <span class="d-flex align-items-center">
                                            <i class="{{$row->widget_icon}}"></i>
                                            <span class="ms-2">{{$row->widget_name}}</span>
                                        </span>
        </button>
    </h2>
    <div id="accordion-{{$row->id}}" class="accordion-collapse collapse">
        <div class="accordion-body lh-2">
            <form action="{{route('template.update_row',$row)}}" method="post" class="ajax-submit-form">
                @csrf

                {{-- image slider fields --}}
                @include('pagebuilder::templates.includes.form.image_slider_fields',$row)

                {{-- stories fields --}}
                @include('pagebuilder::templates.includes.form.stories_fields',$row)

                {{-- featured categories fields --}}
                @include('pagebuilder::templates.includes.form.featured_categories_fields',$row)

                {{-- products carousel fields --}}
                @include('pagebuilder::templates.includes.form.products_carousel_fields',$row)

                {{-- featured products fields --}}
                @include('pagebuilder::templates.includes.form.featured_products_fields',$row)

                {{-- posts fields --}}
                @include('pagebuilder::templates.includes.form.posts_fields',$row)

                {{-- editor fields --}}
                @include('pagebuilder::templates.includes.form.editor_fields',$row)

                {{-- faq fields --}}
                @include('pagebuilder::templates.includes.form.faq_fields',$row)

                <div class="row">
{{--                    <div class="col-lg-6 mb-3">--}}
{{--                        <label class="form-label">نام سطر</label>--}}
{{--                        <input type="text" class="form-control form-control-sm" name="widget_name" aria-label="widget_name" value="{{$row->widget_name}}">--}}
{{--                    </div>--}}

                    <div class="col-lg-3 mb-3">
                        <label class="form-label">شناسه اختصاصی css</label>
                        <input type="text" dir="ltr" class="form-control form-control-sm" name="css_id" aria-label="css_id" value="{{$row->css_id}}">
                    </div>

                    @if($row->widget_type != 'featured_products' && $row->widget_type != 'posts')
                    <div class="col-lg-3 mb-3">
                        <label class="form-label">عرض سطر</label>
                        <select class="form-select form-select-sm" name="layout" aria-label="layout">
                            <option value="full" {{$row->layout == 'full' ? 'selected' : ''}}>تمام عرض</option>
                            <option value="box" {{$row->layout == 'box' ? 'selected' : ''}}>جعبه‌ای</option>
                        </select>
                    </div>
                    @endif

                    <div class="col-lg-3 mb-3">
                        <label class="form-label" for="margin_top">فاصله از بالا</label>
                        <div class="input-group input-group-sm">
                            <input type="number" class="form-control form-control-sm" aria-label="margin_top" name="margin_top"
                                   value="{{old('margin_top',$row->margin_top)}}">
                            <span class="input-group-text">px</span>
                        </div>
                    </div>

                    <div class="col-lg-3 mb-3">
                        <label class="form-label" for="margin_bottom">فاصله از پایین</label>
                        <div class="input-group input-group-sm">
                            <input type="number" class="form-control form-control-sm" aria-label="margin_bottom" name="margin_bottom"
                                   value="{{old('margin_bottom',$row->margin_bottom)}}">
                            <span class="input-group-text">px</span>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">css سفارشی</label>
                        <small class="d-block mb-2 text-muted font-12">میتوانید از شناسه اختصاصی css اینجا استفاده کنید.</small>
                        <textarea rows="3" class="form-control form-control-sm" dir="ltr" name="custom_css" aria-label="custom_css" placeholder=".class { color: red; }">{{$row->custom_css}}</textarea>
                    </div>

                    <div class="col-12 mt-3">
                        <button type="submit" data-row-id="{{$row->id}}" class="btn-update-row btn btn-sm btn-label-success submit-button">ذخیره تغییرات</button>
                    </div>
                </div>

            </form>


        </div>
    </div>
</div>
