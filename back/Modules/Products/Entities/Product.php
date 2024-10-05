<?php

namespace Modules\Products\Entities;

use Conner\Likeable\Likeable;
use Cviebrock\EloquentSluggable\Sluggable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Modules\Admins\Entities\Admin;
use Modules\Comments\Entities\Comment;
use Modules\Orders\Entities\Order;
use Modules\Questions\Entities\Question;
use Modules\Users\Entities\User;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Tags\HasTags;

class Product extends Model implements Searchable,Viewable
{
    use Sluggable, SoftDeletes,InteractsWithViews , HasTags , Likeable;

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

    public function getLinkAttribute()
    {
        return url('product/' . $this->slug);
    }

    public function getFinalPriceAttribute()
    {
        if ($this->product_type == 'simple'){
            return $this->getFinalPrice();
        }
        return $this->getMinPrice() . ' - ' . $this->getMaxPrice();
    }

    public function getInStockAttribute()
    {
        return $this->inStock();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $appends = [
        'link','final_price','in_stock'
    ];

    protected $casts = [
        'image' => 'array',
        'images' => 'array',
        'attributes' => 'array',
        'total_attributes' => 'array',
        'faq' => 'array'
    ];

    protected $fillable = [
        'id',
        'code',
        'author_id',
        'sku',
        'label',
        'title',
        'title_latin',
        'torob_title',
        'slug',
        'short_description',
        'image',
        'images',
        'body',
        'manage_stock',
        'stock',
        'stock_status',
        'price',
        'sale_price',
        'discount_percent',
        'status',
        'recommended',
        'sell_count',
        'attributes',
        'total_attributes',
        'copy_from',
        'h1_hidden',
        'nav_title',
        'meta_description',
        'meta_index',
        'canonical',
        'title_tag',
        'image_alt',
        'faq',
        'product_type',
        'variation_type',
        'cart_button_link',
        'cart_button_text',
        'display_comments',
        'display_questions',
        'extra_shipping_cost',
        'weight',
        'shipping_time'
    ];

    // relations

    public function author(){
        return $this->belongsTo(Admin::class,'author_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class,'product_category','product_id','category_id');
    }

    public function questions(){
        return $this->hasMany(Question::class,'model_id')->where('parent_id',null)->latest();
    }

    public function getMainCategory(){
        $main = $this->categories()->where('parent_id',null)->first();
        if (!$main){
            return $this->categories()->first();
        }
        return $main;
    }


    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function inventories()
    {
        return $this->hasMany(ProductInventory::class,'product_id');
    }


    // variation functions

    public function getInventoryType()
    {
        $type = "single";
        $hasColor = false;
        $hasSize = false;
        if ($this->inventories->where('color_id', '!=', null)->count() > 0) {
            $hasColor = true;
        }
        if ($this->inventories->where('size_id', '!=', null)->count() > 0) {
            $hasSize = true;
        }

        if ($hasColor && !$hasSize) {
            $type = "color";
        } elseif (!$hasColor && $hasSize) {
            $type = "size";
        } elseif ($hasColor && $hasSize) {
            $type = "color_size";
        }
        return $type;
    }

    public function getInventoryColors()
    {
        return array_unique(array_values($this->inventories->pluck('color_id')->toArray()));
    }

    public function getInventorySizes()
    {
        return array_unique(array_values($this->inventories->pluck('size_id')->toArray()));
    }

    public function inStock()
    {
        if ($this->product_type == 'simple'){
            return $this->getStockStatus() == 'in_stock';
        }else{
            return $this->inventories()->where([
                ['manage_stock', 1],
                ['stock', '>', 0]
            ])
                ->orWhere([
                    ['product_id',$this->id],
                    ['manage_stock', 0],
                    ['stock_status', 'in_stock']
                ])->count() > 0;
        }
    }


    // getters

    public function getColorsAttribute()
    {
        $ids = array_unique(array_values($this->inventories()->where('stock','>',0)->pluck('color_id')->toArray()));
        return ProductColor::whereIn('id', $ids)->get();
    }

    public function getSizesAttribute()
    {
        $ids = array_unique(array_values($this->inventories()->where('stock','>',0)->pluck('size_id')->toArray()));
        return ProductSize::whereIn('id', $ids)->get(['id', 'name']);
    }

    public function getColors()
    {
        $ids = array_unique(array_values($this->inventories->pluck('color_id')->toArray()));
        return ProductColor::whereIn('id', $ids)->get();
    }

    public function getSizes()
    {
        $ids = array_unique(array_values($this->inventories->pluck('size_id')->toArray()));
        return ProductSize::whereIn('id', $ids)->get();
    }

    public function getImage($size = 'original'){

        if ($this->image == null || $this->image == ""){
            return asset('assets/images/no_image.jpg');
        }
        return '/storage'.$this->image[$size];
    }

    public function getStockStatus(){
        if ($this->manage_stock){
            if ($this->stock > 0){
                return 'in_stock';
            }
            return 'out_of_stock';
        }
        return $this->stock_status;
    }

    public function getDisplayStock(){
        return $this->inStock() ? 'موجود در انبار' : 'ناموجود';
    }

    public function getStockQuantity($inventoryId = null){
        if ($this->product_type == 'simple'){
            if ($this->manage_stock){
                return $this->stock;
            }else if ($this->stock_status == 'out_of_stock'){
                return 0;
            }
            return 99999999999;
        }else{
            if ($inventoryId){
                $inventory = ProductInventory::find($inventoryId);
                if (!$inventory) return 0;
                if ($inventory->manage_stock){
                    return $inventory->stock;
                }else if ($inventory->stock_status == 'out_of_stock'){
                    return 0;
                }
                return 99999999999;
            }else{
                return 0;
            }
        }

    }

    public function getPriceHtml($classes = '',$admin = false){
        $html = "<div class='d-flex flex-column align-items-start product-price-container $classes'>";

        if (!$this->inStock()){
            $html .= "<span class='text-danger d-none d-lg-block'>".$this->getDisplayStock()."</span>";

        }else{
            if ($this->product_type == 'simple'){
                $class = $this->sale_price ? ($admin ? 'text-decoration-line-through' : 'dash-on') : '';
                $unit = $this->sale_price ? '' : ' تومان';
                $html .= "<span class='price me-2 $class'>". number_format($this->price) . $unit ."</span>";
                if ($this->sale_price){
                    $class1 = $admin ? 'align-items-start' : 'align-items-end';
                    $html .=
                        "<div class='d-flex w-100 justify-content-between $class1'>" .
                            "<span class='price color-green fw-800'>".number_format($this->sale_price) . ' تومان'."</span>" .
                            "<span class='bg-danger text-white rounded px-2 pt-1 ms-3 font-12'>%".$this->discount_percent."</span>".
                        "</div>";
                }

            }else{
                // variation product price
                $minPrice = $this->getMinPrice();
                $maxPrice = $this->getMaxPrice();
                if($minPrice == $maxPrice){
                    $html .= "<span class='price me-2'>شروع از " . number_format($this->getMaxPrice()) . " تومان" ."</span>";

                }else{
                    $html .= "<span class='price me-2'>". number_format($this->getMinPrice()) ." - ". number_format($this->getMaxPrice()) . " تومان" ."</span>";
                }
            }
        }

        $html .= "</div>";
        return $html;
    }

    public function getMinPrice(){
        $array = [];
        foreach ($this->inventories as $inventory) {
            if ($inventory->sale_price) array_push($array,$inventory->sale_price);
                else array_push($array,$inventory->price);
        }
        return min($array);
//        return $this->inventories()->min('price');
    }

    public function getMaxPrice(){
        $array = [];
        foreach ($this->inventories as $inventory) {
            if ($inventory->sale_price) array_push($array,$inventory->sale_price);
            else array_push($array,$inventory->price);
        }
        return max($array);
//        return $this->inventories()->max('price');
    }

    public function getDiscountedPrice($inventoryId = null){
        if ($this->product_type == 'simple'){
            if ($this->sale_price == null || $this->discount_percent == null || intval($this->discount_percent) < 1){
                return 0;
            }
            return intval($this->price) - intval($this->sale_price);
        }

        // variation product
        if ($inventoryId != null){
            $inventory = ProductInventory::find($inventoryId);
            if ($inventory){
                if ($inventory->sale_price == null || $inventory->discount_percent == null || intval($inventory->discount_percent) < 1){
                    return 0;
                }
                return intval($inventory->price) - intval($inventory->sale_price);
            }
        }
        return 99999999;

    }

    public function getFinalPrice($inventoryId = null){
        if ($this->product_type == 'simple'){
            $salePrice = intval($this->sale_price);
            if ($this->sale_price == null || $salePrice < 1){
                return $this->price;
            }
            return $salePrice;
        }else{
            $inventory = ProductInventory::find($inventoryId);
            if ($inventory){
                $salePrice = intval($inventory->sale_price);
                if ($inventory->sale_price == null || $salePrice < 1){
                    return $inventory->price;
                }
                return $salePrice;
            }
            return 0;
        }
    }

    public function hasAttribute($attrCode){
        $attrs = array_filter(
            $this['attributes'],
            function($obj) use ($attrCode){
                return $obj['code'] === $attrCode;
            });
        return count($attrs) > 0;
    }

    public function hasTotalAttribute($attrCode){
        $attrs = array_filter(
            $this->total_attributes,
            function($obj) use ($attrCode){
                return $obj['code'] === $attrCode;
            });
        return count($attrs) > 0;
    }

    public function income()
    {
        $orders = DB::table('order_items')->where('product_id', '=', $this->id)->get(['quantity', 'price']);
        $totalPrice = 0;
        foreach ($orders as $order) {
            $totalPrice += $order->quantity * $order->price;
        }
        return $totalPrice;
    }

    public function getAverageRating(){
        $avg = $this->comments->where('status','published')->avg('score');
        $avg = number_format((float)$avg, 1, '.', '');
        return ($avg == 0) ? 5 : $avg ;
    }

    // scopes

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeHasDiscount($query)
    {
        return $query
            ->where([
                ['product_type' ,'=', 'simple'],
                ['sale_price' ,'!=', null],
                ['sale_price' ,'!=', '0'],
            ])
            ->orWhere(function (Builder $query){
                $query->where('product_type' ,'=', 'variation')
                    ->whereHas('inventories', function ($query)  {
                        return $query->where('sale_price', '!=', null)
                            ->where('sale_price', '!=', '0');
                    });
            });
    }


    public function scopeAvailable($query)
    {
        return $query
            ->where([
                ['product_type' ,'=', 'simple'],
                ['manage_stock', '=', true],
                ['stock', '>', 0]
            ])
            ->orWhere([
                ['product_type' ,'=', 'simple'],
                ['manage_stock', '=', false],
                ['stock_status', '=', 'in_stock'],
            ])
            ->orWhere(function ($query) {
                $query->where('product_type','variation')
                    ->whereHas('inventories', function ($query) {
                    $query->where([
                        ['manage_stock', '=', true],
                        ['stock', '>', 0]
                    ])->orWhere([
                        ['manage_stock', '=', false],
                        ['stock_status', '=', 'in_stock']
                    ]);
                });
            });
    }

    public function scopeRecommended($query)
    {
        return $query->where('recommended', true);
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('product.show', $this);
        return new SearchResult($this, $this->title, $url);
    }

    public function isBoughtByUser($userId){
        $user = User::find($userId);
        $orders = $user->orders()->where('is_paid',true)->with('items')->get();
        $pIds = [];
        foreach ($orders as $order) {
            foreach ($order->items as $product) {
                array_push($pIds,$product->id);
            }
        }
        return in_array($this->id,$pIds);
    }

    public function hasRatedByUser($userId){
        $comments = Comment::where('user_id',$userId)
            ->where('product_id',$this->id)->count();
        return $comments > 0;
    }

    public function getPendingRate($userId){
        return Comment::where('user_id',$userId)
            ->where('product_id',$this->id)->where('status','pending')->first();
    }

    public function getSeoTitle(){
        return $this->title_tag == null || $this->title_tag == '' ? $this->title : $this->title_tag;
    }

}
