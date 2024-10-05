<div class="story-item-lg {{$story->type}}">
    {{-- story content --}}
    @if($story->type == 'image')
        <img src="{{$story->getImage()}}" alt="{{$story->title}}">
    @elseif($story->type == 'video')
        <video class="story-video-tag" preload="none">
            <source src="{{$story->video_url}}" type="video/mp4">
        </video>
    @endif
    <div class="story-item-lg-content">
        {{-- top section overly --}}
        <div class="story-item-lg-overly">
            <span class="story-item-lg-back"><i class="icon-x"></i></span>
            <div class="story-item-lg-title">
                <div class="avatar">
                    <img src="{{$story->getThumbnail()}}" alt="{{$story->title}}">
                </div>
                <div class="ms-2 title">{{$story->title}}</div>
            </div>

            @if($story->type == 'video')
                <div class="story-video-controls">
                                    <span class="story-video-controls-btn story-play-pause-btn playing">
                                        <i class="icon-play is-playing-icon"></i>
                                        <i class="icon-pause not-playing-icon"></i>
                                    </span>
                    <span class="story-video-controls-btn story-volume-btn">
                                        <i class="icon-volume-2 not-muted-icon"></i>
                                        <i class="icon-volume-x is-muted-icon"></i>
                                    </span>
                </div>
            @endif
        </div>


        {{-- bottom section overly --}}
        <div class="story-item-lg-overly story-item-lg-overly-bottom">
            @if($story->description)
                <div class="story-item-lg-description">{{$story->description}}</div>
            @endif

            @if($story->show_button)
                <a href="{{$story->button_link}}" class="story-item-lg-btn">
                    <i class="icon-link"></i>
                    <span class="ms-2">{{$story->button_text}}</span>
                </a>
            @endif


            @if($story->products->count() > 0)
            <div class="story-item-lg-products swiper-no-swiping">
                @foreach($story->products as $storyProduct)
                    <a href="{{route('product.show',$storyProduct)}}" class="product-item-h">
                        <img src="{{$storyProduct->getImage('thumb')}}" alt="{{$storyProduct->title}}">
                        <div class="product-item-h-content">
                            <span class="product-title">{{$storyProduct->title}}</span>
                            <span>{!! $storyProduct->getPriceHtml() !!}</span>
                        </div>
                    </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
