<div class="box p-3 mb-3">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="section-title font-17 fw-bold mb-0 d-flex align-items-center">
            <i class="icon-map-pin me-2 mb-1 text-muted"></i>
            <span>انتخاب آدرس ارسال</span>
        </h1>
        <div>
            <a href="{{route('panel.addresses')}}" class="underline-link font-13">
                <span>ویرایش آدرس ها</span>
                <i class="icon-edit-2 ms-1"></i></a>
        </div>
    </div>

    @if(auth()->user()->addresses->count() < 1)
        <div class="alert alert-warning">
            شما هیچ آدرسی ثبت نکرده اید، با کلیک روی علامت + یک آدرس اضافه کنید.
        </div>
    @else
        <select name="address_id" id="address_id" class="form-select form-control" aria-label="address_id">
            <option value="" selected>آدرس خود را انتخاب کنید</option>
            @foreach(auth()->user()->addresses as $address)
                <option value="{{$address->id}}">{{$address->getProvince()->name .' - ' .$address->getCity()->name . ' - ' . $address->address}}</option>
            @endforeach
        </select>
    @endif
    {{-- plus --}}
    <div class="d-lg-flex align-items-center mt-3">
                                <span class="plusBox d-flex align-items-center justify-content-center"
                                      data-bs-toggle="modal" data-bs-target="#addressModal">
                                    <i class="icon-plus font-20"></i>
                                    <span class="ms-2">افزون آدرس جدید</span>
                                </span>
    </div>

    {{-- selected address details --}}
    <p class="font-15 text-muted text-desc m-0 mt-4 lh-30 d-none" id="selectedAddress">
        سفارش شما به شهر:
        <span class="fw-bold text-dark" id="addressCity"></span>
        ، با آدرس:
        <span class="fw-bold text-dark" id="addressAddress"></span>
        ، با کد پستی:
        <span class="fw-bold text-dark" id="addressPostCode"></span>
        ، به نام:
        <span class="fw-bold text-dark" id="addressFullName"></span>
        ، و شماره تماس:
        <span class="fw-bold text-dark" id="addressPhone"></span>
        ارسال خواهد شد.
    </p>

</div>
