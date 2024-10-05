@php  $featuredCategories  = \Modules\Products\Entities\Category::where('featured', true)->orderByDesc('featured_index')->limit($row->featured_categories_grid_items_count)->get(); @endphp
    <section class="section">
        <div class="{{$row->layout == 'box' ? 'custom-container' : ''}}">


            <div class="row">
                @foreach($featuredCategories as $category)
                    <div class="col-lg-{{$row->featured_categories_grid_item_per_row}} col-sm-{{$row->featured_categories_grid_item_per_row_tablet}} col-{{$row->featured_categories_grid_item_per_row_mobile}} mb-2">
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

        </div>
    </section>


