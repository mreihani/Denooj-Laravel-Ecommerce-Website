@if($posts->count() > 0)
    <section class="container-fluid posts-container mb-4 mb-lg-5">
    <div class="custom-container">
        <div class="section-blog-head mb-4 mb-lg-5">
            <div class="d-flex align-items-center">
                <div class="section-title-mark d-none d-sm-flex">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="m-0 ms-sm-2 mt-2 font-22 fw-800 title">{{$appearanceSettings->home_blog_title}}</div>
            </div>
            <a href="{{route('blog')}}" class="underline-link d-none d-sm-block"><span>{{$appearanceSettings->home_blog_btn_text}}</span><i class="icon-arrow-left ms-2"></i></a>
        </div>

        {{-- carousel --}}
        <div class="posts-swiper-container">
            <div class="swiper posts-swiper swiper-equal swiper-navigation-hover swiper-navigation-accent">
                <div class="swiper-wrapper">
                    @foreach($posts as $post)
                        <div class="swiper-slide">
                            @include('blog::includes.post_item',$post)
                        </div>
                    @endforeach
                </div>
                <div class="custom-swiper-button-prev"><i class="icon-arrow-right"></i></div>
                <div class="custom-swiper-button-next"><i class="icon-arrow-left"></i></div>
            </div>
        </div>


        <div class="text-center mt-2 d-block d-sm-none">
            <a href="{{route('blog')}}" class="underline-link mb-5"><span>{{$appearanceSettings->home_blog_btn_text}}</span><i class="icon-arrow-left ms-2"></i></a>
        </div>

    </div>
</section>
@endif
