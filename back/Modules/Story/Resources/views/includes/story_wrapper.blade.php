@if($stories->count() > 0)
<div class="stories-wrapper">
    <!-- Slider main container -->
    <div class="swiper large-stories-swiper" id="storiesSwiperLg">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">

            @foreach($stories as $story)
                <div class="swiper-slide">
                    @include('story::includes.story_item',['story' => $story])
                </div>
            @endforeach

        </div>

        <!-- stories pagination -->
        <div class="swiper-pagination"></div>

        <!-- If we need navigation buttons -->
        <div class="custom-swiper-button-prev"><i class="icon-arrow-right"></i></div>
        <div class="custom-swiper-button-next"><i class="icon-arrow-left"></i></div>
    </div>
</div>
@endif
