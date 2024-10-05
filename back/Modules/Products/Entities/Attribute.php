<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = ['code','label','frontend_type','filterable','required'];

    public function categories(){
        return $this->belongsToMany(AttributeCategory::class,'attribute_category','attribute_id','attribute_category_id');
    }

    public function values(){
        return $this->hasMany(AttributeValue::class,'attribute_id');
    }
}
