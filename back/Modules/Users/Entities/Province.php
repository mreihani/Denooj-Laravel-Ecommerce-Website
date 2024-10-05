<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public $timestamps = false;

    protected $fillable = ['name','latitude','longitude'];

    protected $visible = ['id','name','cities'];

    public function cities(){
        return $this->hasMany(City::class,'province');
    }

}
