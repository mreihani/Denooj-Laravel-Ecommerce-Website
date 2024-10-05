<section class="section">


    @if($row->featured_products_bg_color)
        <style>
            {{'#content-dropdown-' . $row->id}}{
                background:{{$row->featured_products_bg_color}};
                color: {{$row->featured_products_title_color}};
            }
            {{'#content-dropdown-' . $row->id . ':before'}}{
                background: linear-gradient(0deg,{{$row->featured_products_bg_color}},{{$row->featured_products_bg_color}},transparent);
            }
            {{'#content-dropdown-' . $row->id . ' .content-dropdown-toggle'}}{
                color: {{$row->featured_products_title_color}};
            }
        </style>
    @endif

    <div class="{{$row->layout == 'box' ? 'custom-container' : ''}}">

        <div class="box content-area shadow-none {{$row->featured_products_available ? 'content-dropdown' : ''}} " id="{{'content-dropdown-' . $row->id}}">
            {!! $row->editor_content !!}

            @if($row->featured_products_available)
            <button type="button" class="content-dropdown-toggle"><span>مشاهده بیشتر</span><i
                    class="icon-chevron-down ms-2"></i></button>
            @endif
        </div>


    </div>
</section>



