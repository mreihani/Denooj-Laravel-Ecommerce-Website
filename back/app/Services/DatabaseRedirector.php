<?php

namespace App\Services;

use Modules\Redirects\Entities\Redirect;
use Spatie\MissingPageRedirector\Redirector\Redirector;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Cache;

class DatabaseRedirector implements Redirector
{
    public function getRedirectsFor(Request $request): array
    {
        // Get from the database and remember forever
        // we clear this on new model or updated model
        $dbRedirects = Cache::rememberForever('redirect_cache_routes', function () {
            return Redirect::all()->flatMap(function ($redirect) {
                return [$redirect->old_url => [$redirect->new_url,$redirect->type]];
            })->toArray();
        });

        // Get the redirects from the config
        $configRedirects = config('missing-page-redirector.redirects');

        // Merge both values
        return array_merge($dbRedirects, $configRedirects);
    }
}
