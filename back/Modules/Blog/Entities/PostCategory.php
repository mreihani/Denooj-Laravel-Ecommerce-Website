<?php

namespace Modules\Blog\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model implements Viewable
{
    use Sluggable,InteractsWithViews;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $casts = [
        'faq' => 'array'
    ];

    protected $fillable = [
        'id',
        'parent_id',
        'title',
        'image',
        'slug',
        'featured',
        'h1_hidden',
        'nav_title',
        'meta_description',
        'meta_index',
        'canonical',
        'title_tag',
        'image_alt',
        'seo_description',
        'faq'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'unique' => true,
                'onUpdate' => false,
                'includeTrashed' => true
            ]
        ];
    }

    public function getImage(){
        if ($this->image == null || $this->image == ""){
            return asset('images/default.jpg');
        }
        return '/storage' .$this->image;
    }

    public function parent(){
        return $this->belongsTo(PostCategory::class,'parent_id');
    }

    public function subCategories(){
        return $this->hasMany(PostCategory::class,'parent_id');
    }

    public function posts(){
        return $this->belongsToMany(Post::class,'post_category','category_id','post_id');
    }

    public function getSeoTitle(){
        return $this->title_tag == null || $this->title_tag == '' ? $this->title : $this->title_tag;
    }
}
