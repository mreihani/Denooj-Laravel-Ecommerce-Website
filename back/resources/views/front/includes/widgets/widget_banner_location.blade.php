@php $widgetBanners = \Modules\Banners\Entities\Banner::where('location','row_' . $row->id)->get(); @endphp
    <section class="section">
        <div class="{{$row->layout == 'box' ? 'custom-container' : ''}}">
            @if($widgetBanners->count() > 0)
                <div class="row">
                    @foreach($widgetBanners as $widgetBanner)
                        <div class="col-lg-{{$widgetBanner->lg_col}} col-sm-{{$widgetBanner->sm_col}} col-{{$widgetBanner->col}}" style="margin-top: {{$widgetBanner->margin_top . 'px'}}; margin-bottom: {{$widgetBanner->margin_bottom . 'px'}}">
                            @include('banners::includes.banner_item',['banner' => $widgetBanner])
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">هیچ بنری برای این جایگاه تعیین نشده است.</div>
            @endif
        </div>
    </section>



