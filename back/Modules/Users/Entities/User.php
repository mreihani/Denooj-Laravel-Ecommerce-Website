<?php

namespace Modules\Users\Entities;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use MannikJ\Laravel\Wallet\Traits\HasWallet;
use Modules\Comments\Entities\Comment;
use Modules\Coupons\Entities\Coupon;
use Modules\Orders\Entities\Order;
use Modules\Questions\Entities\Question;
use Modules\Tickets\Entities\Ticket;

class User extends Authenticatable
{
    use HasWallet;
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'password',
        'mobile',
        'avatar',
        'national_code',
        'api_token',
        'last_active_at'
    ];

    protected $hidden = [
        'remember_token','password','api_token'
    ];

    protected $casts = [
        'avatar' => 'json'
    ];


    public function mobileToken()
    {
        return $this->hasOne(MobileNumber::class);
    }

    public function addresses(){
        return $this->hasMany(Address::class);
    }

    public function walletPayments(){
        return $this->hasMany(UserPayment::class)->where('type','wallet');
    }

    public function payments(){
        return $this->hasMany(UserPayment::class)->latest();
    }

    public function questions(){
        return $this->hasMany(Question::class)->latest();
    }

    public function orders(){
        return $this->hasMany(Order::class)->latest();
    }

    public function coupons(){
        return $this->belongsToMany(Coupon::class,'user_coupon');
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }


    public function getAvatar($thumb = false){
        if ($this->avatar == null || $this->avatar == ""){
            return asset('admin/assets/img/avatars/1.png');
        }
        if ($thumb) {
            return '/storage'.$this->avatar['thumb'];
        }else{
            return '/storage'.$this->avatar['original'];
        }
    }

    public function getFullName(){
        $fullName = $this->first_name. ' ' .$this->last_name;
        return (strlen($fullName) === 1) ? $this->mobile : $fullName;
    }

    public function getPublicName(){
        $fullName = $this->first_name. ' ' .$this->last_name;
        return (strlen($fullName) === 1) ? 'کاربر بی‌نام' : $fullName;
    }

    public function getCreationDate(){
        return Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans(null,true).' پیش';
    }

    public function getLastActiveAt(){
        if ($this->last_active_at != null){
            $diffInSec = Carbon::createFromTimeStamp(strtotime($this->last_active_at))->diffInSeconds();
            if ($diffInSec < 60){
                return "لحظاتی قبل";
            }elseif($diffInSec > 60 && $diffInSec < 3600){
                return "دقایقی پیش";
            }else{
                return Carbon::createFromTimeStamp(strtotime($this->last_active_at))->diffForHumans(null,true).' قبل';
            }
        }
        return "هرگز";
    }


}

