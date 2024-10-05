<section class="section">
    <div class="{{$row->layout == 'box' ? 'custom-container' : ''}}">
    {{-- head --}}
    <div class="section-title mb-4 section-product-head">

        {{-- title --}}
        <div class="d-flex flex-column justify-content-start">
            <div class="d-flex align-items-center {{$row->featured_products_subtitle ? 'mb-2' : ''}}">
                <div class="section-title-mark">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="mb-0 ms-2 font-20 fw-800 title">{{$row->featured_products_title}}</div>
            </div>
            @if($row->featured_products_subtitle)
                <p class="m-0 font-14 fw-normal text-muted me-3">{{$row->featured_products_subtitle}}</p>
            @endif
        </div>

        {{-- left content --}}
        @if($row->featured_products_btn_link)
            <div class="d-flex align-items-center ms-auto">
                <a href="{{$row->featured_products_btn_link}}" class="btn-section-more ms-4"><span>مشاهده همه</span></a>
            </div>
        @endif
    </div>

    {{-- carousel --}}
    <div class="swiper products-swiper-categories swiper-equal" id="featuredProductsSwiper{{$row->id}}">
        <div class="swiper-wrapper">
            @php
                $featuredProducts = \Modules\Products\Entities\Product::query()->published();

                if ($row->featured_products_available){
                    $featuredProducts->available();
                }
                 if ($row->featured_products_recommended){
                    $featuredProducts->recommended();
                }

                if ($row->featured_products_discounted){
                    $featuredProducts->hasDiscount();
                }

                // categories filter
                if ($row->featured_products_categories_source){
                    $categoryIds = $row->featured_products_categories_source;
                foreach ($categoryIds as $categoryId) {
                    $category = \Modules\Products\Entities\Category::find($categoryId);
                    $subCategoryIds = $category->subCategories->pluck('id')->toArray();
                    $categoryIds = array_merge($categoryIds,$subCategoryIds);
                    foreach ($category->subCategories as $subCategory){
                        $subSubCategoryIds = $subCategory->subCategories->pluck('id')->toArray();
                    $categoryIds = array_merge($categoryIds,$subSubCategoryIds);

                    }
                }
                $featuredProducts->whereHas('categories', function ($query) use ($categoryIds) {
                    $query->whereIn('category_id', $categoryIds);
                 });
                }


                // sort
                switch ($row->featured_products_source){

                    case "newest":
                    $featuredProducts->latest();
                    break;

                    case "oldest":
                    $featuredProducts->orderby('created_at','asc');
                    break;

                    case "updated":
                    $featuredProducts->orderbyDesc('updated_at');
                    break;

                    case "sell_count":
                    $featuredProducts->orderBy('sell_count','asc');
                    break;

                    case "popular":
                    $featuredProducts->withCount('comments')->orderBy('comments_count', 'desc');
                    break;
                }
            @endphp
            @foreach($featuredProducts->take($row->featured_products_count)->get() as $product)
                <div class="swiper-slide">
                    @include('products::includes.product_item',$product)
                </div>
            @endforeach
        </div>
        <div class="custom-swiper-button-prev"><i class="icon-arrow-right"></i></div>
        <div class="custom-swiper-button-next"><i class="icon-arrow-left"></i></div>
    </div>

    @if($row->featured_products_btn_link)
        <a href="{{$row->featured_products_btn_link}}"
           class="btn-section-more mobile mt-4"><span>مشاهده همه</span></a>
    @endif
    </div>
</section>
