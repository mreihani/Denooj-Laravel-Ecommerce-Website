<?php

namespace Modules\Users\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Orders\Entities\Order;

class UserPayment extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'amount',
        'resnumber',
        'status',
        'type',
        'tracking_code',
        'gateway'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function getCreationDate(){
        return Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans(null,true).' پیش';
    }
    public function getGatewayName(){
        $name = '';
        switch ($this->gateway){
            case "zarinpal":
                $name = 'زرین‌پال';
                break;
            case "idpay":
                $name = 'آی‌دی‌پی';
                break;
            case "parsian":
                $name = 'پارسیان';
                break;
            case "mellat":
            case "behpardakht":
                $name = 'به‌پرداخت ملت';
                break;
            case "nextpay":
                $name = 'نکست‌پی';
                break;
            case "zibal":
                $name = 'زیبال';
                break;
            case "bacs":
            $name = 'کارت به کارت';
            break;
        }
        return $name;
    }
}
