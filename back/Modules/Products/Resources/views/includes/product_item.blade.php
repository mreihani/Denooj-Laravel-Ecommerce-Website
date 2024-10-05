<article class="v-product-item {{isset($class) ? $class : ''}}">
    <div class="v-product-item-image">
        @if($product->label)
        <div class="product-label">{{$product->label}}</div>
        @endif
        <a href="{{route('product.show',$product)}}" title="{{$product->title}}">
            <img src="{{$product->getImage('medium')}}" title="{{$product->title}}" alt="{{$product->title}}">
        </a>

        {{-- colors --}}
        @if($product->product_type == 'variation')
            <div class="product-item-colors">
            @foreach($product->getInventoryColors() as $pColorId)
                @php $pColor = \Modules\Products\Entities\ProductColor::find($pColorId); @endphp
                @if($pColor)
                    <div class="product-item-color" style="background-color: {{$pColor->hex_code}}"></div>
                @endif
            @endforeach
            </div>
        @endif
    </div>
    <div class="v-product-item-content">
        <a href="{{route('product.show',$product)}}" class="text-decoration-none" title="{{$product->title}}">
            <h3 class="title">{{$product->title}}</h3>
        </a>

        {!! $product->getPriceHtml('mt-2 mt-sm-0') !!}
    </div>
    <div class="v-product-item-footer">

        @if(isset($favoritesPage) && $favoritesPage)
            <span class="btn btn-danger btn-sm no-transform w-100 me-2 btn-favorite-remove" data-id="{{$product->id}}">حذف از علاقه‌مندی</span>
        @else

        {{-- add to cart --}}
            @if($product->cart_button_link)
                <a class="btn btn-primary btn-sm no-transform v-product-item-btn me-2" href="{{$product->cart_button_link}}">
                    <i class="icon-plus"></i>
                    <!-- <span class="font-13">{{$product->cart_button_text ?? 'افزودن به سبد'}}</span> -->
                </a>
            @else
                @if($product->inStock())
                    @if(cart()->has($product->id))
                        <a class="btn btn-primary btn-sm no-transform v-product-item-btn me-2" href="{{route('cart')}}">
                            <i class="icon-plus font-13"></i>
                            <!-- <span>سبد خرید</span> -->
                        </a>
                    @else
                        @if($product->product_type == 'variation')
                            <a class="btn btn-primary btn-sm no-transform v-product-item-btn me-2" href="{{route('product.show',$product)}}">
                                <i class="icon-plus"></i><span class="font-13">انتخاب گزینه ها</span>
                            </a>
                        @else
                            <a class="btn btn-primary btn-sm no-transform v-product-item-btn me-2" data-id="{{$product->id}}" onclick="addToCart(this)" href="javascript:">
                                <i class="icon-plus"></i>
                                <!-- <span class="font-13">افزودن به سبد</span> -->
                            </a>
                        @endif

                    @endif
                @else
                    <span class="text-danger me-auto d-block">{{$product->getDisplayStock()}}</span>
                @endif
            @endif


{{--        <a href="{{route('product.show',$product)}}" class="btn btn-no-bg btn-sm no-transform flex-shrink-0 ms-2 btn-quicklook" data-bs-toggle="tooltip" data-bs-placement="top" title="مشاهده محصول"><i class="icon-eye font-20"></i></a>--}}

        {{-- favorite toggle --}}
        <a @auth data-id="{{$product->id}}" onclick="bookmark(this)" href="javascript:" @else href="{{route('signin')}}" @endauth class="btn btn-no-bg btn-sm no-transform flex-shrink-0 denooj-product-bookmark" data-bs-toggle="tooltip" data-bs-placement="top" title="افزودن به علاقه مندی ها">
            @if($product->liked())
                <i class="icon-heart text-danger font-20"></i>
            @else
                <i class="icon-heart font-20"></i>
            @endif
        </a>
        @endif
    </div>
</article>
