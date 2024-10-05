<?php

namespace Modules\Pages\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model implements Viewable
{
    use InteractsWithViews, Sluggable ,SoftDeletes;

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
    public function getRouteKeyName()
    {
        return 'slug';
    }


    protected $fillable = [
        'title',
        'slug',
        'image',
        'body',
        'status',
        'video_link',
        'h1_hidden',
        'nav_title',
        'meta_description',
        'meta_index',
        'canonical',
        'title_tag',
        'image_alt',
        'faq',
        'sidebar'
    ];

    protected $casts = [
        'image' => 'array',
        'faq' => 'array'
    ];


    public function getImage($size = 'original'){

        if ($this->image == null || $this->image == ""){
            return asset('images/default.jpg');
        }
        return '/storage'.$this->image[$size];
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function getSeoTitle(){
        return $this->title_tag == null || $this->title_tag == '' ? $this->title : $this->title_tag;
    }
}
