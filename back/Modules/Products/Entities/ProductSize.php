<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'label',
        'name'
    ];
}
