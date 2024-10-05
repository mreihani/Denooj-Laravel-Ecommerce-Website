<?php

namespace Modules\MenuBuilder\Entities;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'title',
        'locations'
    ];

    protected $casts = [
        'locations' => 'array'
    ];

    public function hasLocation($location){
        if ($this->locations != null){
            return in_array(trim($location), $this->locations);
        }
        return false;
    }

    public function scopeLocation($query, $location)
    {
        return $query->where('locations', 'like', "%\"{$location}\"%");
    }


    public function items(){
        return $this->hasMany(MenuItem::class)->orderBy('order','asc');
    }
}
