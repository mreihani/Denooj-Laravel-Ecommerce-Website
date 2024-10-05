@if(str_starts_with($row->widget_type,'featured_categories'))
    <div class="row">
        <div class="mb-3 col-lg-4">
            <label class="form-label">رنگ پوشش</label>
            <input id="{{'featured_categories_overlay_color_' . $row->id}}" type="hidden" name="featured_categories_overlay_color" class="form-control" value="{{old('featured_categories_overlay_color',$row->featured_categories_overlay_color)}}">
            <div class="color-picker-monolith" data-default-color="{{$row->featured_categories_overlay_color}}" data-input-id="{{'#featured_categories_overlay_color_' . $row->id}}"></div>
        </div>

        <div class="col-lg-4 mb-3 align-self-end">
            <label class="switch switch-square">
                <input type="checkbox" class="switch-input" name="featured_categories_show_count" {{$row->featured_categories_show_count ? 'checked' : ''}}>
                <span class="switch-toggle-slider">
                                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                                    </span>
                <span class="switch-label">نمایش تعداد محصولات</span>
            </label>
        </div>

        {{-- featured categories grid --}}
        @if($row->widget_type == 'featured_categories_grid')
            <div class="col-lg-4 mb-3">
                <label class="form-label">تعداد آیتم جهت نمایش</label>
                <input type="number" dir="ltr" class="form-control form-control-sm" name="featured_categories_grid_items_count" aria-label="featured_categories_grid_items_count" value="{{$row->featured_categories_grid_items_count}}">
            </div>

            <div class="col-lg-4 mb-3">
                <label class="form-label">تعداد آیتم در سطر (دسکتاپ)</label>
                <select class="form-select form-select-sm" name="featured_categories_grid_item_per_row" aria-label="featured_categories_grid_item_per_row">
                    <option value="12" {{$row->featured_categories_grid_item_per_row == '12' ? 'selected' : ''}}>1</option>
                    <option value="6" {{$row->featured_categories_grid_item_per_row == '6' ? 'selected' : ''}}>2</option>
                    <option value="4" {{$row->featured_categories_grid_item_per_row == '4' ? 'selected' : ''}}>3</option>
                    <option value="3" {{$row->featured_categories_grid_item_per_row == '3' ? 'selected' : ''}}>4</option>
                    <option value="2" {{$row->featured_categories_grid_item_per_row == '2' ? 'selected' : ''}}>6</option>
                </select>
            </div>

            <div class="col-lg-4 mb-3">
                <label class="form-label">تعداد آیتم در سطر (تبلت)</label>
                <select class="form-select form-select-sm" name="featured_categories_grid_item_per_row_tablet" aria-label="featured_categories_grid_item_per_row_tablet">
                    <option value="12" {{$row->featured_categories_grid_item_per_row_tablet == '12' ? 'selected' : ''}}>1</option>
                    <option value="6" {{$row->featured_categories_grid_item_per_row_tablet == '6' ? 'selected' : ''}}>2</option>
                    <option value="4" {{$row->featured_categories_grid_item_per_row_tablet == '4' ? 'selected' : ''}}>3</option>
                    <option value="3" {{$row->featured_categories_grid_item_per_row_tablet == '3' ? 'selected' : ''}}>4</option>
                </select>
            </div>


            <div class="col-lg-4 mb-3">
                <label class="form-label">تعداد آیتم در سطر (موبایل)</label>
                <select class="form-select form-select-sm" name="featured_categories_grid_item_per_row_mobile" aria-label="featured_categories_grid_item_per_row_mobile">
                    <option value="12" {{$row->featured_categories_grid_item_per_row_mobile == '12' ? 'selected' : ''}}>1</option>
                    <option value="6" {{$row->featured_categories_grid_item_per_row_mobile == '6' ? 'selected' : ''}}>2</option>
                    <option value="4" {{$row->featured_categories_grid_item_per_row_mobile == '4' ? 'selected' : ''}}>3</option>
                </select>
            </div>
        @endif
    </div>
    <hr>
@endif
