<div class="mini-shopping-cart">

    <?php
    $cartContent = cart()->getContent();
    $cartCount = $cartContent->count();
    $cartTotal = cart()->getTotal();
    ?>

    <div class="mini-cart-head">
        <span class="font-17 fw-800 d-inline-block"><span>سبد خرید</span><span class="text-muted ms-2 font-13">(<span id="mini_cart_count">{{$cartCount}}</span> مورد)</span></span>
        <span class="close-cart"><i class="icon-x"></i></span>
    </div>

    {{-- cart items --}}
    @if($currentRouteName != 'cart' && $currentRouteName != 'checkout')
        <div class="mini-cart-items">

            {{-- empty alert --}}
            <div class="alertEmpty {{$cartCount > 0 ? 'd-none':''}} p-5">
                <img src="{{asset('assets/images/empty-cart2.png')}}" alt="shopping cart" class="img-fluid pr-5 pl-5 mt-4">
                <span class="text-nowrap font-18 font-weight-bold text-muted d-block text-center mt-4">سبد خریدتان خالی است</span>
            </div>

            @foreach($cartContent as $item)
                @php
                    $rowId = explode('_',$item->id);
                    $inventoryId = null;
                    if (count($rowId) > 1){
                        $inventoryId =$rowId[1];
                    }

                @endphp
                <div class="h-product-item">
                    <div class="h-product-item-thumb">
                        <a href="{{route('product.show',$item->associatedModel)}}">
                            <img src="{{$item->associatedModel->getImage('thumb')}}" alt="{{$item->associatedModel->title}}">
                        </a>
                    </div>
                    <div class="h-product-item-content">
                        <a href="{{route('product.show',$item->associatedModel)}}" class="title">{{$item->associatedModel->title}}</a>

                        {{-- display color and size --}}
                        @if($inventoryId)
                            @php $attributes = $item['attributes'];
                                            $color = $attributes['color'];
                                            $size = $attributes['size'];
                            @endphp
                            <div class="mb-2 d-flex align-items-lg-center">
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

                        <div class="d-flex">
                    <span class="price text-dark me-2">
                        {{number_format($item->price)}}{{$item->associatedModel->sale_price ? '' : ' تومان'}}
                    </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span>تعداد: {{$item->quantity}}</span>
                            <span class="btn btn-sm btn-outline-danger no-transform cart-menu-remove" data-id="{{$item->id}}"><i class="icon-trash-2"></i></span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mini-cart-footer {{$cartCount < 1 ? 'd-none':''}}">
            <div class="d-flex flex-column">
                <span class="font-13">جمع کل:</span>
                <span class="fw-800 font-17 d-block mt-2"><span id="mini_cart_total">{{number_format($cartTotal)}}</span> تومان</span>
            </div>
            <a href="{{route('cart')}}" class="btn btn-success shadow"><span>تکمیل خرید</span><i class="icon-arrow-left ms-2"></i></a>
        </div>
    @endif

</div>
<div class="backdrop mini-cart-backdrop"></div>
