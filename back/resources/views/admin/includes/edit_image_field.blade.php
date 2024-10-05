<div class="image-chooser">
    <label class="form-label" for="header_logo">آدرس تصویر لوگو</label>
    @if($settings->header_logo != null)
        <img src="{{$settings->getHeaderLogo()}}" alt="img" class="img-fluid" id="header-logo-image">
        <button type="button" class="btn btn-sm btn-label-danger mb-3 remove-image-file"
                data-url="{{$settings->header_logo}}"
                image-id="header-logo-image" data-input-id="header_logo">
            <i class="bx bxs-trash"></i>
            <span>حذف تصویر</span>
        </button>
    @endif
    <input type="text" name="header_logo" class="form-control" dir="ltr"
           id="header_logo" value="{{old('header_logo',$settings->header_logo)}}">
</div>
