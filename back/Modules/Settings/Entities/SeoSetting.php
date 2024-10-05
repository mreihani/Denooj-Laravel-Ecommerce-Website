<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    protected $fillable = [
        'product_base',
        'category_base',
        'tag_base',
        'post_category_base',
        'post_tag_base',
        'post_base',
        'post_sitemap_inc',
        'post_cat_sitemap_inc',
        'post_tag_sitemap_inc',
        'product_sitemap_inc',
        'product_cat_sitemap_inc',
        'product_tag_sitemap_inc',
        'page_sitemap_inc',
        'site_index',
    ];
}
