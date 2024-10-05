<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class HeaderSetting extends Model
{
    protected $fillable = [
        'header_logo',
        'header_search_placeholder',
        'display_header_support',
        'header_support_text',
        'header_support_link',
        'header_support_link_text',
        'header_support_icon',
        'search_recommendation'
    ];

    protected $casts = [
        'search_recommendation' => 'array'
    ];

    public function getHeaderLogo(){
        if ($this->header_logo == null || $this->header_logo == ""){
            return asset('admin/assets/img/branding/logo.png');
        }
        return $this->header_logo;
    }
}
