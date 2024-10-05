@if($row->widget_type == 'image_slider' || $row->widget_type == 'banner_location')
    <div class="alert alert-info font-13">برای بارگذاری تصاویر، از <a href="{{route('banners.index')}}">بخش بنرها</a> اقدام کنید و محل نمایش بنر را طبق نام این  قالب و سطر مشخص کنید.</div>
@endif
