<span class="font-15 fw-bold d-inline-block mb-3">جزئیات سبد خرید</span>

<ul class="list-group">
    <!-- <li class="list-group-item d-flex justify-content-between font-13">
        <span>تعداد محصولات:</span>
        <span class="cartCount font-16">{{$items->count()}}</span>
    </li> -->

    <!-- <li class="list-group-item d-flex justify-content-between font-13">جمع تعداد کل محصولات:
        <span id="cartTotalQuantity" class="font-16">{{$totalQuantity}}</span>
    </li> -->

    <li class="list-group-item d-flex justify-content-between font-13">وزن برنج:
        <span id="total-weight" class="font-16">
            <span class="total-weight">
                {{number_format($totalWeight)}}
            </span>
            کیلوگرم
        </span>
    </li>

    <li class="list-group-item d-flex justify-content-between font-13">جمع سفارش بدون تخفیف:
        <div>
            <span class="cartTotal me-1 font-16 price-value">{{number_format(cart()->getSubTotalWithoutConditions() + $totalDiscount)}}</span>
            <span>تومان</span>
        </div>
    </li>
    
    <li class="list-group-item d-flex justify-content-between font-13 subtotal-container">جمع
        بعد از تحفیف:
        <div>
        <span
            class="subTotal me-1 font-16 price-value text-success">{{number_format(cart()->getSubTotal())}}</span>
            <span>تومان</span>
        </div>
    </li>

    <!-- <li class="list-group-item d-flex justify-content-between font-13">مجموع تخفیف محصولات:
        <div class="text-danger">
            <span class="font-16 price-value me-1"
                    id="cartTotalDiscount">{{number_format($totalDiscount)}}</span>
            <span>تومان</span>
        </div>
    </li> -->

    @if(cart()->getConditions()->count() > 0)
        <li class="list-group-item d-flex justify-content-between font-13">
            <span class="text-nowrap">
                هزینه ارسال:
            </span>
            <ul class="list-group list-group-flush mt-2">
                <li class="list-group-item pb-1 ps-1">
                    <span
                        class="font-12 ms-1 d-inline-block">
                        <span class="text-danger">5</span> کیلوگرم {{number_format($shippingSettings->post_cost_off_five)}} ت 
                    </span>
                </li>
                <li class="list-group-item pb-1 ps-1">
                    <span
                        class="font-12 ms-1 d-inline-block">
                        <span class="text-danger">10</span> کیلوگرم {{number_format($shippingSettings->post_cost_off_ten)}} ت
                    </span>
                </li>
                <li class="list-group-item pb-1 ps-1">
                    <span
                        class="font-12 ms-1 d-inline-block">
                        <span class="text-danger">20</span> کیلوگرم {{number_format($shippingSettings->post_cost_off_twenty)}} ت
                    </span>
                </li>
                <li class="list-group-item pb-1 ps-1 fw-bolder">
                    <span
                        class="font-12 ms-1 d-inline-block ">
                        اگر سفارش خود را به بالای <span class="text-danger">40</span> کیلوگرم برسانید، بار شما از طریق باربری ارسال خواهد شد در نتیجه 60 الی 80 درصد در هزینه ارسال <span class="text-success">&nbsp;صرفه جویی&nbsp;</span> خواهد گردید. همچنین بار شما <span class="text-success">&nbsp;ایمن تر&nbsp;</span> و <span class="text-success">&nbsp;سریع تر&nbsp;</span> به دستتان خواهد رسید.
                    </span>
                </li>
            </ul>
        </li>
    @else    
        <li class="list-group-item d-flex justify-content-between font-13">
            <span class="text-nowrap">
                هزینه ارسال:
            </span>
            <ul class="list-group list-group-flush mt-2">
                <li class="list-group-item pb-1 ps-1">
                    <span
                        class="font-12 ms-1 d-inline-block">
                        <span class="text-danger">5</span> کیلوگرم {{number_format($shippingSettings->post_cost_five)}} ت 
                    </span>
                </li>
                <li class="list-group-item pb-1 ps-1">
                    <span
                        class="font-12 ms-1 d-inline-block">
                        <span class="text-danger">10</span> کیلوگرم {{number_format($shippingSettings->post_cost_ten)}} ت
                    </span>
                </li>
                <li class="list-group-item pb-1 ps-1">
                    <span
                        class="font-12 ms-1 d-inline-block">
                        <span class="text-danger">20</span> کیلوگرم {{number_format($shippingSettings->post_cost_twenty)}} ت
                    </span>
                </li>
                <li class="list-group-item pb-1 ps-1 fw-bolder">
                    <span
                        class="font-12 ms-1 d-inline-block ">
                        بالای <span class="text-danger">40</span> کیلوگرم ارسال از طریق باربری <span class="text-success">&nbsp;&nbsp;رایگان</span>
                    </span>
                </li>
            </ul>
        </li>
    @endif
</ul>