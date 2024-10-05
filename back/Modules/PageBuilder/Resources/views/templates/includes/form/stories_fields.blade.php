@if($row->widget_type == 'stories')
    <div class="row">
        <div class="mb-3 col-lg-4">
            <label class="form-label">رنگ حاشیه بندانگشتی ها</label>
            <input id="{{'stories_stroke_color_' . $row->id}}" type="hidden" name="stories_stroke_color" class="form-control" value="{{old('stories_stroke_color',$row->stories_stroke_color)}}">
            <div class="color-picker-monolith" data-default-color="{{$row->stories_stroke_color}}" data-input-id="{{'#stories_stroke_color_' . $row->id}}"></div>
        </div>


        <div class="col-lg-4 mb-3">
            <label class="form-label">شکل بندانگشتی ها</label>
            <select class="form-select form-select-sm" name="stories_shape" aria-label="stories_shape">
                <option value="circle" {{$row->stories_shape == 'circle' ? 'selected' : ''}}>دایره</option>
                <option value="square" {{$row->stories_shape == 'square' ? 'selected' : ''}}>مربعی</option>
            </select>
        </div>

        <div class="col-lg-4 mb-3 align-self-end">
            <label class="switch switch-square">
                <input type="checkbox" class="switch-input" name="stories_show_title" {{$row->stories_show_title ? 'checked' : ''}}>
                <span class="switch-toggle-slider">
                                                <span class="switch-on"><i class="bx bx-check"></i></span>
                                                <span class="switch-off"><i class="bx bx-x"></i></span>
                                            </span>
                <span class="switch-label">نمایش عنوان ها</span>
            </label>
        </div>
    </div>
    <hr>
@endif
