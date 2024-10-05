<div class="box p-3 mb-3">
    <div class="section-title font-17 fw-bold mb-4 d-flex align-items-center">
        <i class="icon-grid me-2 mb-1 text-muted"></i>
        <span>اقلام سفارش</span>
    </div>


    {{-- order items --}}
    <table class="table table-bordered mb-0">
        <tbody>
        @foreach(cart()->getContent() as $cartItem)
            @php
                $rowId = explode('_',$cartItem->id);
                $inventoryId = null;
                if (count($rowId) > 1){
                    $inventoryId =$rowId[1];
                }
            @endphp
            <tr>
                <th>
                    <div class="d-flex align-items-start align-items-lg-center text-start">
                        <a href="{{route('product.show',$cartItem->associatedModel)}}">
                            <img src="{{$cartItem->associatedModel->getImage('thumb')}}"
                                 alt="product" class="img50 rounded d-inline-block">
                        </a>
                        <div class="d-flex flex-column ms-2">
                            <a href="{{route('product.show',$cartItem->associatedModel)}}"
                               class="product-table-item-title">
                                {{$cartItem->associatedModel->title}}
                            </a>
                            {{-- display color and size --}}
                            @if($inventoryId)
                                @php $attributes = $cartItem['attributes'];
                                                            $color = $attributes['color'];
                                                            $size = $attributes['size'];
                                @endphp
                                <div class="mb-2 d-flex flex-column flex-lg-row align-items-lg-center">
                                    @if($color)
                                        <div class="d-inline-flex font-13 me-3">
                                            <span class="color-square" style="background-color: {{$color['hex_code']}}"></span>
                                            رنگ: {{$color['label']}}
                                        </div>
                                    @endif
                                    @if($size)
                                        <div class="d-inline-flex font-13">
                                            سایز: {{$size['label']}}
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                    </div>
                </th>
                <th class="align-middle fw-normal font-14" style="min-width: 55px;">
                    {{$cartItem->quantity . ' عدد'}}
                </th>
                <th class="align-middle fw-normal font-14">
                    @if(!empty($cartItem->associatedModel->sale_price)) 
                        <div class="d-flex flex-column align-items-start product-price-container">
                            <span class="price me-2 dash-on">
                                {{number_format($cartItem->associatedModel->price * $cartItem->quantity)}}
                            </span>
                            <div class="d-flex w-100 justify-content-between align-items-end">
                                <span class="price color-green fw-800">
                                    {{number_format($cartItem->associatedModel->sale_price * $cartItem->quantity)}} تومان
                                </span>
                                <span class="bg-danger text-white rounded px-2 pt-1 ms-3 font-12">
                                    %{{$cartItem->associatedModel->discount_percent}}
                                </span>
                            </div>
                        </div>
                    @else 
                        <div class="d-flex flex-column align-items-start product-price-container">
                            <div class="d-flex w-100 justify-content-between align-items-end">
                                <span class="price color-green fw-800">
                                    {{number_format($cartItem->associatedModel->price * $cartItem->quantity)}} تومان
                                </span>
                            </div>
                        </div>
                    @endif
                </th>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

