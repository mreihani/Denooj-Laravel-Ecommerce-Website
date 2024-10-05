<?php

namespace Modules\Coupons\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Users\Entities\User;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'percent',
        'amount',
        'expire_at',
        'shop_id',
        'max_usage',
        'min_price',
        'infinite'
    ];

    public function users(){
        return $this->belongsToMany(User::class,'user_coupon');
    }

    public function isExpired(){
        $now = Carbon::now();
        $expire = Carbon::make($this->expire_at);
        if ($expire < $now) {
            return true;
        }
        return false;
    }
}
