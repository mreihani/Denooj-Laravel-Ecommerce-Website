@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">تنظیمات /</span> پرداخت
    </h4>
    @include('admin.includes.alerts')
    <div class="row">
        <div class="col-md-12">
            @include('settings::nav')
            <div class="card mb-4">
                <h5 class="card-header">تنظیمات پرداخت</h5>
                <form action="{{route('settings.payment_update',$settings)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        {{-- general --}}
                        <div class="row">
                            <div class="mb-4">
                                <label class="switch switch-square">
                                    <input type="checkbox" class="switch-input" name="sandbox" {{$settings->sandbox ? 'checked' : ''}}>
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                    <span class="switch-label">حالت پرداخت آزمایشی</span>
                                </label>
                                <small class="d-block text-muted">با فعال کردن این گزینه، تمامی پرداخت ها به صورت آزمایشی انجام خواهد شد و هیچ پولی رد و بدل نمیشود.</small>
                            </div>

                            <div class="mb-4 col-lg-6">
                                <label for="payment_description" class="form-label">توضیحات پرداخت</label>
                                <input class="form-control text-start" dir="ltr" type="text" id="payment_description" name="payment_description"
                                       value="{{old('payment_description',$settings->payment_description)}}">
                            </div>

                            <div class="mb-4 col-lg-6">
                                <label class="form-label" for="default_payment_driver">درگاه پرداخت پیشفرض</label>
                                <select class="select2 form-select" id="default_payment_driver" name="default_payment_driver">
                                    <option value="parsian" {{ $settings->default_payment_driver == 'parsian' ? 'selected' : '' }}>پارسیان (Parsian)</option>
                                    <option value="mellat" {{ $settings->default_payment_driver == 'mellat' ? 'selected' : '' }}>به پرداخت ملت (Mellat)</option>
                                    <option value="zarinpal" {{ $settings->default_payment_driver == 'zarinpal' ? 'selected' : '' }}>زرین پال (Zarinpal)</option>
                                    <option value="idpay" {{ $settings->default_payment_driver == 'idpay' ? 'selected' : '' }}>آی دی پی (IDPay)</option>
                                    <option value="zibal" {{ $settings->default_payment_driver == 'zibal' ? 'selected' : '' }}>زیبال (Zibal)</option>
                                    <option value="nextpay" {{ $settings->default_payment_driver == 'nextpay' ? 'selected' : '' }}>نکست پی (Nextpay)</option>
                                    <option value="pasargad" {{ $settings->default_payment_driver == 'pasargad' ? 'selected' : '' }}>پاسارگاد (Pasargad)</option>
                                </select>
                            </div>
                        </div>

                        <hr>

                        <h4 class="card-title">درگاه های پرداخت</h4>

                        {{-- nextpay gateway --}}
                        <div class="mb-3">
                            <label class="switch switch-square">
                                <input type="checkbox" class="switch-input banta-check-switcher"
                                       data-switcher="nextpay_fields" name="nextpay" {{$settings->nextpay ? 'checked' : ''}}>
                                <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                <span class="switch-label">نکست پی (Nextpay)</span>
                            </label>
                        </div>
                        <div class="mb-5 {{$settings->nextpay ? '' : 'd-none'}}" id="nextpay_fields">
                            <label for="nextpay_merchant_id" class="form-label">Api Key نکست پی</label>
                            <input class="form-control text-start" dir="ltr" type="text" id="nextpay_merchant_id" name="nextpay_merchant_id"
                                   value="{{old('nextpay_merchant_id',$settings->nextpay_merchant_id)}}">
                        </div>

                        {{-- zibal gateway --}}
                        <div class="mb-3">
                            <label class="switch switch-square">
                                <input type="checkbox" class="switch-input banta-check-switcher"
                                       data-switcher="zibal_fields" name="zibal" {{$settings->zibal ? 'checked' : ''}}>
                                <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                <span class="switch-label">زیبال (Zibal)</span>
                            </label>
                        </div>
                        <div class="mb-5 {{$settings->zibal ? '' : 'd-none'}}" id="zibal_fields">
                            <label for="zibal_merchant_id" class="form-label">مرچنت کد زیبال</label>
                            <input class="form-control text-start" dir="ltr" type="text" id="zibal_merchant_id" name="zibal_merchant_id"
                                   value="{{old('zibal_merchant_id',$settings->zibal_merchant_id)}}">
                        </div>

                        {{-- zarinpal gateway --}}
                        <div class="mb-3">
                            <label class="switch switch-square">
                                <input type="checkbox" class="switch-input banta-check-switcher"
                                       data-switcher="zarinpal_fields" name="zarinpal" {{$settings->zarinpal ? 'checked' : ''}}>
                                <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                <span class="switch-label">زرین پال (Zarinpal)</span>
                            </label>
                        </div>
                        <div class="mb-5 {{$settings->zarinpal ? '' : 'd-none'}}" id="zarinpal_fields">
                            <label for="zarinpal_merchant_id" class="form-label">مرچنت کد زرین پال</label>
                            <input class="form-control text-start" dir="ltr" type="text" id="zarinpal_merchant_id" name="zarinpal_merchant_id"
                                   value="{{old('zarinpal_merchant_id',$settings->zarinpal_merchant_id)}}">
                        </div>

                        {{-- idpay gateway --}}
                        <div class="mb-3">
                            <label class="switch switch-square">
                                <input type="checkbox" class="switch-input banta-check-switcher"
                                       data-switcher="idpay_fields" name="idpay" {{$settings->idpay ? 'checked' : ''}}>
                                <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                <span class="switch-label">آی دی پی (IDPay)</span>
                            </label>
                        </div>
                        <div class="mb-5 {{$settings->idpay ? '' : 'd-none'}}" id="idpay_fields">
                            <label for="idpay_merchant_id" class="form-label">مرچنت کد آی دی پی</label>
                            <input class="form-control text-start" dir="ltr" type="text" id="idpay_merchant_id" name="idpay_merchant_id"
                                   value="{{old('idpay_merchant_id',$settings->idpay_merchant_id)}}">
                        </div>

                        {{-- parsian gateway --}}
                        <div class="mb-3">
                            <label class="switch switch-square">
                                <input type="checkbox" class="switch-input banta-check-switcher"
                                       data-switcher="parsian_fields" name="parsian" {{$settings->parsian ? 'checked' : ''}}>
                                <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                <span class="switch-label">پارسیان (parsian)</span>
                            </label>
                        </div>
                        <div class="mb-5 {{$settings->parsian ? '' : 'd-none'}}" id="parsian_fields">
                            <div class="row">
                                <div class="col-12">
                                    <label for="parsian_pin_code" class="form-label">پین کد پارسیان</label>
                                    <input class="form-control text-start" dir="ltr" type="text" id="parsian_pin_code" name="parsian_pin_code"
                                           value="{{old('parsian_pin_code',$settings->parsian_pin_code)}}">
                                </div>
{{--                                <div class="col-lg-4">--}}
{{--                                    <label for="parsian_pin_code_sandbox" class="form-label">پین کد آزمایشی</label>--}}
{{--                                    <input class="form-control text-start" dir="ltr" type="text" id="parsian_pin_code_sandbox" name="parsian_pin_code_sandbox"--}}
{{--                                           value="{{old('parsian_pin_code_sandbox',$settings->parsian_pin_code_sandbox)}}">--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-4">--}}
{{--                                    <label for="parsian_terminal" class="form-label">ترمینال</label>--}}
{{--                                    <input class="form-control text-start" dir="ltr" type="text" id="parsian_terminal" name="parsian_terminal"--}}
{{--                                           value="{{old('parsian_terminal',$settings->parsian_terminal)}}">--}}
{{--                                </div>--}}
                            </div>
                        </div>

                        {{-- mellat gateway --}}
                        <div class="mb-3">
                            <label class="switch switch-square">
                                <input type="checkbox" class="switch-input banta-check-switcher"
                                       data-switcher="mellat_fields" name="mellat" {{$settings->mellat ? 'checked' : ''}}>
                                <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                <span class="switch-label">به پرداخت ملت (mellat)</span>
                            </label>
                        </div>
                        <div class="mb-5 {{$settings->mellat ? '' : 'd-none'}}" id="mellat_fields">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="mellat_payane" class="form-label">پایانه</label>
                                    <input class="form-control text-start" dir="ltr" type="text" id="mellat_payane" name="mellat_payane"
                                           value="{{old('mellat_payane',$settings->mellat_payane)}}">
                                </div>
                                <div class="col-lg-4">
                                    <label for="mellat_username" class="form-label">نام کاربری</label>
                                    <input class="form-control text-start" dir="ltr" type="text" id="mellat_username" name="mellat_username"
                                           value="{{old('mellat_username',$settings->mellat_username)}}">
                                </div>
                                <div class="col-lg-4">
                                    <label for="mellat_password" class="form-label">کله عبور</label>
                                    <input class="form-control text-start" dir="ltr" type="text" id="mellat_password" name="mellat_password"
                                           value="{{old('mellat_password',$settings->mellat_password)}}">
                                </div>
                            </div>

                        </div>

                        {{-- pasargad gateway --}}
                        <div class="mb-3">
                            <label class="switch switch-square">
                                <input type="checkbox" class="switch-input banta-check-switcher"
                                       data-switcher="pasargad_fields" name="pasargad" {{$settings->pasargad ? 'checked' : ''}}>
                                <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                <span class="switch-label">پاسارگاد (pasargad)</span>
                            </label>
                        </div>
                        <div class="mb-5 {{$settings->pasargad ? '' : 'd-none'}}" id="pasargad_fields">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="pasargad_merchant_id" class="form-label">شماره فروشگاه</label>
                                    <input class="form-control text-start" dir="ltr" type="text" id="pasargad_merchant_id" name="pasargad_merchant_id"
                                           value="{{old('pasargad_merchant_id',$settings->pasargad_merchant_id)}}">
                                </div>
                                <div class="col-lg-6">
                                    <label for="pasargad_terminal" class="form-label">شماره ترمینال</label>
                                    <input class="form-control text-start" dir="ltr" type="text" id="pasargad_terminal" name="pasargad_terminal"
                                           value="{{old('pasargad_terminal',$settings->pasargad_terminal)}}">
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <button type="submit" class="btn btn-success me-2 submit-button">ذخیره تغییرات</button>
                            <a href="{{route('admin.dashboard')}}" class="btn btn-label-secondary">انصراف</a>
                        </div>


                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
