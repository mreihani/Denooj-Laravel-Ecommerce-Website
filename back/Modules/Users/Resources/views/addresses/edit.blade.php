@extends('front.layouts.user_panel')
@section('panel_content')

    <div class="box">
        <h1 class="font-18 fw-bold mb-4">ویرایش آدرس</h1>

        @include('front.alerts')
        <form action="{{route('address.update',$address)}}" id="addressForm" method="post">
            @csrf
            <div class="row">
                {{-- province --}}
                <div class="col-lg-6 mb-4">
                    <div class="form-group">
                        <label class="form-label" for="province">استان</label>
                        <select class="form-control select2" id="province" name="province">
                            <option value="" selected>انتخاب استان</option>
                            @foreach(\Modules\Users\Entities\Province::all() as $province)
                                <option value="{{$province->id}}" {{$province->id == $address->province ? 'selected':''}}>{{$province->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- state --}}
                <div class="col-lg-6 mb-4">
                    <div class="form-group">
                        <label class="form-label" for="city">شهر</label>
                        <select class="form-control select2" id="city" name="city">
                            <option value="" selected>انتخاب شهر</option>
                            @foreach(\Modules\Users\Entities\Province::find($address->province)->cities as $city)
                                <option value="{{$city->id}}" {{$city->id == $address->city ? 'selected':''}}>{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- post code --}}
                <div class="col-lg-4 mb-4">
                    <div class="form-group">
                        <label class="form-label" for="post_code">کد پستی</label>
                        <small class="font-13 d-block text-muted mt-0 mb-1">کد پستی را بدون خط فاصله بنویسید.</small>
                        <input type="text" class="form-control" id="post_code" name="post_code"
                               value="{{old('post_code',$address->post_code)}}">
                    </div>
                </div>

                {{-- phone --}}
                <div class="col-lg-4 mb-4">
                    <div class="form-group">
                        <label class="form-label" for="phone">تلفن تماس</label>
                        <small class="font-13 d-block text-muted mt-0 mb-1">شماره موبایل یا تلفن ثابت با کد شهر.</small>
                        <input type="text" class="form-control" id="phone" name="phone"
                               value="{{old('phone',$address->phone)}}">
                    </div>
                </div>

                {{-- full name --}}
                <div class="col-lg-4 mb-4">
                    <div class="form-group">
                        <label class="form-label" for="full_name">نام تحویل گیرنده</label>
                        <small class="font-13 d-block text-muted mt-0 mb-1">نام و نام خانوادگی تحویل گیرنده</small>
                        <input type="text" class="form-control" id="full_name" name="full_name"
                               value="{{old('full_name',$address->full_name)}}">
                    </div>
                </div>

                {{-- address --}}
                <div class="col-12 mb-4">
                    <div class="form-group">
                        <label class="form-label" for="address">آدرس</label>
                        <small class="font-13 d-block text-muted mt-0 mb-1">لطفا آدرس را دقیق بنویسید شامل خیابان، کوچه،
                            پلاک و جزئیات.</small>
                        <textarea id="address" name="address" type="text"
                                  class="form-control">{{old('address',$address->address)}}</textarea>
                    </div>
                </div>

                <div class="col-12">
                    <div class="text-center">
                        <button class="btn btn-success shadow px-4 py-2 font-15 form-submit" id="btnSubmit"><i
                                    class="icon-check"></i> ذخیره تغییرات
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection


@section('after_panel_scripts')
    <script src="{{asset('js/jquery.validate.js')}}"></script>
    <script>
        $(document).ready(function () {
            // form validation
            $("#addressForm").validate({
                errorClass: "is-invalid",
                errorElement: "span",
                errorPlacement: function (error, element) {
                    error.appendTo(element.parent('.form-group'));
                },
                submitHandler: function (form) {
                    $('#btnSubmit').addClass('loading');
                    form.submit();
                },
                rules: {
                    province: {
                        required: true,
                    },
                    city: {
                        required: true,
                    },
                    post_code: {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    address: {
                        required: true,
                        minlength: 8,
                    },
                    phone: {
                        required: true,
                        number: true,
                        minlength: 11,
                        maxlength: 11
                    },
                    full_name: {
                        required: true,
                    }
                },
                messages: {
                    province: {
                        required: "استان را انتخاب کنید.",
                    },
                    city: {
                        required: "شهر را انتخاب کنید.",
                    },
                    post_code: {
                        required: "کد پستی را وارد کنید.",
                        number: "کد پستی باید یک مقدار عددی باشد",
                        minlength: "کد پستی باید 10 رقم باشد",
                        maxlength: "کد پستی باید 10 رقم باشد",
                    },
                    phone: {
                        required: "تلفن را وارد کنید.",
                        number: "شماره تلفن باید یک مقدار عددی باشد",
                        minlength: "شماره تلفن باید 11 رقم باشد",
                        maxlength: "شماره تلفن باید 11 رقم باشد",
                    },
                    address: {
                        required: "آدرس را وارد کنید.",
                        minlength: "آدرس خیلی کوتاه است",
                    },
                    full_name: {
                        required: "نام تحویل گیرنده را وارد کنید.",
                    }
                }
            });
        });
    </script>
@endsection
