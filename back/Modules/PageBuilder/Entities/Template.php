<?php

namespace Modules\PageBuilder\Entities;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{

    protected $fillable = [
        'type', 'title'
    ];

    public function rows(){
        return $this->hasMany(TemplateRow::class,'template_id');
    }
}
