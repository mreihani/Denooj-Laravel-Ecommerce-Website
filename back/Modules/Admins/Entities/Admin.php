<?php

namespace Modules\Admins\Entities;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Blog\Entities\Post;
use Modules\Products\Entities\Product;
use Modules\Questions\Entities\Question;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasRoles, Notifiable;
    protected $guard = "admin";

    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'avatar',
        'bio',
        'instagram',
        'youtube',
        'telegram',
        'twitter',
        'facebook',
        'linkedin',
        'dribbble',
        'pinterest',
        'soundcloud',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAvatar(){
        if ($this->avatar == null || $this->avatar == ""){
            return asset('admin/assets/img/avatars/1.png');
        }
        return '/storage'.$this->avatar;
    }

    public function posts(){
        return $this->hasMany(Post::class,'author_id');
    }

    public function products(){
        return $this->hasMany(Product::class,'author_id');
    }

    public function questions(){
        return $this->hasMany(Question::class,'admin_id');
    }
}
