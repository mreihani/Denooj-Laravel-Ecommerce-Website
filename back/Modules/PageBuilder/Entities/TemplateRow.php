<?php

namespace Modules\PageBuilder\Entities;

use Illuminate\Database\Eloquent\Model;

class TemplateRow extends Model
{
    protected $fillable = [
        'margin_top',
        'margin_bottom',
        'custom_css',
        'css_id',
        'order',
        'template_id',
        'widget_type',
        'widget_name',
        'widget_icon',
        'layout',

        'stories_stroke_color',
        'stories_shape',
        'stories_show_title',

        'featured_categories_show_count',
        'featured_categories_overlay_color',
        'featured_categories_grid_item_per_row',
        'featured_categories_grid_item_per_row_tablet',
        'featured_categories_grid_item_per_row_mobile',
        'featured_categories_grid_items_count',


        'featured_products_title',
        'featured_products_subtitle',
        'featured_products_title_icon',
        'featured_products_count',
        'featured_products_bg_color',
        'featured_products_title_color',
        'featured_products_title_icon_color',
        'featured_products_title_icon_bg_color',
        'featured_products_arrows_color',
        'featured_products_arrows_icon_color',
        'featured_products_btn_color',
        'featured_products_btn_color_hover',
        'featured_products_btn_link',
        'featured_products_source',
        'featured_products_categories_source',
        'featured_products_available',
        'featured_products_recommended',
        'featured_products_discounted',

        'editor_content',
        'faq'

    ];

    protected $casts = [
        'featured_products_categories_source' => 'array',
        'faq' => 'array'
    ];

    public function template(){
        return $this->belongsTo(Template::class,'template_id');
    }

}
