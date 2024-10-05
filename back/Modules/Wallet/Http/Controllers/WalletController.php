<?php

namespace Modules\Wallet\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Settings\Entities\PaymentSetting;
use Modules\Users\Entities\UserPayment;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class WalletController extends \App\Http\Controllers\Controller
{
    public function index()
    {
        $paymentSettings = PaymentSetting::first();
        $payments = auth()->user()->walletPayments()->latest()->paginate(20);
        return view('wallet::index',compact('payments','paymentSettings'));
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'gateway' => 'required',
        ]);

        if ($request->amount < 5000) {
            session()->flash('error', 'حداقل مبلغ واریزی باید 5 هزار تومان باشد.');
            return redirect()->back();
        }

        if ($request->amount > 100000000) {
            session()->flash('error', 'مبلغ وارد شده بیش از حد مجاز است.');
            return redirect()->back();
        }

        $driverName = $request->gateway;
        $amount = $this->convertPersianNumToEnglish($request->amount);
        $user = auth()->user();
        $type = 'wallet';

        // get payment settings from database
        $settings = PaymentSetting::first();
        $sandbox = $settings->sandbox;
        $paymentDescription = $settings->payment_description;

        if ($driverName == 'zarinpal'){
            $callbackUrl = env('APP_URL') .  env('ZARINPAL_CALLBACK_URL');

            // check zarinpal settings
            if(empty($settings->zarinpal_merchant_id)){
                session()->flash('error','درگاه پرداخت زرین پال فعال نیست! درصورت وجود مشکل با مدیر سایت تماس بگیرید!');
                return redirect()->back();
            }
            $config = [
                'mode' => $sandbox ? 'sandbox' : 'normal',
                'merchantId' => $settings->zarinpal_merchant_id,
                'callbackUrl' => $callbackUrl,
                'description' => $paymentDescription,
            ];

        }elseif ($driverName == 'zibal'){
            $callbackUrl = env('APP_URL') .  env('ZIBAL_CALLBACK_URL');

            // check zibal settings
            if(empty($settings->zibal_merchant_id)){
                session()->flash('error','درگاه پرداخت زیبال فعال نیست! درصورت وجود مشکل با مدیر سایت تماس بگیرید!');
                return redirect()->back();
            }
            $config = [
                'merchantId' => $settings->zibal_merchant_id,
                'callbackUrl' => $callbackUrl,
                'description' => $paymentDescription,
                'sandbox' => $sandbox,
            ];

        }elseif ($driverName == 'nextpay'){
            $callbackUrl = env('APP_URL') .  env('NEXTPAY_CALLBACK_URL');

            // check nextpay settings
            if(empty($settings->nextpay_merchant_id)){
                session()->flash('error','درگاه پرداخت نکست پی فعال نیست! درصورت وجود مشکل با مدیر سایت تماس بگیرید!');
                return redirect()->back();
            }
            $config = [
                'merchantId' => $settings->nextpay_merchant_id,
                'callbackUrl' => $callbackUrl,
                'description' => $paymentDescription,
                'sandbox' => $sandbox,
            ];

        } elseif ($driverName == 'idpay'){
            $callbackUrl = env('APP_URL') .  env('IDPAY_CALLBACK_URL');

            // check idpay settings
            if(empty($settings->idpay_merchant_id)){
                session()->flash('error','درگاه پرداخت آیدی پی فعال نیست! درصورت وجود مشکل با مدیر سایت تماس بگیرید!');
                return redirect()->back();
            }
            $config = [
                'merchantId' => $settings->idpay_merchant_id,
                'callbackUrl' => $callbackUrl,
                'description' => $paymentDescription,
                'sandbox' => $sandbox,
            ];

        }elseif ($driverName == 'parsian'){
            $callbackUrl = env('APP_URL') .  env('PARSIAN_CALLBACK_URL');

            // check parsian settings
            if(empty($settings->parsian_pin_code)){
                session()->flash('error','درگاه پرداخت پارسیان فعال نیست! درصورت وجود مشکل با مدیر سایت تماس بگیرید!');
                return redirect()->back();
            }
            $config = [
                'merchantId' => $settings->parsian_pin_code,
                'callbackUrl' => $callbackUrl,
                'description' => $paymentDescription,
                'sandbox' => $sandbox,
            ];

        }elseif ($driverName == 'mellat' || $driverName == 'behpardakht'){
            $driverName = 'behpardakht';
            $callbackUrl = env('APP_URL') .  env('MELLAT_CALLBACK_URL');

            // check mellat settings
            if(empty($settings->mellat_payane) || empty($settings->mellat_username) || empty($settings->mellat_password)){
                session()->flash('error','درگاه پرداخت ملت فعال نیست! درصورت وجود مشکل با مدیر سایت تماس بگیرید!');
                return redirect()->back();
            }
            $config = [
                'terminalId' => $settings->mellat_payane,
                'username' => $settings->mellat_username,
                'password' => $settings->mellat_password,
                'callbackUrl' => $callbackUrl,
                'description' => $paymentDescription,
                'sandbox' => $sandbox,
            ];

        }else{
            session()->flash('error','درگاه پرداخت انتخابی معتبر نیست!');
            return redirect()->back();
        }

        return Payment::via($driverName)->config($config)->purchase(
            (new Invoice)->amount($amount),
            function($driver, $transactionId) use ($amount,$user,$driverName,$type){
                $paymentModel = new UserPayment();
                $paymentModel->user_id = $user->id;
                $paymentModel->resnumber = "$transactionId";
                $paymentModel->amount = $amount;
                $paymentModel->gateway = $driverName;
                $paymentModel->type = $type;
                $paymentModel->save();
            }
        )->pay()->render();
    }

    public function zarinpalCallback(Request $request){
        if($request->Status == 'OK'){
            $resnumber = $request->Authority;
            return $this->afterSuccessPayment($resnumber);
        }else{
            session()->flash('error','پرداخت انجام نشد!');
            return redirect()->route('panel.wallet');
        }
    }

    public function zibalCallback(Request $request){
        if($request->success == 1){
            $resnumber = $request->trackId;
            return $this->afterSuccessPayment($resnumber);
        }else{
            session()->flash('error','پرداخت انجام نشد!');
            return redirect()->route('panel.wallet');
        }
    }

    public function nextpayCallback(Request $request){
        if(isset($request->np_status) && $request->np_status == "OK"){
            $resnumber = $request->order_id;
            return $this->afterSuccessPayment($resnumber);
        }else{
            session()->flash('error','پرداخت انجام نشد!');
            return redirect()->route('panel.wallet');
        }
    }

    public function idpayCallback(Request $request){
        if($request->status == '10'){
            $resnumber = $request->id;
            return $this->afterSuccessPayment($resnumber);
        }else{
            session()->flash('error','پرداخت انجام نشد!');
            return redirect()->route('panel.wallet');
        }
    }

    public function parsianCallback(Request $request){
        if(isset($request->status) && $request->status == '0' && isset($request->Token)){
            $resnumber = $request->Token;
            return $this->afterSuccessPayment($resnumber);
        }else{
            session()->flash('error','پرداخت انجام نشد!');
            return redirect()->route('panel.wallet');
        }
    }

    public function mellatCallback(Request $request){
        // return $request;
        if(isset($request->ResCode) && $request->ResCode == '0' && isset($request->RefId)){
            $resnumber = $request->RefId;
            return $this->afterSuccessPayment($resnumber);
        }else{
            session()->flash('error','پرداخت انجام نشد!');
            return redirect()->route('panel.wallet');
        }
    }

    public function afterSuccessPayment($resnumber){
        $userPayment = UserPayment::where('user_id',auth()->id())
            ->where('resnumber',$resnumber)->first();
        if ($userPayment){
            $driverName = $userPayment->gateway;

            // get payment settings from database
            $settings = PaymentSetting::first();
            $sandbox = $settings->sandbox;
            $paymentDescription = $settings->payment_description;
            if ($driverName == 'zarinpal'){
                $callbackUrl = env('APP_URL') .  env('ZARINPAL_CALLBACK_URL');
                $config = [
                    'mode' => $sandbox ? 'sandbox' : 'normal',
                    'merchantId' => $settings->zarinpal_merchant_id,
                    'callbackUrl' => $callbackUrl,
                    'description' => $paymentDescription,
                ];

            }elseif ($driverName == 'idpay'){
                $callbackUrl = env('APP_URL') .  env('IDPAY_CALLBACK_URL');
                $config = [
                    'merchantId' => $settings->idpay_merchant_id,
                    'callbackUrl' => $callbackUrl,
                    'description' => $paymentDescription,
                    'sandbox' => $sandbox,
                ];
            }elseif ($driverName == 'zibal'){
                $callbackUrl = env('APP_URL') .  env('ZIBAL_CALLBACK_URL');
                $config = [
                    'merchantId' => $settings->zibal_merchant_id,
                    'callbackUrl' => $callbackUrl,
                    'description' => $paymentDescription,
                    'sandbox' => $sandbox,
                ];
            }elseif ($driverName == 'nextpay'){
                $callbackUrl = env('APP_URL') .  env('NEXTPAY_CALLBACK_URL');
                $config = [
                    'merchantId' => $settings->nextpay_merchant_id,
                    'callbackUrl' => $callbackUrl,
                    'description' => $paymentDescription,
                    'sandbox' => $sandbox,
                ];
            }elseif ($driverName == 'parsian'){
                $callbackUrl = env('APP_URL') .  env('PARSIAN_CALLBACK_URL');
                $config = [
                    'merchantId' => $settings->parsian_pin_code,
                    'callbackUrl' => $callbackUrl,
                    'description' => $paymentDescription,
                    'sandbox' => $sandbox,
                ];
            }elseif ($driverName == 'mellat' || $driverName == 'behpardakht'){
                $callbackUrl = env('APP_URL') .  env('MELLAT_CALLBACK_URL');
                $config = [
                    'terminalId' => $settings->mellat_payane,
                    'username' => $settings->mellat_username,
                    'password' =>$settings->mellat_password,
                    'callbackUrl' => $callbackUrl,
                    'description' => $paymentDescription,
                    'sandbox' => $sandbox,
                ];
            }else{
                session()->flash('error','درگاه پرداخت بازگشتی معتبر نیست!');
                return redirect(route('panel.wallet'));
            }

            // verify payment
            try {
                $receipt = Payment::via($driverName)->config($config)
                    ->amount($userPayment->amount)->transactionId($resnumber)->verify();

                // update payment record
                $userPayment->update([
                    'status' => 'success',
                    'tracking_code' => $receipt->getReferenceId()
                ]);

                // deposit to user
                auth()->user()->wallet->deposit($userPayment->amount);
                session()->flash('success','کیف پول شما به مبلغ '.number_format($userPayment->amount).' تومان با موفقیت شارژ شد!');

            } catch (InvalidPaymentException $exception) {
                session()->flash('error',$exception->getMessage());
            }

        }else{
            session()->flash('error','رکورد پرداخت یافت نشد!');
        }
        return redirect()->route('panel.wallet');

    }

}

