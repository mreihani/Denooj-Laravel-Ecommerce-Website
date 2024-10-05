@extends('front.layouts.master',
['h1Title' => isset($category) ? $category->h1_hidden : (isset($tag) ? $tag->name : 'محصولات'),
'navTitle' => isset($category) ? $category->nav_title : (isset($tag) ? $tag->nav_title : 'محصولات'),
'robots' => 'index'])
@auth
<?php $cart = \Cart::session(auth()->id());?>
@endauth
@section('content')

    <input type="hidden" id="maxPriceRange" value="{{$maxPriceRange}}">

    <div class="container-fluid page-content mt-4" >
        <div class="custom-container">
            <div class="row">
                <div class="col-xl-3">
                    @include('products::includes.products_sidebar')
                </div>
                <div class="col-xl-9" id="pjax-container">

                    {{-- breadcrumb --}}
                    <nav aria-label="breadcrumb" class="breadcrumb-container">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">{{config('app.app_name_fa')}}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('products')}}">محصولات</a></li>
                            @if($searchQ)
                                <li class="breadcrumb-item" aria-current="page">{{'جستجو برای ' . $searchQ}}</li>
                            @elseif(isset($tag))
                                <li class="breadcrumb-item" aria-current="page">{{$tag->name}}</li>
                            @else
                            @if(isset($category))
                                @if($category->parent)
                                    @if($category->parent->parent)
                                        <li class="breadcrumb-item"><a href="{{route('category.show',$category->parent->parent)}}">{{$category->parent->parent->title}}</a></li>
                                    @endif
                                    <li class="breadcrumb-item"><a href="{{route('category.show',$category->parent)}}">{{$category->parent->title}}</a></li>
                                @endif
                                <li class="breadcrumb-item"><a href="{{route('category.show',$category)}}">{{$category->title}}</a></li>
                            @endif
                            @endif
                        </ol>
                    </nav>

                    {{-- products --}}
                    <div class="box box-sm-transparent">
                        @include('products::includes.sorts',['count' => $count])

                     @if($products->count() > 0)
                        <div class="row">
                            @foreach($products as $product)
                                <div class="col-lg-4 col-md-6 mb-md-4 mb-2 mb-md-0">
                                    @include('products::includes.product_item',['product' => $product,'class' => 'mobile-horizontal'])
                                </div>
                            @endforeach
                        </div>
                        @else
                            @include('products::includes.no_results')
                        @endif

                        {{$products->links('front.vendor.pagination.bootstrap-4')}}

                    </div>

                    {{-- seo description --}}
                    @if((isset($category) && $category->seo_description != null) || (isset($tag) && $tag->seo_description != null))
                        <div class="box content-area shadow-none content-dropdown mt-5">
                            @if(isset($category))
                            {!! $category->seo_description !!}

                            @if($category->faq != null && count($category->faq) > 0)
                                <span class="d-block mt-5 mb-3 fw-800 font-22">سوالات متداول</span>
                                <div class="accordion" id="accordionFaq">
                                    @foreach($category->faq  as $key => $faqItem)
                                        <div class="accordion-item">
                                            <h4 class="accordion-header m-0" id="heading-{{$key}}">
                                                <button class="accordion-button {{$loop->first ? '' : 'collapsed'}}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{$key}}" aria-expanded="{{$loop->first ? 'true' : 'false'}}" aria-controls="collapse-{{$key}}">
                                                    {{$faqItem[0]}}
                                                </button>
                                            </h4>
                                            <div id="collapse-{{$key}}" class="accordion-collapse collapse {{$loop->first ? 'show' : 'false'}}" aria-labelledby="collapse-{{$key}}" data-bs-parent="#accordionFaq">
                                                <p class="accordion-body m-0">{{$faqItem[1]}}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @elseif(isset($tag))
                            {!! $tag->seo_description !!}
                            @endif

                                <button type="button" class="content-dropdown-toggle"><span>مشاهده بیشتر</span><i
                                        class="icon-chevron-down ms-2"></i></button>
                        </div>
                    @endif
                </div>
            </div>

            {{-- mobile screen buttons --}}
            <div class="archive-buttons">
                <span id="filtersOpen"><i class="icon-filter"></i> فیلتر کنید</span>
                <span id="ordersOpen"><i class="icon-align-center"></i> ترتیب نمایش</span>
            </div>
        </div>
    </div>
@endsection
@section('styles')
@endsection
@section('scripts')
    <script src="{{asset('assets/js/jquery.range.js')}}"></script>
    <script src="{{asset('assets/js/products_archive.js')}}"></script>
@endsection
