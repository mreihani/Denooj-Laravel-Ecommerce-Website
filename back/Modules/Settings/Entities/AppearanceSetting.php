<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class AppearanceSetting extends Model
{
    protected $fillable = [
        'main_color',
        'main_color_rgb',
        'secondary_color',
        'secondary_color_rgb',
        'link_color',
        'link_color_rgb',
        'call_button_color',
        'whatsapp_button_color',
        'featured_products_title',
        'featured_products_source',
        'featured_products_title_icon',
        'featured_products_count',
        'featured_products_items',
        'featured_products_items_tablet',
        'featured_products_items_mobile',
        'featured_products_btn_link',
        'featured_products_bg_color',
        'featured_products_title_color',
        'featured_products_title_icon_color',
        'featured_products_title_icon_bg_color',
        'featured_products_arrows_color',
        'featured_products_arrows_icon_color',
        'featured_products_arrows_icon_color',
        'featured_products_btn_color',
        'home_blog_title',
        'home_blog_btn_text',
        'home_blog_bg_color',
        'home_blog_title_color',
        'home_blog_btn_color',
        'admin_logo',
        'admin_signin_logo',
        'favicon',
        'site_font',
        'home_template'
    ];

    public function getAdminLogo(){
        if ($this->admin_logo == null || $this->admin_logo == ""){
            return asset('admin/assets/img/branding/logo.png');
        }
        return $this->admin_logo;
    }

    public function getAdminSigninLogo(){
        if ($this->admin_signin_logo == null || $this->admin_signin_logo == ""){
            return asset('admin/assets/img/branding/logo.png');
        }
        return $this->admin_signin_logo;
    }

    public function getFavicon(){
        if ($this->favicon == null || $this->favicon == ""){
            return asset('assets/images/favicon.png');
        }
        return $this->favicon;
    }
}
