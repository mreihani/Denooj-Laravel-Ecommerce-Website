@if($row->widget_type == 'featured_products')
    <div class="row">
        {{-- featured products bg color --}}
        <div class="mb-3 col-lg-3">
            <label class="form-label" for="featured_products_bg_color">رنگ بکگراند</label>
            <input id="featured_products_bg_color{{$row->id}}" type="hidden" name="featured_products_bg_color" class="form-control form-control-sm" value="{{old('featured_products_bg_color',$row->featured_products_bg_color)}}">
            <div class="color-picker-monolith" data-default-color="{{$row->featured_products_bg_color}}" data-input-id="#featured_products_bg_color{{$row->id}}"></div>
        </div>

        {{-- featured_products_title_color --}}
        <div class="mb-3 col-lg-3">
            <label class="form-label" for="featured_products_title_color">رنگ عنوان</label>
            <input id="featured_products_title_color{{$row->id}}" type="hidden" name="featured_products_title_color" class="form-control form-control-sm" value="{{old('featured_products_title_color',$row->featured_products_title_color)}}">
            <div class="color-picker-monolith" data-default-color="{{$row->featured_products_title_color}}" data-input-id="#featured_products_title_color{{$row->id}}"></div>
        </div>

        {{-- featured_products_bg_color --}}
        <div class="mb-3 col-lg-3">
            <label class="form-label" for="featured_products_bg_color">رنگ آیکن عنوان</label>
            <input id="featured_products_title_icon_color{{$row->id}}" type="hidden" name="featured_products_title_icon_color" class="form-control form-control-sm" value="{{old('featured_products_title_icon_color',$row->featured_products_title_icon_color)}}">
            <div class="color-picker-monolith" data-default-color="{{$row->featured_products_title_icon_color}}" data-input-id="#featured_products_title_icon_color{{$row->id}}"></div>
        </div>

        {{-- featured_products_title_icon_bg_color --}}
        <div class="mb-3 col-lg-3">
            <label class="form-label" for="featured_products_title_icon_bg_color">رنگ بکگراند آیکن عنوان</label>
            <input id="featured_products_title_icon_bg_color{{$row->id}}" type="hidden" name="featured_products_title_icon_bg_color" class="form-control form-control-sm" value="{{old('featured_products_title_icon_bg_color',$row->featured_products_title_icon_bg_color)}}">
            <div class="color-picker-monolith" data-default-color="{{$row->featured_products_title_icon_bg_color}}" data-input-id="#featured_products_title_icon_bg_color{{$row->id}}"></div>
        </div>

        {{-- featured_products_arrows_color --}}
        <div class="mb-3 col-lg-3">
            <label class="form-label" for="featured_products_arrows_color">رنگ پیکان ها</label>
            <input id="featured_products_arrows_color{{$row->id}}" type="hidden" name="featured_products_arrows_color" class="form-control form-control-sm" value="{{old('featured_products_arrows_color',$row->featured_products_arrows_color)}}">
            <div class="color-picker-monolith" data-default-color="{{$row->featured_products_arrows_color}}" data-input-id="#featured_products_arrows_color{{$row->id}}"></div>
        </div>

        {{-- featured_products_arrows_icon_color --}}
        <div class="mb-3 col-lg-3">
            <label class="form-label" for="featured_products_arrows_icon_color">رنگ آیکن پیکان ها</label>
            <input id="featured_products_arrows_icon_color{{$row->id}}" type="hidden" name="featured_products_arrows_icon_color" class="form-control form-control-sm" value="{{old('featured_products_arrows_icon_color',$row->featured_products_arrows_icon_color)}}">
            <div class="color-picker-monolith" data-default-color="{{$row->featured_products_arrows_icon_color}}" data-input-id="#featured_products_arrows_icon_color{{$row->id}}"></div>
        </div>

        {{-- featured_products_btn_color --}}
        <div class="mb-3 col-lg-3">
            <label class="form-label" for="featured_products_btn_color">رنگ دکمه مشاهده همه</label>
            <input id="featured_products_btn_color{{$row->id}}" type="hidden" name="featured_products_btn_color" class="form-control form-control-sm" value="{{old('featured_products_btn_color',$row->featured_products_btn_color)}}">
            <div class="color-picker-monolith" data-default-color="{{$row->featured_products_btn_color}}" data-input-id="#featured_products_btn_color{{$row->id}}"></div>
        </div>

        <div class="col-12"></div>

        <hr>


        <div class="col-lg-6 mb-3">
            <label class="form-label">عنوان</label>
            <input aria-label="featured_products_title" class="form-control form-control-sm" type="text" name="featured_products_title"
                   value="{{old('featured_products_title',$row->featured_products_title)}}">
        </div>


        <div class="col-lg-6 mb-3">
            <label class="form-label">لینک دکمه مشاهده همه</label>
            <input dir="ltr" class="form-control form-control-sm" type="text" aria-label="featured_products_btn_link" name="featured_products_btn_link"
                   value="{{old('featured_products_btn_link',$row->featured_products_btn_link)}}">
        </div>

        <div class="col-lg-3 mb-3">
            <label class="form-label">آیکن عنوان <a href="{{route('admin.icons')}}" class="ms-2">(آیکن‌ها)</a></label>
            <input dir="ltr" class="form-control form-control-sm" type="text" aria-label="featured_products_title_icon" name="featured_products_title_icon"
                   value="{{old('featured_products_title_icon',$row->featured_products_title_icon)}}">
        </div>


        <div class="col-lg-6 mb-3">
            <label class="form-label">مرتب سازی</label>
            <select class="form-select form-select-sm" aria-label="featured_products_source" name="featured_products_source">
                <option value="newest" {{$row->featured_products_source == 'newest' ? 'selected' : ''}}>جدیدترین</option>
                <option value="oldest" {{$row->featured_products_source == 'oldest' ? 'selected' : ''}}>قدیمی ترین</option>
                <option value="updated" {{$row->featured_products_source == 'updated' ? 'selected' : ''}}>بروزترین</option>
                <option value="sell_count" {{$row->featured_products_source == 'sell_count' ? 'selected' : ''}}>پرفروش ترین</option>
                <option value="popular" {{$row->featured_products_source == 'popular' ? 'selected' : ''}}>محبوب ترین</option>
            </select>
        </div>

        <div class="col-lg-3 mb-3">
            <label class="form-label">تعداد نمایش محصولات</label>
            <input dir="ltr" class="form-control form-control-sm" type="number" aria-label="featured_products_count" name="featured_products_count"
                   value="{{old('featured_products_count',$row->featured_products_count)}}">
        </div>


        <div class="col-12 mb-4">
            <label class="form-label">فیلتر کردن دسته‌بندی‌ها</label>
            <small class="d-block text-muted mb-2">برای نمایش محصولات همه دسته‌بندی‌ها خالی بگذارید.</small>
            <select aria-label="featured_products_categories_source" class="select2 form-select form-select-sm" name="featured_products_categories_source[]" data-allow-clear="true" multiple>
                @foreach(\Modules\Products\Entities\Category::all() as $category)
                    <option value="{{$category->id}}" @if($row->featured_products_categories_source){{ in_array($category->id,$row->featured_products_categories_source) ? 'selected' : '' }}@endif>{{$category->title}}</option>
                @endforeach
            </select>
        </div>


        <div class="col-lg-4 mb-3 align-self-end">
            <label class="switch switch-square">
                <input type="checkbox" class="switch-input" name="featured_products_available" {{$row->featured_products_available ? 'checked' : ''}}>
                <span class="switch-toggle-slider">
                    <span class="switch-on"><i class="bx bx-check"></i></span>
                    <span class="switch-off"><i class="bx bx-x"></i></span>
                </span>
                <span class="switch-label font-13">فقط موجودها</span>
            </label>
        </div>

        <div class="col-lg-4 mb-3 align-self-end">
            <label class="switch switch-square">
                <input type="checkbox" class="switch-input" name="featured_products_recommended" {{$row->featured_products_recommended ? 'checked' : ''}}>
                <span class="switch-toggle-slider">
                    <span class="switch-on"><i class="bx bx-check"></i></span>
                    <span class="switch-off"><i class="bx bx-x"></i></span>
                </span>
                <span class="switch-label font-13">فقط ویژه ها</span>
            </label>
        </div>


        <div class="col-lg-4 mb-3 align-self-end">
            <label class="switch switch-square">
                <input type="checkbox" class="switch-input" name="featured_products_discounted" {{$row->featured_products_discounted ? 'checked' : ''}}>
                <span class="switch-toggle-slider">
                    <span class="switch-on"><i class="bx bx-check"></i></span>
                    <span class="switch-off"><i class="bx bx-x"></i></span>
                </span>
                <span class="switch-label font-13">فقط تخفیف خورده‌ها</span>
            </label>
        </div>


    </div>
    <hr>
@endif
