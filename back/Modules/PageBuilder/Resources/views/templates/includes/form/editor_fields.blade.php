@if($row->widget_type == 'editor')

    <div class="row">
        {{-- featured products bg color --}}
        <div class="mb-3 col-lg-3">
            <label class="form-label" for="featured_products_bg_color">رنگ بکگراند</label>
            <input id="featured_products_bg_color{{$row->id}}" type="hidden" name="featured_products_bg_color" class="form-control form-control-sm" value="{{old('featured_products_bg_color',$row->featured_products_bg_color)}}">
            <div class="color-picker-monolith" data-default-color="{{$row->featured_products_bg_color}}" data-input-id="#featured_products_bg_color{{$row->id}}"></div>
        </div>


        {{-- featured_products_title_color --}}
        <div class="mb-3 col-lg-3">
            <label class="form-label" for="featured_products_title_color">رنگ متن</label>
            <input id="featured_products_title_color{{$row->id}}" type="hidden" name="featured_products_title_color" class="form-control form-control-sm" value="{{old('featured_products_title_color',$row->featured_products_title_color)}}">
            <div class="color-picker-monolith" data-default-color="{{$row->featured_products_title_color}}" data-input-id="#featured_products_title_color{{$row->id}}"></div>
        </div>

        <div class="col-lg-4 mb-3 align-self-end">
            <label class="switch switch-square">
                <input type="checkbox" class="switch-input" name="featured_products_available" {{$row->featured_products_available ? 'checked' : ''}}>
                <span class="switch-toggle-slider">
                    <span class="switch-on"><i class="bx bx-check"></i></span>
                    <span class="switch-off"><i class="bx bx-x"></i></span>
                </span>
                <span class="switch-label font-13">نمایش دکمه "مشاهده بیشتر"</span>
            </label>
        </div>
    </div>


    {{-- content --}}
    <div class="mb-4">
        <label class="form-label">محتوا</label>
        <textarea type="hidden" name="editor_content" aria-label="editor_content"
                  class="tinymceeditor">{{old('editor_content',$row->editor_content)}}</textarea>
    </div>
@endif
