<div id="gatewayBox">
    <p class="text-muted font-12 mb-3 mt-2">قابل پرداخت با تمامی کارت‌های بانکی عضو شتاب</p>
    <div class="d-flex align-items-center mb-3 flex-wrap">
        @if($paymentSettings->parsian)
            <div class="form-check form-check-inline image-check">
                <input type="radio" id="parsian" name="payment_method" value="parsian"
                       class="form-check-input"
                       {{$paymentSettings->default_payment_driver == 'parsian' ? 'checked' : ''}} required>
                <label class="form-check-label" for="parsian">
                    <img src="{{asset('assets/images/parsian.jpg')}}" alt="parsian logo"
                         class="d-block">
                    <span class="fw-bold font-13">پارسیان</span>
                </label>
            </div>
        @endif
        @if($paymentSettings->zibal)
            <div class="form-check form-check-inline image-check">
                <input type="radio" id="zibal" name="payment_method" value="zibal"
                       class="form-check-input"
                       {{$paymentSettings->default_payment_driver == 'zibal' ? 'checked' : ''}} required>
                <label class="form-check-label" for="zibal">
                    <img src="{{asset('assets/images/zibal.jpg')}}" alt="zibal logo"
                         class="d-block">
                    <span class="fw-bold font-13">زیبال</span>
                </label>
            </div>
        @endif

        @if($paymentSettings->mellat)
            <div class="form-check form-check-inline image-check">
                <input type="radio" id="behpardakht" name="payment_method" value="behpardakht"
                       class="form-check-input"
                       {{$paymentSettings->default_payment_driver == 'behpardakht' ? 'checked' : ''}} required>
                <label class="form-check-label" for="behpardakht">
                    <img src="{{asset('assets/images/mellat.jpg')}}" alt="behpardakht logo"
                         class="d-block">
                    <span class="fw-bold font-13">ملت</span>
                </label>
            </div>
        @endif

        @if($paymentSettings->zarinpal)
            <div class="form-check form-check-inline image-check">
                <input type="radio" id="zarinpal" name="payment_method" value="zarinpal"
                       class="form-check-input"
                       {{$paymentSettings->default_payment_driver == 'zarinpal' ? 'checked' : ''}} required>
                <label class="form-check-label" for="zarinpal">
                    <img src="{{asset('assets/images/zarinpal.jpg')}}" alt="zarinpal logo"
                         class="d-block">
                    <span class="fw-bold font-13">زرین پال</span>
                </label>
            </div>
        @endif

        @if($paymentSettings->idpay)
            <div class="form-check form-check-inline image-check">
                <input type="radio" id="idpay" name="payment_method" value="idpay"
                       class="form-check-input"
                       {{$paymentSettings->default_payment_driver == 'idpay' ? 'checked' : ''}} required>
                <label class="form-check-label" for="idpay">
                    <img src="{{asset('assets/images/idpay.jpg')}}" alt="idpay logo"
                         class="d-block">
                    <span class="fw-bold font-13">آیدی پی</span>
                </label>
            </div>
        @endif

            @if($paymentSettings->nextpay)
                <div class="form-check form-check-inline image-check">
                    <input type="radio" id="nextpay" name="payment_method" value="nextpay"
                           class="form-check-input"
                           {{$paymentSettings->default_payment_driver == 'nextpay' ? 'checked' : ''}} required>
                    <label class="form-check-label" for="nextpay">
                        <img src="{{asset('assets/images/nextpay.jpg')}}" alt="nextpay logo"
                             class="d-block">
                        <span class="fw-bold font-13">نکست‌پی</span>
                    </label>
                </div>
            @endif

            @if($paymentSettings->pasargad)
                <div class="form-check form-check-inline image-check">
                    <input type="radio" id="pasargad" name="payment_method" value="pasargad"
                           class="form-check-input"
                           {{$paymentSettings->default_payment_driver == 'pasargad' ? 'checked' : ''}} required>
                    <label class="form-check-label" for="pasargad">
                        <img src="{{asset('assets/images/pasargad.jpg')}}" alt="pasargad logo"
                             class="d-block">
                        <span class="fw-bold font-13">پاسارگاد</span>
                    </label>
                </div>
            @endif

        @if(!$paymentSettings->idpay && !$paymentSettings->pasargad && !$paymentSettings->nextpay && !$paymentSettings->zarinpal && !$paymentSettings->mellat && !$paymentSettings->parsian && !$paymentSettings->zibal)
            <p class="fw-bold color-red mt-3">متاسفانه هیچ درگاه پرداخت فعالی وجود
                ندارد!</p>
        @endif
    </div>
</div>
