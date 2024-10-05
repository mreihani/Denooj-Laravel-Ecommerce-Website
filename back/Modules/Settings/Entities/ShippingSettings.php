<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class ShippingSettings extends Model
{
    protected $fillable = [
        'tipax',
        'tipax_title',
        'tipax_logo',

        'post_pishtaz',
        'post_pishtaz_title',
        'post_pishtaz_logo',
        'cost_post_pishtaz',
        'cost_post_pishtaz_kilogram',

        'bike',
        'bike_title',
        'bike_logo',
        'cost_bike',
        'bike_cities',
        'cost_bike_kilogram',

        'free_shipping_limit',

        'freightage',
        'post',
        'freightage_title',
        'freightage_logo',
        'post_title',
        'post_logo',
        'post_cost_five',
        'post_cost_ten',
        'post_cost_twenty',
        'post_cost_off_five',
        'post_cost_off_ten',
        'post_cost_off_twenty'
    ];

    protected $casts = [
        'bike_cities' => 'array'
    ];

    public function getTipaxLogo(){
        if ($this->tipax_logo == null || $this->tipax_logo == ""){
            return asset('assets/images/tipax.png');
        }
        return $this->tipax_logo;
    }

    public function getPishtazLogo(){
        if ($this->post_pishtaz_logo == null || $this->post_pishtaz_logo == ""){
            return asset('assets/images/post_pishtaz.png');
        }
        return $this->post_pishtaz_logo;
    }

    public function getBikeLogo(){
        if ($this->bike_logo == null || $this->bike_logo == ""){
            return asset('assets/images/bike.jpg');
        }
        return $this->bike_logo;
    }

    public function getFreightageLogo(){
        if ($this->freightage_logo == null || $this->freightage_logo == ""){
            return asset('assets/images/tipax.png');
        }
        return $this->freightage_logo;
    }

    public function getPostLogo(){
        if ($this->post_logo == null || $this->post_logo == ""){
            return asset('assets/images/post_pishtaz.png');
        }
        return $this->post_logo;
    }
}
