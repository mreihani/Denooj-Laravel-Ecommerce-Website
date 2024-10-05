<?php

namespace Modules\Comments\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Blog\Entities\Post;
use Modules\Products\Entities\Product;
use Modules\Users\Entities\User;

class Comment extends Model
{
    protected $fillable =[
        'id',
        'user_id',
        'product_id',
        'post_id',
        'comment',
        'weaknesses',
        'strengths',
        'score',
        'from_buyer',
        'anonymous',
        'status',
        'created_at'
    ];

    protected $casts = [
        'strengths' => 'array',
        'weaknesses' => 'array'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

    public function post(){
        return $this->belongsTo(Post::class,'post_id');
    }

    public function getSenderAvatar(){
        return $this->user->getAvatar(true);
    }

    public function getSenderName(){
        return $this->user->getPublicName();
    }

}
