<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $fillable = [
        'zarinpal',
        'idpay',
        'zarinpal_merchant_id',
        'idpay_merchant_id',
        'payment_description',
        'sandbox',
        'default_payment_driver',
        'parsian_pin_code',
        'parsian_pin_code_sandbox',
        'parsian_terminal',
        'mellat_payane',
        'mellat_username',
        'mellat_password',
        'parsian',
        'mellat',
        'zibal',
        'zibal_merchant_id',
        'nextpay',
        'nextpay_merchant_id',
        'pasargad',
        'pasargad_merchant_id',
        'pasargad_terminal'
    ];
}
