@php
    $sectionPosts = \Modules\Blog\Entities\Post::query()->published();

     if ($row->featured_products_recommended){
        $sectionPosts->featured();
    }

    // categories filter
    if ($row->featured_products_categories_source){
        $categoryIds = $row->featured_products_categories_source;
    foreach ($categoryIds as $categoryId) {
        $category = \Modules\Blog\Entities\PostCategory::find($categoryId);
        $subCategoryIds = $category->subCategories->pluck('id')->toArray();
        $categoryIds = array_merge($categoryIds,$subCategoryIds);
        foreach ($category->subCategories as $subCategory){
            $subSubCategoryIds = $subCategory->subCategories->pluck('id')->toArray();
            $categoryIds = array_merge($categoryIds,$subSubCategoryIds);
        }
    }
    $sectionPosts->whereHas('categories', function ($query) use ($categoryIds) {
        $query->whereIn('category_id', $categoryIds);
     });
    }


    // sort
    switch ($row->featured_products_source){

        case "newest":
        $sectionPosts->latest();
        break;

        case "oldest":
        $sectionPosts->orderby('created_at','asc');
        break;

        case "updated":
        $sectionPosts->orderbyDesc('updated_at');
        break;

        case "popular":
        $sectionPosts->withCount('comments')->orderBy('comments_count', 'desc');
        break;
    }
@endphp

<section class="section posts-container" style="background: {{$row->featured_products_bg_color}}!important;">
    <div class="custom-container">

        <div class="section-blog-head mb-4 mb-lg-5">
            <div class="d-flex align-items-center">
                <div class="section-title-mark d-none d-sm-flex">
                    <span style="background: {{$row->featured_products_title_icon_color}}"></span>
                    <span style="background: {{$row->featured_products_title_icon_color}}"></span>
                    <span style="background: {{$row->featured_products_title_icon_color}}"></span>
                </div>
                <div class="m-0 ms-sm-2 mt-2 font-22 fw-800 title" style="color: {{$row->featured_products_title_color}}">{{$row->featured_products_title}}</div>
            </div>

            {{-- left content --}}
            @if($row->featured_products_btn_link)
                <a href="{{$row->featured_products_btn_link}}" style="color: {{$row->featured_products_btn_color}};border-color: {{$row->featured_products_btn_color}}"
                   onMouseOver="this.style.color='{{$row->featured_products_btn_color_hover}}'; this.style.background='{{$row->featured_products_btn_color}}'"
                   onMouseOut="this.style.background='transparent';this.style.color='{{$row->featured_products_btn_color}}'"
                   class="btn-section-more ms-4"><span>مشاهده همه</span></a>
            @endif
        </div>

        {{-- carousel --}}
        <div class="posts-swiper-container">
            <div class="swiper posts-swiper swiper-equal swiper-navigation-hover swiper-navigation-accent">
                <div class="swiper-wrapper">
                    @foreach($sectionPosts->take($row->featured_products_count)->get() as $post)
                        <div class="swiper-slide">
                            @include('blog::includes.post_item',$post)
                        </div>
                    @endforeach
                </div>
                <div class="custom-swiper-button-prev" style="background: {{$row->featured_products_arrows_color}}!important;color: {{$row->featured_products_arrows_icon_color}}!important;"><i class="icon-arrow-right"></i></div>
                <div class="custom-swiper-button-next" style="background: {{$row->featured_products_arrows_color}}!important;color: {{$row->featured_products_arrows_icon_color}}!important;"><i class="icon-arrow-left"></i></div>
            </div>
        </div>


        @if($row->featured_products_btn_link)
            <a href="{{$row->featured_products_btn_link}}"
               class="btn-section-more mobile mt-4" style="color: {{$row->featured_products_btn_color}};border-color: {{$row->featured_products_btn_color}}"
               onMouseOver="this.style.color='{{$row->featured_products_btn_color_hover}}'; this.style.background='{{$row->featured_products_btn_color}}'"
               onMouseOut="this.style.background='transparent';this.style.color='{{$row->featured_products_btn_color}}'"><span>مشاهده همه</span></a>
        @endif

    </div>
</section>
