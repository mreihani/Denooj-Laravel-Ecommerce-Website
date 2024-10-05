@php $generalSettings = \Modules\Settings\Entities\GeneralSetting::first();@endphp
@extends('front.layouts.master',['h1Title' => $post->h1_hidden ,'navTitle' => $post->nav_title])
@section('content')
    <div class="container-fluid page-content mt-4">
        <div class="custom-container">

            {{-- breadcrumb --}}
            @include('blog::includes.breadcrumb')

            <div class="row">
                <div class="{{$post->sidebar ? 'col-xl-9 col-lg-8' : 'col-12'}} mb-4">
                    <div class="box post-page">
                        @if($post->show_thumbnail)
                        <img src="{{$post->getImage('original')}}" alt="{{$post->image_alt}}" class="img-fluid mb-3">
                        @endif
                        <h2 class="post-title mt-3">{{$post->title}}</h2>

                        <div class="post-details">
                            <div class="text-with-icon"><i
                                        class="icon-eye me-1"></i><span>{{views($post)->count() . ' بازدید'}}</span>
                            </div>
                            @if($post->display_comments)
                            <a href="#comments_section" class="text-with-icon text-decoration-none ms-3"><i
                                        class="icon-message-square me-1"></i><span>{{$post->comments->count() . ' دیدگاه'}}</span></a>
                            @endif
                            <div class="text-with-icon ms-3"><i
                                        class="icon-calendar me-1"></i><span>{{verta($post->created_at)->format('%d %B، %Y')}}</span>
                            </div>
                            <div class="text-with-icon ms-3 me-3"><i
                                        class="icon-clock me-1"></i><span>زمان مطالعه: {{$post->reading_time}}</span>
                            </div>

                            <div class="f-flex ms-auto">
                                {{-- favorite --}}
                                <a class="btn rounded btn-light" @auth data-id="{{$post->id}}" onclick="bookmark(this)"
                                   data-model-name="post" href="javascript:" @else href="{{route('signin')}}" @endauth
                                   data-bs-toggle="tooltip" data-bs-placement="top" title="نشان کردن">
                                    @if($post->liked())
                                        <i class="icon-bookmark text-danger font-20"></i>
                                    @else
                                        <i class="icon-bookmark font-20"></i>
                                    @endif
                                </a>

                                {{-- share --}}
                                <span class="btn rounded btn-light ms-2"
                                      data-bs-toggle="modal" data-bs-target="#sharePostModal"><i
                                            class="icon-share-2 font-20"></i></span>
                            </div>

                        </div>

                        <div class="content-area mt-4">
                            @if($post->excerpt)
                            <blockquote class="mb-4 w-100">{{$post->excerpt}}</blockquote>
                            @endif
                            {!! $post->body !!}
                        </div>

                    </div>

                    {{-- comments --}}
                    @if(\Nwidart\Modules\Facades\Module::has('Comments') && \Nwidart\Modules\Facades\Module::isEnabled('Comments') && $post->display_comments)
                        <div class="box mt-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <span class="d-block fw-bold font-20"><i class="icon-message-circle text-muted"></i> دیدگاه ها</span>
                                @auth
                                    <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalAddComment"><i
                                                class="icon-plus-circle me-3"></i><span>ثبت دیدگاه</span></button>
                                @else
                                    <a href="{{route('signin')}}" class="btn btn-outline-primary"><i
                                                class="icon-plus-circle me-3"></i><span>ثبت دیدگاه</span></a>
                                @endauth
                            </div>


                            @php $comments = $post->comments()->where('status','published');@endphp
                            <div class="comments-container" id="comments_section">
                                @if($comments->count() > 0)
                                    @foreach($comments->get() as $comment)
                                        @include('comments::includes.comment_item',['comment' => $comment])
                                    @endforeach
                                @else
                                    <p class="mb-0">اولین نفری باشید که دیدگاهی ثبت میکند!</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                {{-- sidebar --}}
                @if($post->sidebar)
                    <div class="col-xl-3 col-lg-4">

                        {{-- keywords --}}
                        @if($post->tags->count() > 0)
                            <div class="box mb-4">
                                <span class="d-block mb-2 mt-4">کلمات کلیدی:</span>
                                @foreach($post->tags as $tag)
                                    <a href="{{route('post_tag.show',$tag->slug)}}"
                                       class="btn-label-main btn-label-secondary d-inline-block fw-normal font-14 m-1">{{$tag->name}}</a>
                                @endforeach
                            </div>
                        @endif

                        {{-- similar posts --}}
                        @if($similarPosts->count() > 0)
                            <div class="box mb-4">
                                <div class="section-title mb-4 section-product-head">
                                    <div class="m-0 font-17 fw-800 title">مطالب مشابه</div>
                                </div>
                                @foreach($similarPosts as $p)
                                    @include('blog::includes.post_item_h',['post' => $p])
                                @endforeach
                            </div>
                        @endif

                        {{-- recommended products --}}
                        <div class="box mb-4 product-list">
                            <div class="section-title mb-4 section-product-head">
                                <div class="m-0 font-17 fw-800 title">محصولات پیشنهادی</div>
                            </div>
                            <div class="swiper swiper-buttons-zero" id="recommendedProductsSwiper">
                                <div class="swiper-wrapper">
                                    @foreach($products as $product)
                                        <div class="swiper-slide">
                                            @include('products::includes.product_item',$product)
                                        </div>
                                    @endforeach
                                </div>
                                <div class="custom-swiper-button-prev"><i class="icon-arrow-right"></i></div>
                                <div class="custom-swiper-button-next"><i class="icon-arrow-left"></i></div>
                            </div>

                        </div>

                        {{-- banners --}}
                        @if(\Nwidart\Modules\Facades\Module::has('Banners') && \Nwidart\Modules\Facades\Module::isEnabled('Banners'))
                            @php $banners = \Modules\Banners\Entities\Banner::where('location','posts_sidebar')->get();@endphp
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

    {{-- add comment modal --}}
    @if(\Nwidart\Modules\Facades\Module::has('Comments') && \Nwidart\Modules\Facades\Module::isEnabled('Comments'))
        @include('comments::includes.modal_add_comment_post',['post' => $post,'generalSettings' => $generalSettings])
    @endif

    @include('blog::includes.modal_share_post',$post)
@endsection
@section('scripts')
    <script src="{{asset('assets/js/post.js')}}"></script>
@endsection
