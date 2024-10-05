@if($row->widget_type == 'faq')

    <div class="col-12 mb-3">
        <label class="form-label">عنوان</label>
        <input aria-label="featured_products_title" class="form-control form-control-sm" type="text" name="featured_products_title"
               value="{{old('featured_products_title',$row->featured_products_title)}}">
    </div>

    <hr>

    {{-- faq --}}
    <div class="mb-3">
        <label class="form-label">آیتم ها</label>

        <div id="faq-items">
            @if($row->faq)
                @foreach($row->faq as $item)
                    <?php $itemName = \Illuminate\Support\Str::random(6);?>
                    <div class='row align-items-end' id='faq_row_{{$itemName}}'>
                        <div class='mb-3 col-12'>
                            <label for="item_faq_{{$itemName}}" class="form-label">عنوان</label>
                            <input class="form-control text-start" type="text" id="item_faq_{{$itemName}}" name="item_faq_{{$itemName}}[]"
                                   value="{{old('item_faq_' . $itemName,$item[0])}}">
                        </div>

                        <div class='mb-3 col-12'>
                            <label for="item_faq_{{$itemName}}" class="form-label">متن</label>
                            <textarea class="form-control text-start" type="text" id="item_faq_{{$itemName}}" name="item_faq_{{$itemName}}[]">{{old('item_faq_' . $itemName,$item[1])}}</textarea>
                        </div>

                        <div class='mb-3 col-lg-2'>
                            <span class='btn btn-label-danger btn-remove-faq' data-delete='faq_row_{{$itemName}}'><i class='bx bx-trash'></i></span>
                        </div>

                        <div class='col-12'><hr></div>
                    </div>
                @endforeach
            @endif
        </div>
        <span class="btn btn-primary add-more-faq btn-sm"><i class="bx bx-plus"></i> افزودن آیتم</span>
    </div>

    <hr>
@endif
