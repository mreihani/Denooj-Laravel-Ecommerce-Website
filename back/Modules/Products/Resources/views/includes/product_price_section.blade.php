<div class="mt-sm-4 mt-2 d-flex align-items-center">
    @if(cart()->has($product->id))
        <a href="{{route('cart')}}"
           class="btn btn-success btn-lg px-lg-5 btn-add-to-cart">
            <span class="font-20 font-sm-16">تکمیل خرید</span>
            <i class="icon-arrow-left ms-2"></i>
        </a>
    @else
        <span class="btn btn-primary btn-lg px-lg-5 btn-add-to-cart" id="product-add-to-cart" data-id="{{$product->id}}">
            <i class="icon-shopping-cart me-2"></i>
            <span class="font-20 font-sm-16">{{$product->cart_button_text ?? 'افزودن به سبد'}}</span>
        </span>
    @endif
    {{-- quantity --}}
        @if($product->product_type == 'simple')
            @if(!cart()->has($product->id))
                <div class="quantity-box ms-3 flex-shrink-0">
                    <span class="increase"><i class="icon-plus"></i></span>
                    <span class="count" id="quantity">1</span>
                    <span class="decrease"><i class="icon-minus"></i></span>
                </div>
            @endif
        @endif
</div>

