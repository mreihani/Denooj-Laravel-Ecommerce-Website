<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class SigninSetting extends Model
{
    protected $fillable = [
        'title',
        'logo',
        'image',
        'bg_color'
    ];

    public function getLogo(){

        if ($this->logo == null || $this->logo == ""){
            return asset('assets/images/logo.png');
        }
        return $this->logo;
    }

    public function getImage(){

        if ($this->image == null || $this->image == ""){
            return asset('assets/images/signin_image.jpg');
        }
        return $this->image;
    }
}
