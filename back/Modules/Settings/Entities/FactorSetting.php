<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class FactorSetting extends Model
{
    protected $fillable = [
        'logo',
        'signature',
        'address',
        'postcode',
        'phone',
        'show_user_factor'
    ];

    public function getLogo(){
        if ($this->logo == null || $this->logo == ""){
            return asset('admin/assets/img/branding/logo.png');
        }
        return $this->logo;
    }

    public function getSignature(){
        if ($this->signature == null || $this->signature == ""){
            return asset('admin/assets/img/branding/logo.png');
        }
        return $this->signature;
    }
}
