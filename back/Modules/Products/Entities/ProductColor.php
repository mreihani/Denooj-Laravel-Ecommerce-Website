<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'label',
        'name',
        'hex_code'
    ];
}
