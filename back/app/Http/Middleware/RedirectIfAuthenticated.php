<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {

        if (Auth::guard($guard)->check()) {

            if ($guard == "admin") {
                if (auth()->guard('admin')->user()->can('see-dashboard')){
                    return redirect()->route('admin.dashboard');
                }else{
                    return redirect()->route('admin.profile');
                }
            } else {
                //default guard.
                return redirect()->route('home');
            }

        }
        return $next($request);
    }


}
