<?php

namespace Modules\MenuBuilder\Entities;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'title',
        'link',
        'menu_id',
        'parent_id',
        'order'
    ];

    public function menu(){
        return $this->belongsTo(Menu::class,'menu_id');
    }

    public function parent(){
        return $this->belongsTo(MenuItem::class,'parent_id');
    }

    public function items(){
        return $this->hasMany(MenuItem::class,'parent_id')->orderBy('order');
    }

    public function getDepth(){
        if ($this->parent){
            if ($this->parent->parent){
                if ($this->parent->parent->parent){
                    if ($this->parent->parent->parent->parent){
                        if ($this->parent->parent->parent->parent->parent){
                            return 5;
                        }
                        return 4;
                    }
                    return 3;
                }

                return 2;
            }
            return 1;
        }
        return 0;
    }

}
