<div class="box p-3 mb-3">
    <div class="section-title font-17 fw-bold mb-4 d-flex align-items-center">
        <i class="icon-info me-2 mb-1 text-muted"></i>
        <span>جزئیات سفارش</span>
    </div>

    {{-- order items --}}
    <table class="table table-bordered mb-0">
        <tr>
            <th>
                <span class="fw-normal font-14">جمع سفارش بدون تخفیف:</span>
            </th>
            <th class="text-center">
                <span class="fw-normal font-14 total-price-without-discount">{{number_format(cart()->getSubTotalWithoutConditions() + $totalDiscount)}}</span> تومان
            </th>
        </tr>
        <tr>
            <th>
                <span class="fw-normal font-14">وزن کل:</span>
            </th>
            <th class="text-center">
                <span class="fw-normal font-14">
                    <span class="total-weight">
                    {{number_format($totalWeight)}}
                    </span>
                    کیلوگرم
                </span>
            </th>
        </tr>

        <tr>
            <th>
                <span class="fw-normal font-14">روش ارسال:</span>
            </th>
            <th class="text-center">
                <input type="hidden" id="shippingMethodImagePost" value="{{$shippingSettings->post_logo ?? asset('assets/images/tipax.png')}}">
                <input type="hidden" id="shippingMethodImageFreightage" value="{{$shippingSettings->freightage_logo ?? asset('assets/images/tipax.png')}}">

                <input type="hidden" id="shippingMethodNamePost" value="{{$shippingSettings->post_title ?? 'پست'}}">
                <input type="hidden" id="shippingMethodNameFreightage" value="{{$shippingSettings->freightage_title ?? 'باربری'}}">

                <img src="" alt="shipping" id="shippingMethodImage" class="d-none" style="width: 80px;margin-left: 10px">
                <span class="fw-normal font-14" id="shippingMethodName">وابسته به آدرس</span>
            </th>
        </tr>
    
        <tr>
            <th>
                <span class="fw-normal font-14">هزینه ارسال:</span>
            </th>
            <th class="text-center">
                <span class="fw-normal font-14" id="totalShippingCost">وابسته به آدرس</span>
            </th>
        </tr>

        <tr>
            <th>
                <span class="fw-normal font-14">جمع کل تخفیفات:</span>
            </th>
            <th class="text-center">
                <span class="fw-normal font-14 text-danger total-discount">{{number_format($totalDiscount + cart()->getSubTotalWithoutConditions() - cart()->getSubTotal())}}</span> تومان
            </th>
        </tr>
        
        <!-- @if(cart()->getConditions()->count() > 0)
            <tr>
                <th>
                    <span class="fw-normal font-14">قیمت بعد از تخفیف:</span>
                </th>
                <th class="text-center">
                    <span class="fw-normal font-14 text-danger">{{number_format(cart()->getSubTotal()) . ' تومان'}}</span>
                </th>
            </tr>
        @endif -->
        <tr>
            <th>
                <span class="fw-normal font-14">مبلغ قابل پرداخت:</span>
            </th>
            <th class="text-center">
                <span class="fw-900 text-success font-14 price-to-pay">{{number_format(cart()->getTotal())}}</span>
                <span class="fw-900 text-success font-14">تومان</span>
            </th>
        </tr>
    </table>

    <div class="accordion mt-4" id="accordionExample">
        {{-- freightage delivery --}}
        @if($shippingSettings->freightage)
            <div class="accordion-item freightage-accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <label for="radioOne" class="accordion-button collapsed cursor_pointer" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        <input type="radio" name="accordion" id="radioOne" class="accordion-radio me-1">
                        <img src="{{$shippingSettings->freightage_logo}}" alt="freightage" class="me-2" style="height: 50px; width: auto;max-width: 100%">
                        {{$shippingSettings->freightage_title}}
                    </label>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <!-- <div class="accordion-body">
                        <strong>
                        در این روش هزینه ای هنگام ثبت سفارش توسط مشتری پراخت نمی شود بلکه بعد از تحویل مرسوله، هزینه ارسال توسط مشتری به شرکت حمل و نقل پرداخت می شود.
                        </strong>
                    </div> -->
                </div>
            </div>
        @endif

        {{-- post delivery --}}
        @if($shippingSettings->post)
            <div class="accordion-item post-accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <label for="radioTwo" class="accordion-button collapsed cursor_pointer" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <input type="radio" name="accordion" id="radioTwo" class="accordion-radio me-1">
                        <img src="{{$shippingSettings->post_logo}}" alt="post" class="me-2" style="height: 50px; width: auto;max-width: 100%">
                        {{$shippingSettings->post_title}}
                    </label>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <!-- <div class="accordion-body">
                        <strong>
                        یکی از مرسوم ترین روش های ارسال مرسولات، ارسال از طریق سامانه پست ملی ایران است. با توجه به وزن محصول هزینه پستی محاسبه می شود.
                        </strong>
                    </div> -->
                </div>
            </div>
        @endif
    </div>

    <div class="alert alert-danger mt-1 freightage-alert-body d-none text-dark">
        <span class="text-dark fw-normal font-13">
        ⚠ هزینه ارسال <span class="freightage-alert-weight"></span> کیلوگرم تا درب منزل از طریق پست <span class="freightage-alert-price"></span> تومان می باشد، اما اگر گزینه ارسال با باربری انتخاب شود ارسال بار <span class="text-success fw-bolder">ایمن تر</span>،&nbsp;<span class="text-success fw-bolder">سریعتر</span>&nbsp;و&nbsp;<span class="text-success fw-bolder">رایگان</span> خواهد بود!
        </span>
    </div>
    
    <div class="alert alert-danger mt-1 freightage-alert-body-coupon d-none">
        <span class="text-dark">
        ⚠ هزینه ارسال <span class="freightage-alert-weight"></span> کیلوگرم تا درب منزل از طریق پست <span class="freightage-alert-price"></span> تومان می باشد، اما اگر گزینه ارسال با باربری انتخاب شود ارسال از طریق باربری خواهد بود و 60 تا 80 درصد در هزینه صرفه جویی می گردد، ضمنا برنج شما سریع تر و ایمن تر به دست شما خواهد رسید.
        </span>
    </div>

</div>


