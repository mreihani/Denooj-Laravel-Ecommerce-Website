<section class="section featured-products-bg" style="background: {{$row->featured_products_bg_color}}!important;">
    <div class="custom-container">
        {{-- head --}}
        <div class="section-title mb-4 section-product-head">

            {{-- title --}}
            <div class="d-flex align-items-center">
                <div class="icon" style="background: {{$row->featured_products_title_icon_bg_color}}!important;"><i style="color: {{$row->featured_products_title_icon_color}}!important;" class="{{$row->featured_products_title_icon}}"></i></div>
                <div class="m-0 font-20 fw-800 title ms-2" style="color: {{$row->featured_products_title_color}}!important;">{{$row->featured_products_title}}</div>
            </div>

            {{-- left content --}}
            <div class="d-flex align-items-center ms-auto">
                <div class="d-md-flex align-items-center d-none">
                        <span class="btn-carousel-nav prev" data-swiper-id="featuredProductsSwiper{{$row->id}}" style="background: {{$row->featured_products_arrows_color}};color: {{$row->featured_products_arrows_icon_color}}"><i
                                class="icon-arrow-right"></i></span>
                    <span class="btn-carousel-nav next ms-2" style="background:  {{$row->featured_products_arrows_color}};color: {{$row->featured_products_arrows_icon_color}}" data-swiper-id="featuredProductsSwiper{{$row->id}}"><i
                            class="icon-arrow-left"></i></span>
                </div>
                @if($row->featured_products_btn_link)
                <a href="{{$row->featured_products_btn_link}}" style="color: {{$row->featured_products_btn_color}};border-color: {{$row->featured_products_btn_color}}"
                    onMouseOver="this.style.color='white';this.style.background='{{$row->featured_products_btn_color}}'"
                    onMouseOut="this.style.background='transparent';this.style.color='{{$row->featured_products_btn_color}}'"
                   class="btn-section-more ms-4"><span>مشاهده همه</span></a>
                @endif

            </div>
        </div>

        {{-- carousel --}}
        <div class="swiper featured-products-swiper swiper-equal" id="featuredProductsSwiper{{$row->id}}">
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
        </div>

        @if($row->featured_products_btn_link)
        <a href="{{$row->featured_products_btn_link}}"
           class="btn-section-more mobile mt-4" style="color: {{$row->featured_products_btn_color}};border-color: {{$row->featured_products_btn_color}}"
           onMouseOver="this.style.color='white';this.style.background='{{$row->featured_products_btn_color}}'"
           onMouseOut="this.style.background='transparent';this.style.color='{{$row->featured_products_btn_color}}'"><span>مشاهده همه</span></a>
        @endif
    </div>
</section>




