<div class="box mb-3">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="section-title font-18 fw-bold mb-0">سبد خرید شما</h1>
        <a href="{{route('home')}}" class="underline-link">بازگشت <i
                    class="icon-chevron-left ml-1"></i></a>
    </div>


    {{-- coupon --}}
    @if($items->count() > 0)
        <div class="border rounded-2 p-0 mb-3">
            <div class="card border-0">
                <div
                    class="card-header border-0 rounded couponCollapse pt-0 pb-0 bg-white d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#couponCollapse" role="button"
                    aria-expanded="false">
                    <span class="font-16 d-inline-block mb-3 mt-3 text-success">کد تخفیف دارید؟</span>
                    <i class="icon-chevron-down"></i>
                </div>
                <div class="card-body p-0 collapse" id="couponCollapse">
                    <div class="ps-3 pe-3 align-items-center pb-4 d-flex pt-3">
                        <input type="text" id="couponCode" class="form-control"
                                placeholder="کد را وارد کنید" aria-label="code"
                                onkeydown="if (event.keyCode === 13) return false;">
                        <span class="btn btn-secondary custom ms-2 flex-shrink-0" id="btnCouponApply">بررسی کد تخفیف</span>
                    </div>
                </div>
            </div>
        </div>
        @if(cart()->getConditions()->count() > 0)
            <div class="border rounded-2 p-3 mb-3">
                <span class="form-title mb-3 d-block">تخفیف های اعمال شده</span>
                @foreach(cart()->getConditions() as $condiotion)
                    @php $coupon = \Modules\Coupons\Entities\Coupon::find($condiotion->getAttributes()['coupon_id']);@endphp
                    <div class="removable-alert">
                        <p class="font-16 m-0">
                            @if ($coupon->type == 'amount')
                                کد <span
                                    class="text-danger pr-1 pl-1 font-weight-bold font-15">{{$coupon->code}}</span>
                                تخفیف {{number_format($coupon->amount)}} تومانی
                            @else
                                کد <span
                                    class="text-danger pr-1 pl-1 font-weight-bold font-15">{{$coupon->code}}</span>
                                تخفیف {{$coupon->percent .'%'}} درصدی
                            @endif
                        </p>
                        <span class="remove btn-coupon-remove" data-code="{{$coupon->code}}"
                                data-condition-name="{{$condiotion->getName()}}"></span>
                    </div>
                @endforeach
            </div>
        @endif
    @endif


    {{-- empty alert --}}
    <div class="font-20 text-center pt-4 pb-4 alertEmpty {{$items->count() > 0 ? 'd-none':''}}">
        <img src="{{asset('assets/images/empty-cart2.png')}}" alt="empty cart"
                class="img-fluid mb-4">
        <p class="font-25 fw-800">سبد خرید شما خالی است <i class="icon-frown"></i></p>
        <a href="{{route('home')}}"
            class="btn btn-outline-secondary mt-4 mb-4 p-3 pr-5 pl-5"><span>بازگشت به فروشگاه</span><i
                    class="icon-shopping-cart ms-2"></i></a>
    </div>

    @foreach($items as $cartItem)
        @php
            $rowId = explode('_',$cartItem->id);
            $inventoryId = null;
            if (count($rowId) > 1){
                $inventoryId =$rowId[1];
            }
        @endphp
        <div class="box cart-page-item cart-item flex-wrap {{$loop->first ? '' : 'border-top-0'}}"
                product-id="{{$cartItem->associatedModel->id}}" row-id="{{$cartItem->id}}">
            <div class="w-100 d-flex align-items-center justify-content-start flex-column flex-lg-row p-2 p-lg-3">
                @if ($cartItem->associatedModel->inStock())
                    <span class="cart-page-item-delete" onclick="deleteFromCart(this)"
                            row-id="{{$cartItem->id}}">
                    <i class="icon-trash-2"></i></span>
                @endif
                <div class="image">
                    <img src="{{$cartItem->associatedModel->getImage('thumb')}}"
                            alt="{{$cartItem->associatedModel->title}}">
                </div>
                <div class="d-flex flex-column">
                    <a href="{{route('product.show',$cartItem->associatedModel)}}">
                        <h3 class="cart-page-item-title mt-2 mt-lg-0">{{$cartItem->associatedModel->title}}</h3>
                    </a>

                    {{-- display color and size --}}
                    @if($inventoryId)
                        @php $attributes = $cartItem['attributes'];
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

                    <div class="cart-quantity-box align-self-center align-self-lg-start me-3">
                            <span class="quantityAdd {{$cartItem->quantity < $cartItem->associatedModel->getStockQuantity($inventoryId) ? '':'d-none'}}"
                                    onclick="quantityAdd(this)"><i class="icon-plus"></i></span>
                        <p class="quantity">{{$cartItem->quantity}}</p>
                        <span class="quantityMinus {{$cartItem->quantity > 1 ? '':'d-none'}}"
                                onclick="quantityMinus(this)"><i class="icon-minus"></i></span>
                    </div>
                </div>
            </div>

            @if ($cartItem->associatedModel->getStockQuantity($inventoryId) < 1)
                <div class="font-14 text-danger d-block m-2 flex-shrink-0 w-100">
                    موجودی این محصول به اتمام رسیده است و امکان خرید آن وجود ندارد.
                </div>
            @endif

            @if ($cartItem->associatedModel->getStockQuantity($inventoryId) > 0)
                <div class="d-flex align-items-center w-100 cart-page-item-footer p-lg-3 p-2">
                            <span class="price-value me-3">
                            قیمت:
                        <span class="priceSum">{{number_format($cartItem->getPriceSum())}}</span> تومان
                    </span>
                    <!-- @if ($cartItem->associatedModel->discount_percent > 0)
                        <div class="d-flex align-items-center me-2">
                            <span class="text-danger ml-1">تخفیف: </span>
                            <span class="text-danger">
                                <span class="cartItemTotalDiscount">
                                    {{number_format($cartItem->associatedModel->getDiscountedPrice($inventoryId) * $cartItem->quantity)}}
                                </span> تومان
                            </span>
                        </div>
                    @endif -->
                </div>
            @endif

        </div>
    @endforeach
</div>