<?php

namespace Modules\Products\Entities;


use Cviebrock\EloquentSluggable\Sluggable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Category extends Model implements Searchable, Viewable
{
    use Sluggable, InteractsWithViews;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getTypeAttribute(){
        return 'category';
    }

    protected $casts = [
        'faq' => 'array'
    ];

    protected $fillable = [
        'id',
        'title',
        'slug',
        'image',
        'parent_id',
        'featured',
        'featured_index',
        'display_in_home',
        'seo_description',
        'index',
        'home_section_title',
        'section_subtitle',
        'h1_hidden',
        'nav_title',
        'meta_description',
        'meta_index',
        'canonical',
        'title_tag',
        'seo_description',
        'faq'
    ];


    public function parent(){
        return $this->belongsTo(Category::class,'parent_id');
    }

    public function subCategories(){
        return $this->hasMany(Category::class,'parent_id');
    }

    // recursive, loads all descendants
    public function childrenRecursive()
    {
        return $this->subCategories()->with('childrenRecursive');
    }

    public function products(){
        return $this->belongsToMany(Product::class,'product_category','category_id','product_id');
    }

    public function getImage(){
        if ($this->image == null || $this->image == ""){
            return asset('images/default.jpg');
        }
        return '/storage' .$this->image;
    }

    public function getSeoTitle(){
        return $this->title_tag == null || $this->title_tag == '' ? $this->title : $this->title_tag;
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('category.show', $this);
        return new SearchResult($this, $this->title, $url);
    }

    public function getFontEndTitle(){
        if ($this->home_section_title == null) {
            return $this->title;
        }
        return $this->home_section_title;
    }

    public function getAllPublishedProducts(){
        // get category ids
        $categoryIds = $this->subCategories->pluck('id')->push($this->id);
        foreach ($this->subCategories as $subCategory){
            $subCategoryIds = $subCategory->subCategories->pluck('id');
            $categoryIds->push($subCategoryIds);
        }
        $categoryIds =  $categoryIds->flatten();

        return Product::whereHas('categories', function ($query) use ($categoryIds) {
            $query->whereIn('category_id', $categoryIds);
        })->published();
    }
}
