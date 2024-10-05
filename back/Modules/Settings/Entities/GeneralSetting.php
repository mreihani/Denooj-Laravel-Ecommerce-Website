<?php

namespace Modules\Settings\Entities;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $fillable = [
        'instagram',
        'twitter',
        'linkedin',
        'youtube',
        'pinterest',
        'telegram',
        'facebook',
        'whatsapp',
        'home_h1_hidden',
        'home_nav_title',
        'home_meta_description',
        'home_canonical',
        'home_title_tag',
        'home_seo_description',
        'home_og_image',
        'home_og_image_width',
        'home_og_image_height',
        'home_og_video',
        'home_faq',
        'display_whatsapp_btn',
        'display_call_btn',
        'whatsapp_btn_title',
        'whatsapp_btn_number',
        'call_btn_title',
        'call_btn_number',
        'comment_text',
        'verified',
        'username',
        'order_id',
        'page_404_title',
        'page_404_image',
        'maintenance_mode'
    ];

    protected $casts = [
        'home_faq' => 'array'
    ];

    public function get404Image(){
        if ($this->page_404_image == null || $this->page_404_image == ""){
            return asset('images/404.webp');
        }
        return $this->page_404_image;
    }
}
