@php  $featuredCategories  = \Modules\Products\Entities\Category::where('featured', true)->orderByDesc('featured_index')->limit(12)->get(); @endphp
    <section class="section">
        <div class="{{$row->layout == 'box' ? 'custom-container' : ''}}">

            <div class="swiper categories-swiper swiper-buttons-zero">
                <div class="swiper-wrapper">
                    @foreach($featuredCategories as $category)
                        <div class="swiper-slide">
                            <a href="{{route('category.show',$category)}}" class="category-item">
                                <div class="category-item-overly" style="background: linear-gradient(0deg, {{$row->featured_categories_overlay_color}}, transparent)">
                                    @if($row->featured_categories_show_count)
                                    <span class="count">{{$category->getAllPublishedProducts()->count() . ' محصول'}}</span>
                                    @endif
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
    </section>


