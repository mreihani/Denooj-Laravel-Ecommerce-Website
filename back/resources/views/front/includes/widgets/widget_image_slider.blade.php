@php $widgetBanners = \Modules\Banners\Entities\Banner::where('location','row_' . $row->id)->get(); @endphp
    <section class="section">
        <div class="{{$row->layout == 'box' ? 'custom-container' : ''}}">

            @if($widgetBanners->count() > 0)
                <!-- slider -->
                <div class="swiper swiper-navigation-hover image-slider-widget">
                    <div class="swiper-wrapper">
                        @foreach($widgetBanners as $widgetBanner)
                            <div class="swiper-slide">
                                <a href="{{$widgetBanner->link}}" class="slide-item">
                                    <img src="{{$widgetBanner->getImage('original')}}" alt="{{$widgetBanner->title}}"
                                         class="rounded">
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="custom-swiper-button-prev"><i class="icon-arrow-right"></i></div>
                    <div class="custom-swiper-button-next"><i class="icon-arrow-left"></i></div>
                </div>
            @else
                <div class="alert alert-info">هیچ بنری برای این جایگاه تعیین نشده است.</div>
            @endif

        </div>

    </section>



