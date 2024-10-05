<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    protected $fillable = [
        'footer_logo',
        'footer_about_text',
        'footer_address',
        'footer_email',
        'footer_phone',
        'footer_copyright',
        'footer_designer',
        'footer_icon1',
        'footer_icon2',
        'footer_icon3',
        'footer_icon4',
        'footer_icon1_title',
        'footer_icon2_title',
        'footer_icon3_title',
        'footer_icon4_title',
        'footer_box1_title',
        'footer_box2_title',
        'footer_box3_title',
        'footer_box4_title',
        'footer_social_title',
        'footer_html',
        'working_hours'
    ];

    public function getFooterLogo(){
        if ($this->footer_logo == null || $this->footer_logo == ""){
            return asset('admin/assets/img/branding/logo.png');
        }
        return $this->footer_logo;
    }

    public function getIcon1(){
        if ($this->footer_icon1 == null || $this->footer_icon1 == ""){
            return asset('admin/assets/img/icons/unicons/cube-secondary.png');
        }
        return $this->footer_icon1;
    }

    public function getIcon2(){
        if ($this->footer_icon2 == null || $this->footer_icon2 == ""){
            return asset('admin/assets/img/icons/unicons/cube-secondary.png');
        }
        return $this->footer_icon2;
    }


    public function getIcon3(){
        if ($this->footer_icon3 == null || $this->footer_icon3 == ""){
            return asset('admin/assets/img/icons/unicons/cube-secondary.png');
        }
        return $this->footer_icon3;
    }

    public function getIcon4(){
        if ($this->footer_icon4 == null || $this->footer_icon4 == ""){
            return asset('admin/assets/img/icons/unicons/cube-secondary.png');
        }
        return $this->footer_icon4;
    }
}
