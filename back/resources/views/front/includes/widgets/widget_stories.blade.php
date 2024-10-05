@php $stories = \Modules\Story\Entities\Story::where('status','published')->orderByDesc('updated_at')->limit(50)->get(); @endphp
    <section class="section">
        <div class="{{$row->layout == 'box' ? 'custom-container' : ''}}">

            <div class="swiper small-stories-swiper" id="storiesSwiperSm">
                <div class="swiper-wrapper">
                    @php $storyIndex = 0;@endphp
                    @foreach($stories as $story)
                        <div class="swiper-slide">
                            @include('story::includes.story_thumbnail_item',['story' => $story,'index' => $storyIndex,'showTitle' => $row->stories_show_title,'strokeColor' => $row->stories_stroke_color,'shape' => $row->stories_shape])
                        </div>
                        @php $storyIndex++;@endphp
                    @endforeach
                </div>
                <div class="custom-swiper-button-prev"><i class="icon-arrow-right"></i></div>
                <div class="custom-swiper-button-next"><i class="icon-arrow-left"></i></div>
            </div>

        </div>
    </section>


@include('story::includes.story_wrapper',['stories' => $stories])


