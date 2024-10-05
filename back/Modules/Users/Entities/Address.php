<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable= [
        'province','city','post_code','phone','address','default','full_name'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getProvince(){
        return Province::find($this->province);
    }

    public function getCity(){
        return City::find($this->city);
    }
}
