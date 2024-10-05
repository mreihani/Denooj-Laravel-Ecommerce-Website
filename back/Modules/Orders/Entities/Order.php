<?php

namespace Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Coupons\Entities\Coupon;
use Modules\Products\Entities\Product;
use Modules\Users\Entities\City;
use Modules\Users\Entities\Province;
use Modules\Users\Entities\User;
use Modules\Users\Entities\UserPayment;

class  Order extends Model
{
    public function getRouteKeyName()
    {
        return 'order_number';
    }

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'price',
        'paid_price',
        'is_paid',
        'payment_method',
        'notes',
        'shipping_address',
        'shipping_province',
        'shipping_city',
        'shipping_post_code',
        'shipping_phone',
        'shipping_full_name',
        'shipping_cost',
        'shipping_method',
        'coupons',
        'paid_from_wallet',
        'discount',
        'items_discount',
        'completed_at',
        'created_at',
        'postal_code',
        'sent_at'
    ];

    protected $casts = [
        'coupons' => 'array'
    ];

    public function items()
    {
        return $this->belongsToMany(Product::class, 'order_items','order_id','product_id')
            ->withPivot('quantity','price','color','size');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function payments(){
        return $this->hasMany(UserPayment::class)->latest();
    }

    public function getCoupons(){
        $coupons = [];
        if ($this->coupons){
            foreach ($this->coupons as $couponId) {
                $c = Coupon::find($couponId);
                if ($c) {
                    array_push($coupons,$c);
                }
            }
        }
        return $coupons;
    }

    public function getTotalQuantity(){
        $quantity = 0;
        foreach ($this->items as $product){
            $quantity += $product->pivot->quantity;
        }
        return $quantity;
    }

    public function getProvinceName(){
        $provinve = Province::find($this->shipping_province);
        if ($provinve){
            return $provinve->name;
        }
        return "نامشخص";
    }

    public function getCityName(){
        $city = City::find($this->shipping_city);
        if ($city){
            return $city->name;
        }
        return "نامشخص";
    }

    public function getTotalItemsPrice(){
        $price = 0;
        foreach ($this->items as $item) {
            $price += $item->pivot->price * $item->pivot->quantity;
        }
        return $price;
    }

    public function getTotalPrice(){
        return $this->price + $this->shipping_cost;
    }
}
