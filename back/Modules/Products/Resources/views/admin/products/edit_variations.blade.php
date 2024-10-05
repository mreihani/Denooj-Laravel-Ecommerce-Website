{{--@php $colors = \Modules\Products\Entities\ProductColor::find($product->getInventoryColors()); @endphp--}}
@php $sizes = \Modules\Products\Entities\ProductSize::find($product->getInventorySizes()); @endphp

@if($product->variation_type == 'color')
    <div class="accordion mt-3 accordion-header-primary accordion-outlined" id="variationsAccordion">
        @foreach($product->getColors() as $color)
            @php $inventory = \Modules\Products\Entities\ProductInventory::where('product_id',$product->id)->where('color_id',$color->id)->first(); @endphp
            <div
                class="card accordion-item color_variation_accordion_{{$color->name}}">
                <h2 class="accordion-header">
                    <button type="button" class="accordion-button"
                            data-bs-toggle="collapse"
                            data-bs-target="#accordion-color-{{$color->name}}"
                            aria-expanded="true">
                                                            <span class='color-square'
                                                                  style='background-color: {{$color->hex_code}}'></span>
                        {{$color->label}}
                        <span
                            class="btn-remove-variation btn btn-sm btn-label-danger ms-auto me-3 px-1"
                            data-type="color"
                            data-variation-code="{{$color->name}}"><i
                                class='bx bx-trash-alt'></i></span>
                    </button>
                </h2>
                <div id="accordion-color-{{$color->name}}"
                     class="accordion-collapse collapse"
                     data-bs-parent="#variationsAccordion">
                    <div class="accordion-body" id="accordion_body_{{\Illuminate\Support\Str::random(6)}}">
                        @include('products::admin.products.variations.color_fields', ['inventory' => $inventory,'colorModel' => $color])
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@elseif($product->variation_type == 'size')
    <div class="accordion mt-3 accordion-header-primary accordion-outlined" id="variationsAccordion">
        @foreach($product->getSizes() as $size)
            @php $inventory = \Modules\Products\Entities\ProductInventory::where('product_id',$product->id)->where('size_id',$size->id)->first(); @endphp
            <div class="card accordion-item size_variation_accordion_{{$size->name}}">
                <h2 class="accordion-header">
                    <button type="button" class="accordion-button"
                            data-bs-toggle="collapse"
                            data-bs-target="#accordion-size-{{$size->name}}"
                            aria-expanded="true">
                        {{$size->label}}
                        <span
                            class="btn-remove-variation btn btn-sm btn-label-danger ms-auto me-3 px-1"
                            data-type="size"
                            data-variation-code="{{$size->name}}"><i
                                class='bx bx-trash-alt'></i></span>
                    </button>
                </h2>
                <div id="accordion-size-{{$size->name}}"
                     class="accordion-collapse collapse"
                     data-bs-parent="#variationsAccordion">
                    <div class="accordion-body" id="accordion_body_{{\Illuminate\Support\Str::random(6)}}">
                        @include('products::admin.products.variations.size_fields', ['inventory' => $inventory,'sizeModel' => $size])
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@elseif($product->variation_type == 'color_size')
    <div class="accordion mt-3 accordion-header-primary accordion-outlined" id="variationsAccordion">
        @foreach($product->getColors() as $color)
            <div class="card accordion-item color_variation_accordion_{{$color->name}}">
                <h2 class="accordion-header">
                    <button type="button" class="accordion-button"
                            data-bs-toggle="collapse"
                            data-bs-target="#accordion-color-{{$color->name}}"
                            aria-expanded="true">
                                                            <span class='color-square'
                                                                  style='background-color: {{$color->hex_code}}'></span>
                        {{$color->label}}
                        <span
                            class="btn-remove-variation btn btn-sm btn-label-danger ms-auto me-3 px-1"
                            data-type="color"
                            data-variation-code="{{$color->name}}"><i
                                class='bx bx-trash-alt'></i></span>
                    </button>
                </h2>
                <div id="accordion-color-{{$color->name}}" class="accordion-collapse collapse" data-bs-parent="#variationsAccordion">
                    <div class="accordion-body" id="accordion_body_{{\Illuminate\Support\Str::random(6)}}">


                        <div class="accordion mt-3 accordion-header-primary accordion-outlined" id="{{'sizeVariationsAccordion'.$color->name}}">
                            @foreach($product->getSizes() as $size)
                                @php $inventory = \Modules\Products\Entities\ProductInventory::where('product_id',$product->id)->where('size_id',$size->id)->where('color_id',$color->id)->first(); @endphp
                                <div class="card accordion-item size_variation_accordion_{{$size->name}}">
                                    <h2 class="accordion-header">
                                        <button type="button" class="accordion-button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#accordion-size-{{$size->name}}"
                                                aria-expanded="true">
                                            {{$size->label}}
                                            <span
                                                class="btn-remove-variation btn btn-sm btn-label-danger ms-auto me-3 px-1"
                                                data-type="size"
                                                data-variation-code="{{$size->name}}"><i
                                                    class='bx bx-trash-alt'></i></span>
                                        </button>
                                    </h2>
                                    <div id="accordion-size-{{$size->name}}" class="accordion-collapse collapse" data-bs-parent="{{'#sizeVariationsAccordion'.$color->name}}">
                                        <div class="accordion-body" id="accordion_body_{{\Illuminate\Support\Str::random(6)}}">
                                            @include('products::admin.products.variations.size_fields', ['inventory' => $inventory,'sizeModel' => $size, 'colorModel' => $color])
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
