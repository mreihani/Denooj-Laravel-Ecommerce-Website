<?php

namespace Modules\Redirects\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Redirect extends Model
{
    protected $fillable = [
        'old_url',
        'new_url',
        'type'
    ];

    public static function boot()
    {
        parent::boot();

        static::saved(function () {
            Cache::forget('redirect_cache_routes');
        });
    }
}
