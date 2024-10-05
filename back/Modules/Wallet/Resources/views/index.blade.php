@extends('front.layouts.user_panel')
@section('panel_content')
    <div class="box">
        <div class="section-title font-18 fw-bold mb-4">کیف‌پول من</div>

        @include('front.alerts')

        <div class="mb-3 font-18 mt-4">موجودی فعلی:
            <b>{{number_format(auth()->user()->balance) . ' تومان'}}</b>
        </div>
        <div class="text-info">
            با شارژ کردن کیف پول، میتوانید بخشی یا کل مبلغ خرید های خود را از طریق کیف پول پرداخت کنید.
        </div>
    </div>

    <div class="row mt-4">
        {{-- deposit form --}}
        <div class="col-lg-5 mb-4">
            <div class="box">
                <form action="{{route('panel.wallet_deposit')}}" id="depositForm" method="post">
                    @csrf

                    <span class="form-title mb-4 d-block">افزایش موجودی کیف پول</span>
                    <div class="form-group">
                        <label for="amount" class="font-15 font-w-500 form-label">مبلغ به تومان
                            <span class="text-warning font-w-400 font-13">(حداقل 5 هزار تومان)</span>
                        </label>
                        <input type="number" name="amount" id="amount" class="form-control text-center" autofocus>
                        <small id="emailHelp" class="form-text text-muted mt-2 ps-1 d-block">مبلغی که میخواهید به کیف پولتان اضافه کنید را
                            وارد کنید.</small>
                    </div>

                    <div class="form-group mt-4">
                        <label class="font-15 fw-bold">انتخاب درگاه پرداخت</label>
                        <p class="text-muted font-12 mb-3 mt-2">قابل پرداخت با تمامی کارت‌های بانکی عضو شتاب</p>

                        @if($paymentSettings->zibal)
                            <div class="form-check form-check-inline image-check">
                                <input type="radio" id="zibal" name="gateway" value="zibal"
                                       class="form-check-input" {{$paymentSettings->default_payment_driver == 'zibal' ? 'checked' : ''}} required>
                                <label class="form-check-label" for="zibal">
                                    <img src="{{asset('assets/images/zibal.jpg')}}" alt="zibal logo" class="d-block">
                                    <span class="fw-bold font-13">زیبال</span>
                                </label>
                            </div>
                        @endif

                        @if($paymentSettings->nextpay)
                            <div class="form-check form-check-inline image-check">
                                <input type="radio" id="nextpay" name="gateway" value="nextpay"
                                       class="form-check-input" {{$paymentSettings->default_payment_driver == 'nextpay' ? 'checked' : ''}} required>
                                <label class="form-check-label" for="nextpay">
                                    <img src="{{asset('assets/images/nextpay.jpg')}}" alt="nextpay logo" class="d-block">
                                    <span class="fw-bold font-13">نکست‌پی</span>
                                </label>
                            </div>
                        @endif

                        @if($paymentSettings->parsian)
                            <div class="form-check form-check-inline image-check">
                                <input type="radio" id="parsian" name="gateway" value="parsian"
                                       class="form-check-input" {{$paymentSettings->default_payment_driver == 'parsian' ? 'checked' : ''}} required>
                                <label class="form-check-label" for="parsian">
                                    <img src="{{asset('assets/images/parsian.jpg')}}" alt="parsian logo" class="d-block">
                                    <span class="fw-bold font-13">پارسیان</span>
                                </label>
                            </div>
                        @endif

                        @if($paymentSettings->mellat)
                            <div class="form-check form-check-inline image-check">
                                <input type="radio" id="mellat" name="gateway" value="mellat"
                                       class="form-check-input" {{$paymentSettings->default_payment_driver == 'mellat' ? 'checked' : ''}} required>
                                <label class="form-check-label" for="mellat">
                                    <img src="{{asset('assets/images/mellat.jpg')}}" alt="mellat logo" class="d-block">
                                    <span class="fw-bold font-13">ملت</span>
                                </label>
                            </div>
                        @endif

                        @if($paymentSettings->zarinpal)
                        <div class="form-check form-check-inline image-check">
                            <input type="radio" id="zarinpal" name="gateway" value="zarinpal"
                                   class="form-check-input" {{$paymentSettings->default_payment_driver == 'zarinpal' ? 'checked' : ''}}>
                            <label class="form-check-label" for="zarinpal">
                                <img src="{{asset('assets/images/zarinpal.jpg')}}" alt="zarinpal logo" class="d-block">
                                <span class="fw-bold font-13">زرین پال</span>
                            </label>
                        </div>
                        @endif

                        @if($paymentSettings->idpay)
                        <div class="form-check form-check-inline image-check">
                            <input type="radio" id="idpay" name="gateway" value="idpay"
                                   class="form-check-input" {{$paymentSettings->default_payment_driver == 'idpay' ? 'checked' : ''}}>
                            <label class="form-check-label" for="idpay">
                                <img src="{{asset('assets/images/idpay.jpg')}}" alt="idpay logo" class="d-block">
                                <span class="fw-bold font-13">آیدی پی</span>
                            </label>
                        </div>
                        @endif

                        @if($paymentSettings->pasargad)
                            <div class="form-check form-check-inline image-check">
                                <input type="radio" id="pasargad" name="gateway" value="pasargad"
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
                            <p class="fw-bold color-red mt-3">متاسفانه هیچ درگاه پرداخت فعالی وجود ندارد!</p>
                        @endif
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" id="btnSubmit" class="btn btn-success shadow form-submit">
                            <i class="icon-check"></i> پرداخت و افزایش موجودی
                        </button>
                    </div>

                </form>
            </div>
        </div>

        {{-- wallet payment history --}}
        <div class="col-lg-7">
            <div class="box">
                @if($payments->count() > 0)
                    <div class="box-table">
                        <div class="d-flex justify-content-between align-items-center p-4">
                            <span class="fw-bold font-16">تاریخچه تراکنش های شما</span>
                        </div>
                        <div class="divTable w-100">
                            <div class="divTableBody">
                                <div class="divTableRow divTableHead">
                                    <div class="divTableCell">تاریخ</div>
                                    <div class="divTableCell">مبلغ</div>
                                    <div class="divTableCell">درگاه پرداخت</div>
                                    <div class="divTableCell">کد پیگیری</div>
                                    <div class="divTableCell">وضعیت</div>
                                </div>
                                @foreach($payments as $payment)
                                    <div class="divTableRow">
                                        <div class="divTableCell">
                                            <?php $v = new \Hekmatinasser\Verta\Verta($payment->created_at);?>
                                            <span class="text-nowrap">{{$v->format('Y/n/j ساعت H:i')}}</span>
                                        </div>
                                        <div class="divTableCell"><span
                                                class="price-value">{{number_format($payment->amount) . ' تومان'}}</span>
                                        </div>

                                        <div class="divTableCell"><span
                                                class="price-value">{{$payment->getGatewayName()}}</span>
                                        </div>
                                        <div class="divTableCell"><span
                                                class="price-value">{{$payment->tracking_code ?? '----'}}</span>
                                        </div>
                                        <div class="divTableCell">
                                            @if($payment->status == 'failed')
                                                <span class="badge bg-danger">ناموفق</span>
                                            @else
                                                <span class="badge bg-success">موفق</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{$payments->links()}}
                @else
                    <div class="alert alert-info">تا کنون تراکنشی انجام نشده است.</div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('after_panel_scripts')
    <script>
        $(document).ready(function () {
            // form validation
            $("#depositForm").validate({
                errorClass: "is-invalid",
                errorElement: "span",
                errorPlacement: function(error, element) {
                    error.appendTo( element.parent('.form-group') );
                },
                submitHandler: function(form) {
                    $('#btnSubmit').addClass('loading');
                    form.submit();
                },
                rules: {
                    amount: {
                        required: true,
                        min: 5000,
                        max:100000000
                    },
                    gateway:{
                        required: true
                    }
                },
                messages: {
                    amount: {
                        required: "مبلغ را وارد کنید.",
                        min: "حداقل مبلغ باید 5000 تومان باشد",
                        max: "مبلغ وارد شده بیشتر از حد مجاز است."
                    },
                    gateway:{
                        required: "هیچ درگاه پرداختی انتخاب نشده است."
                    }
                }
            });
        });
    </script>
@endsection
