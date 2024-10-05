@php
    $newest = strpos(request()->getRequestUri(),'?sort=-created_at');
    $oldest = strpos(request()->getRequestUri(),'?sort=created_at');
    $expensive = strpos(request()->getRequestUri(),'?sort=-price');
    $cheapest = strpos(request()->getRequestUri(),'?sort=price');
    $bestSelling = strpos(request()->getRequestUri(),'?sort=-sell_count');
    $discount = strpos(request()->getRequestUri(),'?sort=-discount_percent');
    $default = false;
    if (!$newest && !$oldest && !$expensive && !$cheapest && !$bestSelling && !$discount){
        $default = true;
    }
@endphp

<div class="product-orders">
    <div class="mobile-section-head flex992">
        <span class="font-18"><i class="icon-bar-chart-2"></i> نمایش بر اساس</span>
        <span class="close" id="closeOrders"><i class="icon-x"></i></span>
    </div>
    <span class="d992hide"><i class="icon-filter"></i> ترتیب نمایش</span>
    <div class="items">
        <a href="#" class="{{$newest || $default ? 'active':''}}"
           id="sortNewest">جدیدترین</a>
        <a href="#" class="{{$oldest ? 'active':''}}"
           id="sortOldest">قدیمی ترین</a>
        <a href="#"
           class="{{$expensive ? 'active':''}}"
           id="sortExpensive">گرانترین</a>
        <a href="#"
           class="{{$cheapest ? 'active':''}}"
           id="sortCheapest">ارزانترین</a>
        <a href="#" class="{{$bestSelling ? 'active':''}}"
           id="sortBestSelling">پرفروش ترین</a>
        <a href="#"
           class="{{$discount ? 'active':''}}"
           id="sortDiscount">بیشترین تخفیف</a>
    </div>
    <span class="mr-auto text-muted font-14">{{$count . ' کالا'}}</span>
</div>
