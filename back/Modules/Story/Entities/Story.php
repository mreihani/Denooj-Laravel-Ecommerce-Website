<?php

namespace Modules\Story\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Products\Entities\Product;

class Story extends Model
{
    protected $fillable = [
        'author_id',
        'title',
        'thumbnail',
        'type',
        'status',
        'image_url',
        'video_url',
        'show_button',
        'button_text',
        'button_link',
        'description'
    ];

    public function getThumbnail(){
        if ($this->thumbnail == null || $this->thumbnail == ""){
            return asset('images/default.jpg');
        }
        return $this->thumbnail;
    }

    public function getImage(){
        if ($this->image_url == null || $this->image_url == ""){
            return asset('admin/assets/img/backgrounds/1.jpg');
        }
        return $this->image_url;
    }

    public function products(){
        return $this->belongsToMany(Product::class,'story_product','story_id','product_id');
    }

}
