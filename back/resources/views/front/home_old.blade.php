@extends('front.layouts.master')
@php $appearanceSettings = \Modules\Settings\Entities\AppearanceSetting::first(); @endphp
@section('content')

    {{-- slider | banners | categories --}}
    <div class="container-fluid page-content mt-4">
        <div class="custom-container">

            {{-- stories --}}
            @if(\Nwidart\Modules\Facades\Module::has('Story') && \Nwidart\Modules\Facades\Module::isEnabled('Story'))
                @if($stories->count() > 0)
                <section class="section mb-4 mb-lg-5 mb-4 mb-lg-5">
                <div class="swiper small-stories-swiper" id="storiesSwiperSm">
                    <div class="swiper-wrapper">
                        @php $storyIndex = 0;@endphp
                        @foreach($stories as $story)
                            <div class="swiper-slide">
                                @include('story::includes.story_thumbnail_item',['story' => $story,'index' => $storyIndex])
                            </div>
                            @php $storyIndex++;@endphp
                        @endforeach
                    </div>
                    <div class="custom-swiper-button-prev"><i class="icon-arrow-right"></i></div>
                    <div class="custom-swiper-button-next"><i class="icon-arrow-left"></i></div>
                </div>
                </section>
                @endif
            @endif

            {{-- image slider and banners --}}
            @if(\Nwidart\Modules\Facades\Module::has('Banners') && \Nwidart\Modules\Facades\Module::isEnabled('Banners'))
                @php $sliderBanners = $banners->where('location','main_slider'); @endphp
                @php $sliderSideBanners = $banners->where('location','main_slider_side'); @endphp
                <section class="section mb-4 mb-lg-5">
                    <div class="row">
                        <div class="{{$sliderSideBanners->count() > 0 ? 'col-lg-8' : 'col-12'}}">
                            <!-- slider -->
                            <div class="swiper swiper-navigation-hover" id="mainSwiper">
                                <div class="swiper-wrapper">
                                    @foreach($sliderBanners as $banner)
                                        <div class="swiper-slide">
                                            <a href="{{$banner->link}}" class="slide-item">
                                                <img src="{{$banner->getImage('original')}}" alt="{{$banner->title}}"
                                                     class="rounded">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-pagination"></div>
                                <div class="custom-swiper-button-prev"><i class="icon-arrow-right"></i></div>
                                <div class="custom-swiper-button-next"><i class="icon-arrow-left"></i></div>
                            </div>
                        </div>
                        @if($sliderSideBanners->count() > 0)
                            <div class="col-lg-4 mt-4 mt-lg-0">
                                @foreach($sliderSideBanners as $banner)
                                    @include('banners::includes.banner_item',['banner' => $banner,'class' => $loop->first ? 'mb-20px' : ''])
                                @endforeach
                            </div>
                        @endif
                    </div>
                </section>
            @endif

            {{-- featured categories --}}
            <div class="mb-4 mb-lg-5">
                <div class="swiper categories-swiper swiper-buttons-zero">
                    <div class="swiper-wrapper">
                        @foreach($featuredCategories as $category)
                            <div class="swiper-slide">
                                <a href="{{route('category.show',$category)}}" class="category-item">
                                    <div class="category-item-overly">
                                        <span class="count">{{$category->getAllPublishedProducts()->count() . ' محصول'}}</span>
                                        <span class="title">{{$category->title}}</span>
                                    </div>
                                    <img src="{{$category->getImage()}}" alt="img">
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="custom-swiper-button-prev opacity-100"><i class="icon-arrow-right"></i></div>
                    <div class="custom-swiper-button-next opacity-100"><i class="icon-arrow-left"></i></div>
                </div>

            </div>
        </div>
    </div>

    {{-- featured products --}}
    <section class="container-fluid featured-products-bg mb-4 mb-lg-5">
        <div class="custom-container">
            <section class="section">
                {{-- head --}}
                <div class="section-title mb-4 section-product-head">

                    {{-- title --}}
                    <div class="d-flex align-items-center">
                        <div class="icon"><i class="{{$appearanceSettings->featured_products_title_icon}}"></i></div>
                        <div
                            class="m-0 font-20 fw-800 title ms-2">{{$appearanceSettings->featured_products_title}}</div>
                    </div>

                    {{-- left content --}}
                    <div class="d-flex align-items-center ms-auto">
                        <div class="d-md-flex align-items-center d-none">
                            <span class="btn-carousel-nav prev" data-swiper-id="featuredProductsSwiper"><i
                                    class="icon-arrow-right"></i></span>
                            <span class="btn-carousel-nav next ms-2" data-swiper-id="featuredProductsSwiper"><i
                                    class="icon-arrow-left"></i></span>
                        </div>
                        <a href="{{$appearanceSettings->featured_products_btn_link}}"
                           class="btn-section-more ms-4"><span>مشاهده همه</span></a>
                    </div>
                </div>

                {{-- carousel --}}
                <div class="swiper featured-products-swiper swiper-equal">
                    <div class="swiper-wrapper">
                        @php
                            $featuredProducts = \Modules\Products\Entities\Product::published()->where('recommended',true)->latest()->take($appearanceSettings->featured_products_count)->get();
                            switch ($appearanceSettings->featured_products_source){

                                case "new":
                                $featuredProducts = \Modules\Products\Entities\Product::published()->Available()->latest()->take($appearanceSettings->featured_products_count)->get();
                                break;

                                case "sell_count":
                                $featuredProducts = \Modules\Products\Entities\Product::published()->Available()->orderBy('sell_count','asc')->take($appearanceSettings->featured_products_count)->get();
                                break;

                                case "discounted":
                                $featuredProducts = \Modules\Products\Entities\Product::published()->hasDiscount()->Available()->orderBy('discount_percent','asc')->take($appearanceSettings->featured_products_count)->get();
                                break;

                                case "popular":
                                $featuredProducts = \Modules\Products\Entities\Product::published()->Available()->withCount('comments')->orderBy('comments_count', 'desc')->take($appearanceSettings->featured_products_count)->get();
                                break;
                            }
                        @endphp
                        @foreach($featuredProducts as $product)
                            <div class="swiper-slide">
                                @include('products::includes.product_item',$product)
                            </div>
                        @endforeach
                    </div>
                </div>

                <a href="{{$appearanceSettings->featured_products_btn_link}}"
                   class="btn-section-more mobile mt-4"><span>مشاهده همه</span></a>
            </section>
        </div>
    </section>

    {{-- banners | category products --}}
    <div class="container-fluid mb-4 mb-lg-5">
        <div class="custom-container">
            {{-- banners --}}
            @if(\Nwidart\Modules\Facades\Module::has('Banners') && \Nwidart\Modules\Facades\Module::isEnabled('Banners'))
                @php $belowFeaturedProductsBanners = $banners->where('location','below_new_products');@endphp
                @if($belowFeaturedProductsBanners->count() > 0)
                    <section class="section mb-4">
                        <div class="row">
                            @foreach($belowFeaturedProductsBanners as $banner)
                                <div
                                    class="col-lg-{{$banner->lg_col}} col-sm-{{$banner->sm_col}} col-{{$banner->col}} mb-4">
                                    @include('banners::includes.banner_item',$banner)
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            @endif

            {{-- display in home categories --}}
            @foreach($homeCategories as $homeCategory)
                <section class="section mb-4 mb-lg-5">
                    {{-- head --}}
                    <div class="section-title mb-4 section-product-head">

                        {{-- title --}}
                        <div class="d-flex flex-column justify-content-start">
                            <div class="d-flex align-items-center {{$homeCategory->section_subtitle ? 'mb-2' : ''}}">
                                <div class="section-title-mark">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <div class="mb-0 ms-2 font-20 fw-800 title">{{$homeCategory->home_section_title}}</div>
                            </div>
                            @if($homeCategory->section_subtitle)
                                <p class="m-0 font-14 fw-normal text-muted me-3">{{$homeCategory->section_subtitle}}</p>
                            @endif
                        </div>

                        {{-- left content --}}
                        <div class="d-flex align-items-center ms-auto">
                            <a href="{{route('category.show',$homeCategory)}}" class="btn-section-more ms-4"><span>مشاهده همه</span></a>
                        </div>
                    </div>

                    {{-- carousel --}}
                    <div class="swiper products-swiper-categories swiper-equal">
                        <div class="swiper-wrapper">
                            @php $categoryProducts = $homeCategory->getAllPublishedProducts()->latest()->limit(10)->get();@endphp
                            @foreach($categoryProducts as $categoryProduct)
                                <div class="swiper-slide">
                                    @include('products::includes.product_item',['product' => $categoryProduct])
                                </div>
                            @endforeach
                        </div>
                        <div class="custom-swiper-button-prev"><i class="icon-arrow-right"></i></div>
                        <div class="custom-swiper-button-next"><i class="icon-arrow-left"></i></div>
                    </div>

                    <a href="{{route('category.show',$homeCategory)}}" class="btn-section-more mobile mt-4"><span>مشاهده همه محصولات</span><i
                            class="icon-arrow-left ms-3"></i></a>
                </section>
            @endforeach
        </div>
    </div>

    {{-- posts --}}
    @if(\Nwidart\Modules\Facades\Module::has('Blog') && \Nwidart\Modules\Facades\Module::isEnabled('Blog'))
        @include('blog::includes.posts_section')
    @endif

    {{-- banners --}}
    @if(\Nwidart\Modules\Facades\Module::has('Banners') && \Nwidart\Modules\Facades\Module::isEnabled('Banners'))
        <div class="container-fluid mb-4 mb-lg-5">
            <div class="custom-container">
                @php $beforeBlogBanners = $banners->where('location','before_footer');@endphp
                @if($beforeBlogBanners->count() > 0)
                    <section class="section mb-5">
                        <div class="row">
                            @foreach($beforeBlogBanners as $banner)
                                <div
                                    class="col-lg-{{$banner->lg_col}} col-sm-{{$banner->sm_col}} col-{{$banner->col}} {{$loop->last ? '':'mb-4'}}">
                                    @include('banners::includes.banner_item',$banner)
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>
        </div>
    @endif

    {{-- seo description --}}
    @if($generalSettings->home_seo_description)
        <div class="container-fluid mb-4">
            <div class="custom-container">
                <section class="section">
                    <div class="row">
                        <div class="col-12">
                            <div class="box content-area shadow-none content-dropdown">
                                {!! $generalSettings->home_seo_description !!}

                                @if($generalSettings->home_faq != null && count($generalSettings->home_faq) > 0)
                                    <span class="d-block mt-5 mb-3 fw-800 font-22">سوالات متداول</span>
                                    <div class="accordion" id="accordionFaq">
                                        @foreach($generalSettings->home_faq  as $key => $faqItem)
                                            <div class="accordion-item">
                                                <h4 class="accordion-header m-0" id="heading-{{$key}}">
                                                    <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapse-{{$key}}" aria-expanded="false"
                                                            aria-controls="collapse-{{$key}}">
                                                        {{$faqItem[0]}}
                                                    </button>
                                                </h4>
                                                <div id="collapse-{{$key}}" class="accordion-collapse collapse"
                                                     aria-labelledby="collapse-{{$key}}" data-bs-parent="#accordionFaq">
                                                    <p class="accordion-body m-0">{{$faqItem[1]}}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <button type="button" class="content-dropdown-toggle"><span>مشاهده بیشتر</span><i
                                        class="icon-chevron-down ms-2"></i></button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    @endif

    @include('front.includes.call_buttons',['generalSettings' => $generalSettings])

    {{-- story wrapper --}}
    @if(\Nwidart\Modules\Facades\Module::has('Story') && \Nwidart\Modules\Facades\Module::isEnabled('Story'))
        @include('story::includes.story_wrapper',['stories' => $stories])
    @endif


@endsection
@section('scripts')
    <script src="{{asset('assets/js/home.js')}}"></script>
@endsection
