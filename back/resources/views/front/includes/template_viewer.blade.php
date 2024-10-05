@if($template->rows()->count() > 0)
@foreach($template->rows()->orderBy('order','asc')->get() as $row)
    @if($row->custom_css)
        <style>{!! $row->custom_css !!}</style>
    @endif
    <div id="{{$row->css_id}}" style="margin-top: {{$row->margin_top . 'px'}}; margin-bottom: {{$row->margin_bottom . 'px'}}">
        @switch($row->widget_type)

            @case('image_slider')
                @include('front.includes.widgets.widget_image_slider',$row)
                @break

            @case('banner_location')
                @include('front.includes.widgets.widget_banner_location',$row)
                @break

            @case('stories')
                @include('front.includes.widgets.widget_stories',$row)
                @break

            @case('featured_categories_carousel')
                @include('front.includes.widgets.widget_featured_categories_carousel',$row)
                @break

            @case('featured_categories_grid')
                @include('front.includes.widgets.widget_featured_categories_grid',$row)
                @break

            @case('products_carousel')
                @include('front.includes.widgets.widget_products_carousel',$row)
                @break

            @case('featured_products')
                @include('front.includes.widgets.widget_featured_products',$row)
                @break

            @case('posts')
                @include('front.includes.widgets.widget_posts',$row)
                @break

            @case('editor')
                @include('front.includes.widgets.widget_editor',$row)
                @break

            @case('faq')
                @include('front.includes.widgets.widget_faq',$row)
                @break

        @endswitch
    </div>
@endforeach
@else
    <div class="custom-container mt-5">
        <div class="alert alert-dark">فعلا اینجا خبری نیست، هیچ ویجتی به صفحه اضافه نشده!</div>
    </div>
@endif
