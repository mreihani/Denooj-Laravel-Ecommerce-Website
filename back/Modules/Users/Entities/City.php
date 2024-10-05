<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = false;

    protected $fillable = ['name','province','latitude','longitude'];

    protected $visible = ['id','name'];

    public function getProvince(){
        return $this->belongsTo(Province::class,'province','id');
    }
}



