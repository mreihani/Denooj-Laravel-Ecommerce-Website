<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;

class AttributeCategory extends Model
{
    protected $fillable = [
        'name'
    ];

    public function attributesList(){
        return $this->belongsToMany(Attribute::class,'attribute_category','attribute_category_id','attribute_id')
            ->withPivot('default');;
    }

}
