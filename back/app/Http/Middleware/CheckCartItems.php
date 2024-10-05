<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckCartItems
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $items = cart()->getContent();
        if ($items->count() > 0) {
            return $next($request);
        }
        return redirect(route('cart'));
    }
}
