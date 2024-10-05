<?php

namespace Modules\Blog\Entities;

use Conner\Likeable\Likeable;
use Cviebrock\EloquentSluggable\Sluggable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Admins\Entities\Admin;
use Modules\Comments\Entities\Comment;
use Spatie\Tags\HasTags;

class Post extends Model implements Viewable
{
    use Sluggable, HasTags,InteractsWithViews, SoftDeletes, Likeable;


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
        'id',
        'author_id',
        'title',
        'excerpt',
        'body',
        'image',
        'slug',
        'status',
        'featured',
        'order',
        'h1_hidden',
        'nav_title',
        'meta_description',
        'meta_index',
        'canonical',
        'title_tag',
        'image_alt',
        'reading_time',
        'faq',
        'sidebar',
        'created_at',
        'updated_at',
        'display_comments',
        'show_thumbnail'
    ];

    protected $casts = [
        'image' => 'array',
        'faq' => 'array'
    ];

    public function getImage($size = 'original'){

        if ($this->image == null || $this->image == ""){
            return asset('assets/images/no_image.jpg');
        }
        return '/storage'.$this->image[$size];
    }

    public function categories(){
        return $this->belongsToMany(PostCategory::class,'post_category','post_id','category_id');
    }

    public function author(){
        return $this->belongsTo(Admin::class,'author_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class,'post_id');
    }

    public function getMainCategory(){
        $main = $this->categories()->where('parent_id',null)->first();
        if (!$main){
            return $this->categories()->first();
        }
        return $main;
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function getSeoTitle(){
        return $this->title_tag == null || $this->title_tag == '' ? $this->title : $this->title_tag;
    }

}
