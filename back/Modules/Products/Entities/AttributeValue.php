<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $fillable = ['value','attribute_id'];

    public function attribute(){
        return $this->belongsTo(Attribute::class,'attribute_id');
    }
}
