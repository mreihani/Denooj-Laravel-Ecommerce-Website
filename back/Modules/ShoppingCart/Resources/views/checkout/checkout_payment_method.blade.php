<div class="box p-3 mb-5 mb-sm-3">
    <div class="section-title font-17 fw-bold mb-4 d-flex align-items-center">
        <i class="icon-credit-card me-2 mb-1 text-muted"></i>
        <span>پرداخت</span>
    </div>

    {{-- gateways --}}
    @include('front.includes.gateways')

    {{-- wallet check --}}
    <div class="mt-4 border-start border-3 border-warning ps-3 {{$balance > 0 ? '' : 'd-none'}}" id="walletCheckAlert">
        <span class="d-block fw-bold mb-2">موجودی کیف پول شما: <b>{{number_format($balance)}}</b> تومان</span>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="wallet_check" id="wallet_check">
            <label class="form-check-label" for="wallet_check">موجودی کیف پولم را از مبلغ سفارش کم کن</label>
        </div>
    </div>
    <input type="hidden" id="balance" value="{{$balance}}">
    <input type="hidden" id="priceToPay" value="{{cart()->getTotal()}}">
    <input type="hidden" id="basePriceToPay" value="{{cart()->getTotal()}}">

    {{-- pay --}}
    <div class="mt-5">
        <div class="d-flex align-items-center justify-content-between">
            <span class="fw-bold text-dark font-17 font-sm-14">مبلغ قابل پرداخت:</span>

            <span class="fw-bold text-danger font-20 font-sm-14">
                      <b class="price-to-pay">{{number_format(cart()->getTotal())}}</b>
                <span class="font-16"> تومان</span></span>
        </div>
        <button class="btn btn-success shadow btn-block text-center mt-2 mt-lg-4 p-3 w-100"
                id="btnSubmitPay" type="button"><i class="icon-check me-3"></i><span>پرداخت و ثبت سفارش</span>
        </button>
    </div>
</div>
