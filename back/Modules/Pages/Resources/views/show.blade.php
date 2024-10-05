@extends('front.layouts.master',['h1Title' => $page->h1_hidden,'navTitle' => $page->nav_title,'robots' => 'index'])
@section('content')
    <div class="container-fluid page-content mt-4">
        <div class="custom-container">

            {{-- breadcrumb --}}
            <nav aria-label="breadcrumb" class="breadcrumb-container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">{{config('app.app_name_fa')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$page->title}}</li>
                </ol>
            </nav>

            <div class="row">

                {{-- content --}}
                <div class="{{$page->sidebar ? 'col-xl-9 col-lg-8' : 'col-12'}} mb-4">
                    <div class="box post-page">
                        <h2 class="post-title mt-2 mb-2">{{$page->title}}</h2>
                        <div class="post-details mb-3">
                            <div class="text-with-icon me-3"><i class="icon-calendar me-1"></i><span>{{verta($page->created_at)->format('%d %B، %Y')}}</span></div>
                            {{-- share --}}
                            <span class="btn rounded btn-light ms-auto"
                                  data-bs-toggle="modal" data-bs-target="#sharePageModal"><i class="icon-share-2 font-20"></i></span>
                        </div>
                        @if($page->image)
                        <img src="{{$page->getImage('original')}}" alt="{{$page->image_alt}}" class="img-fluid mb-3">
                        @endif

                        <div class="content-area">
                            {!! $page->body !!}
                        </div>
                    </div>
                </div>

                {{-- sidebar --}}
                @if($page->sidebar)
                <div class="col-xl-3 col-lg-4">

                    {{-- similar pages --}}
                    @if($similarPages->count() > 0)
                    <div class="box mb-4">
                        <div class="section-title mb-4 section-product-head">
                            <div class="m-0 font-17 fw-800 title">مطالب مشابه</div>
                        </div>
                        @foreach($similarPages as $p)
                            @include('pages::includes.page_item_h',['page' => $p])
                        @endforeach
                    </div>
                    @endif

                    {{-- recommended products --}}
                    @if($products->count() > 0)
                    <div class="box mb-4 product-list">
                        <div class="section-title mb-4 section-product-head">
                            <div class="m-0 font-17 fw-800 title">محصولات پیشنهادی</div>
                        </div>
                        <div class="products-carousel owl-carousel">
                            @foreach($products as $product)
                                @include('products::includes.product_item',$product)
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- banners --}}
                    @if(\Nwidart\Modules\Facades\Module::has('Banners') && \Nwidart\Modules\Facades\Module::isEnabled('Banners'))
                    @php $banners = \Modules\Banners\Entities\Banner::where('location','pages_sidebar')->get();@endphp
                    @if($banners->count() > 0)
                        <div class="box mb-4">
                            @foreach($banners as $banner)
                                @php $class = '' ; if(!$loop->last && $banners->count() > 1) $class ='mb-3';@endphp
                                @include('banners::includes.banner_item',['banner' => $banner,'class' => $class])
                            @endforeach
                        </div>
                        @endif
                    @endif

                </div>
                @endif
            </div>
        </div>
    </div>

    @include('front.includes.modal_share_page',$page)

@endsection
@section('scripts')
    <script>
        let owlOptions = {
            items: 1,
            rtl: true,
            margin:0,
            loop:true,
            centerMode:true,
            autoplay: true,
            dots:false,
            nav: true,
            navText: ["<i class='icon-arrow-right owl-chevron left'>", "<i class='icon-arrow-left owl-chevron right'>"],
        };
        $(".products-carousel").owlCarousel(owlOptions);
    </script>
@endsection
