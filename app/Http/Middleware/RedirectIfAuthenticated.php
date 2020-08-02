<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // if ($guard == "manager" && Auth::guard($guard)->check()) {
        //     return redirect()->route('seller');
        // }

        if ($guard == "manager" && Auth::guard($guard)->check() && Auth::guard($guard)->user()->role == 1) {
            return redirect()->route('admin');
        }

        if ($guard == "manager" && Auth::guard($guard)->check() && Auth::guard($guard)->user()->role == 0) {
            return redirect()->route('seller');
        }

        if (Auth::guard($guard)->check()) {
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
