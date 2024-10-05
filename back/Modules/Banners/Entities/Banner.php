<?php

namespace Modules\Banners\Entities;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'link',
        'image',
        'lg_col',
        'sm_col',
        'col',
        'location',
        'sort',
        'margin_bottom',
        'margin_top'
    ];

    protected $casts = [
        'image' => 'array'
    ];

    public function getImage(){
        if ($this->image == null || $this->image == ""){
            return asset('images/default.jpg');
        }
        return $this->image;
    }
}
