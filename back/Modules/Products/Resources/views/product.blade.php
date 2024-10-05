@extends('front.layouts.master',['h1Title' => $product->h1_hidden,'navTitle' => $product->nav_title,
'robots' => 'index','singleProduct' => true])
@php $generalSettings = \Modules\Settings\Entities\GeneralSetting::first();@endphp
@section('content')
    <div class="container-fluid page-content mt-4 product-single-container">
        <div class="custom-container">

            {{-- product meta tags --}}
            @if($product->product_type == 'variation')
                <meta name="product_old_price" content="{{$product->getMinPrice()}}">
                <meta name="product_price" content="{{$product->getMaxPrice()}}">
            @else
                @if($product->sale_price)
                    <meta name="product_old_price" content="{{$product->price}}">
                    <meta name="product_price" content="{{$product->sale_price}}">
                @else
                    <meta name="product_old_price" content="{{$product->price}}">
                    <meta name="product_price" content="{{$product->price}}">
                @endif
            @endif
            <meta name="availability" content="{{$product->inStock() ? 'instock' : 'outofstock'}}">
            <meta property="og:image" content="{{$product->getImage()}}">
            <meta property="product_name" content="{{$product->torob_title ?? $product->title}}">

            {{-- breadcrumb --}}
            @include('products::includes.breadcrumb')

            @include('front.alerts')

            {{-- product --}}
            <div class="box">
                <div class="row">
                    {{-- product images --}}
                    <div class="col-lg-5 p-lg-5">
                        @if(!$product->image && !$product->images)
                            <img src="{{$product->getImage()}}" alt="product" class="img-fluid w-100" width="480"
                                 height="480">
                        @else

                        {{-- main gallery swiper --}}
                        <div class="swiper swiper-navigation-hover" id="gallerySwiper">
                                <div class="swiper-wrapper">
                                    @if($product->image)
                                        <div class="swiper-slide">
                                            <a data-fancybox="gallery" href="{{$product->getImage()}}" class="fancybox-item">
                                                <img src="{{$product->getImage()}}" alt="{{$product->title}}" width="480"
                                                     height="480">
                                            </a>
                                        </div>
                                    @endif
                                    @if($product->images != null)
                                        @foreach($product->images as $img)
                                            <div class="swiper-slide">
                                                <a data-fancybox="gallery" href="{{'/storage'.$img['original']}}"
                                                   class="fancybox-item">
                                                    <img src="{{'/storage'.$img['original']}}" alt="{{$product->title}}"
                                                         width="480" height="480">
                                                </a>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            <div class="custom-swiper-button-prev"><i class="icon-arrow-right"></i></div>
                            <div class="custom-swiper-button-next"><i class="icon-arrow-left"></i></div>
                            </div>

                        {{-- thumb gallery swiper --}}
                        <div class="swiper gallery-thumb-list" id="galleryThumbsSwiper">
                            <div class="swiper-wrapper">
                                @if($product->image)
                                    <div class="swiper-slide">
                                        <img src="{{$product->getImage('thumb')}}" alt="{{$product->title}}" data-index="0"
                                             class="gallery-thumb active" width="56" height="56">
                                    </div>
                                @endif
                                @if($product->images != null)
                                    @foreach($product->images as $key => $img)
                                        <div class="swiper-slide">
                                            <img src="{{'/storage'.$img['thumb']}}" alt="{{$product->title}}" width="56"
                                                 height="56"
                                                 data-index="{{$product->image == null ? $key : $key + 1}}"
                                                 class="gallery-thumb {{$product->image == null && $loop->first ? 'active' :''}}">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- details --}}
                    <div class="col-lg-7 pt-4">
                        <div class="product-single-content">
                            <h2 class="font-22 fw-800 font-sm-20 lh-32 lh-sm-28 mb-3">{{$product->title}}</h2>

                            @if($product->title_latin)
                                <div class="product-english-title">
                                    <h2 class="title">{{$product->title_latin}}</h2>
                                </div>
                            @endif

                            <!-- reviews / questions / actions -->
                            <div class="d-flex align-items-lg-center align-items-start flex-column flex-lg-row my-3">

                                <div class="d-flex flex-wrap">
                                    @if($product->display_comments)
                                    <a href="#tabs" class="d-flex text-muted text-decoration-none font-13"><i
                                            class="icon-star color-gold me-1"></i><b
                                            class="me-1 text-dark">{{$product->getAverageRating()}}</b> از <span
                                            class="mx-1">{{$product->comments->where('status','published')->count()}}</span>رأی</a>
                                    @endif

                                    @if($product->faq != null && count($product->faq) > 0)
                                        <a href="#faqSection"
                                           class="inline-list-item text-decoration-none color-link font-13">سوالات
                                            متداول</a>
                                    @endif
                                        @if($product->display_questions)
                                    <a href="#tabs"
                                       class="inline-list-item text-decoration-none color-link font-13"><span
                                            class="me-1">{{$product->questions()->count()}}</span> پرسش و پاسخ</a>
                                            @endif
                                </div>

                                <div class="d-flex mt-3 mt-lg-0 ms-lg-auto">
                                    {{-- compare --}}
                                    {{--                                    <span class="btn btn-sm btn-light" data-bs-toggle="tooltip" data-bs-placement="top" title="مقایسه"><i class="icon-sidebar font-20"></i></span>--}}

                                    {{-- favorite --}}
                                    <a class="btn rounded btn-light ms-2" @auth data-id="{{$product->id}}"
                                       onclick="bookmark(this)" href="javascript:" @else href="{{route('signin')}}"
                                       @endauth
                                       data-bs-toggle="tooltip" data-bs-placement="top" title="افزودن به علاقه مندی ها">
                                        @if($product->liked())
                                            <i class="icon-heart text-danger font-20"></i>
                                        @else
                                            <i class="icon-heart font-20"></i>
                                        @endif
                                    </a>

                                    {{-- share --}}
                                    <span class="btn rounded btn-light ms-2"
                                          data-bs-toggle="modal" data-bs-target="#shareProductModal"><i
                                            class="icon-share-2 font-20"></i></span>
                                </div>
                            </div>

                            <!-- short description -->
                            @if($product->short_description)
                                <div class="product-short-description mb-3">
                                    {!! $product->short_description !!}
                                </div>
                            @endif

                            <!-- SKU -->
                            @if($product->sku)
                                <div class="d-inline-block px-3 border rounded-2 p-2 mb-3">
                                    <i class="icon-info"></i>
                                    <span class="ms-1">{{'کد محصول: ' . $product->sku}}</span>
                                </div>
                            @endif

                            <!-- shipping time -->
                            @if($product->shipping_time)
                                <div class="d-inline-block px-3 border rounded-2 p-2 mb-3">
                                    <i class="icon-box"></i>
                                    <span class="ms-1">{{'زمان ارسال: '. $product->shipping_time}}</span>
                                </div>
                            @endif

                            <!-- attributes -->
                            @if($product->attributes != null && count($product->attributes) > 0)
                                <div class="mt-2">
                                    <ul class="attributes-list">
                                        @foreach($product->attributes as $attr)
                                            <li>
                                                <span
                                                    class="d-inline-block fw-bold font-14">{{$attr['label'] .':'}}</span>
                                                <span class="fw-normal font-14 ms-1">{{$attr['value']}}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @if(count($product->attributes) > 3)
                                        <span class="see-more-attr"><i
                                                class="icon-plus"></i><span>مشاهده بیشتر</span></span>
                                    @endif
                                </div>
                            @endif

                            <!-- mobile fixed section -->
                            <div class="floated-mobile mt-4">
                                <!-- price -->
                                <div class="d-flex align-items-center fw-800">
                                    @if($product->inStock())
                                        <span class="me-2 font-18">قیمت:</span>
                                        {!! $product->getPriceHtml('single-product-price') !!}
                                    @else
                                        <div class="alert alert-danger fw-normal">
                                            <b class="d-block mb-3">این محصول موجود نیست!</b>
                                            <span>درصورت تمایل برای اطلاع از زمان موجودی میتوانید با مدیر سایت تماس بگیرید.</span>
                                        </div>
                                    @endif
                                </div>
                                <!-- add to cart -->
                                @if($product->cart_button_link)
                                    <a href="{{$product->cart_button_link}}"
                                       class="btn btn-success btn-lg px-lg-5 mt-4">
                                        <span class="font-20 font-sm-16">{{$product->cart_button_text ?? 'افزودن به سبد'}}</span>
                                        <i class="icon-arrow-left ms-2"></i>
                                    </a>
                                @else
                                    @if($product->inStock())
                                        <div class="mt-lg-5 mt-2 variations-fields">
                                            <input type="hidden" value="{{$product->getInventoryType()}}"
                                                   id="inventoryType" data-product-id="{{$product->id}}">

                                            @if($product->product_type == 'variation')
                                                @switch($product->getInventoryType())
                                                    @case('color')
                                                        <div class="form-group tablet-scrollable align-items-center">
                                                            <span class="font-weight-bold font-14 me-2 flex-shrink-0">انتخاب رنگ:</span>
                                                            @foreach($product->getInventoryColors() as $colorId)
                                                                @php $color = \Modules\Products\Entities\ProductColor::find($colorId); @endphp
                                                                @php $inventory = \Modules\Products\Entities\ProductInventory::where('product_id',$product->id)->where('color_id',$colorId)->first(); @endphp
                                                                <div
                                                                    class="check-container {{$inventory->getStockQuantity() < 1 ? 'disabled':''}}">
                                                                    <input id="color_{{$color->id}}" name="color_id"
                                                                           type="radio"
                                                                           value="{{$color->id}}" {{$inventory->getStockQuantity() < 1 ? 'disabled':''}} {{count($product->getInventoryColors()) == 1 ? 'checked':''}}>
                                                                    <label for="color_{{$color->id}}">{{$color->label}}</label>
                                                                    <div class="check-color"
                                                                         style="background-color: {{$color->hex_code}}"></div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @break

                                                    @case('size')
                                                        <div
                                                            class="form-group d-flex align-items-center flex-wrap tablet-scrollable">
                                                            <span class="font-weight-bold font-14 me-2 flex-shrink-0">انتخاب سایز:</span>
                                                            @foreach($product->getInventorySizes() as $sizeId)
                                                                @php $size = \Modules\Products\Entities\ProductSize::find($sizeId); @endphp
                                                                @php $inventory = \Modules\Products\Entities\ProductInventory::where('product_id',$product->id)->where('size_id',$sizeId)->first(); @endphp
                                                                <div
                                                                    class="check-container size {{$inventory->getStockQuantity() < 1 ? 'disabled':''}}">
                                                                    <input id="size_{{$size->id}}" name="size_id" type="radio"
                                                                           value="{{$size->id}}" {{$inventory->getStockQuantity() < 1 ? 'disabled':''}} {{count($product->getInventorySizes()) == 1 ? 'checked':''}}>
                                                                    <label for="size_{{$size->id}}">{{$size->label}}</label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        @break

                                                    @case('color_size')
                                                        <div
                                                            class="form-group mb-lg-3 mb-1 tablet-scrollable align-items-center">
                                                            <span class="font-weight-bold font-14 me-2 flex-shrink-0">انتخاب رنگ:</span>
                                                            @foreach($product->getInventoryColors() as $colorId)
                                                                @php $color = \Modules\Products\Entities\ProductColor::find($colorId); @endphp
                                                                @php $inventory = \Modules\Products\Entities\ProductInventory::where('product_id',$product->id)->where('color_id',$colorId)->first(); @endphp
                                                                <div class="check-container">
                                                                    <input id="color_{{$color->id}}" name="color_id"
                                                                           type="radio"
                                                                           value="{{$color->id}}" {{count($product->getInventoryColors()) == 1 ? 'checked':''}}>
                                                                    <label for="color_{{$color->id}}">{{$color->label}}</label>
                                                                    <div class="check-color"
                                                                         style="background-color: {{$color->hex_code}}"></div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div
                                                            class="form-group d-flex align-items-center flex-wrap tablet-scrollable">
                                                            <span class="font-weight-bold font-14 me-2 flex-shrink-0">انتخاب سایز:</span>
                                                            @foreach($product->getInventorySizes() as $sizeId)
                                                                @php $size = \Modules\Products\Entities\ProductSize::find($sizeId); @endphp
                                                                @php $inventory = \Modules\Products\Entities\ProductInventory::where('product_id',$product->id)->where('size_id',$sizeId)->first(); @endphp
                                                                <div class="check-container size">
                                                                    <input id="size_{{$size->id}}" name="size_id" type="radio"
                                                                           value="{{$size->id}}" {{count($product->getInventorySizes()) == 1 ? 'checked':''}}>
                                                                    <label for="size_{{$size->id}}">{{$size->label}}</label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        @break
                                                @endswitch
                                            @endif

                                            @if($product->product_type == 'variation')
                                            <div class="variation-price-container mt-3 product-price-container {{count($product->getInventorySizes()) == 1 && count($product->getInventoryColors()) == 1 ? 'need-onload' : ''}}"></div>
                                            @endif

                                            @include('products::includes.product_price_section',['product' => $product])

                                        </div>
                                    @endif
                                @endif
                            </div>

                            {{-- tags --}}
                            <!-- @if(count($product->tags) > 0)
                                <div class="mt-4 d-flex align-items-center">
                                    <span class="me-2">کلمات کلیدی: </span>
                                    <div>
                                        @foreach($product->tags as $tag)
                                            <a href="{{route('tag.show',$tag->slug)}}"
                                               class="tag-item">{{$tag->name}}</a>
                                            @if(!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif -->

                        </div>
                    </div>
                </div>
            </div>

            {{-- tabs --}}
            @include('products::includes.tabs')

            {{-- faq --}}
            @if($product->faq != null && count($product->faq) > 0)
                <div class="box mt-4" id="faqSection">
                    <span class="font-20 fw-bold d-block mb-4">سوالات متداول</span>
                    <div class="accordion" id="accordionFaq">
                        @foreach($product->faq  as $key => $faqItem)
                            <div class="accordion-item">
                                <h4 class="accordion-header m-0" id="heading-{{$key}}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
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
                </div>
            @endif

            {{-- Similar Products --}}
            @if($similarProducts->count() > 0)
                <div class="section mt-5">
                    <div class="section-title mb-4">
                        <h4 class="m-0 font-20 fw-800">محصولات مشابه</h4>
                    </div>

                    {{-- swiper --}}
                    <div class="swiper similar-products-swiper swiper-equal">
                        <div class="swiper-wrapper">
                            @foreach($similarProducts as $similarProduct)
                                <div class="swiper-slide">
                                    @include('products::includes.product_item',['product' => $similarProduct])
                                </div>
                            @endforeach
                        </div>
                        <div class="custom-swiper-button-prev"><i class="icon-arrow-right"></i></div>
                        <div class="custom-swiper-button-next"><i class="icon-arrow-left"></i></div>
                    </div>
                </div>
            @endif
        </div>

        @include('front.includes.call_buttons')
    </div>

    @include('products::includes.modal_share_product')
    @include('products::includes.modal_submit_question')

    @if(\Nwidart\Modules\Facades\Module::has('Comments') && \Nwidart\Modules\Facades\Module::isEnabled('Comments') && $product->display_comments)
        @include('comments::includes.modal_add_comment',['product' => $product,'generalSettings' => $generalSettings])
    @endif
@endsection
@section('scripts')
    <script src="{{asset('assets/js/product.js')}}"></script>
@endsection
