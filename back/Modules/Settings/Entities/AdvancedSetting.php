<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class AdvancedSetting extends Model
{
    protected $fillable = [
        'custom_css',
        'custom_js',
        'custom_header_js'
    ];
}
