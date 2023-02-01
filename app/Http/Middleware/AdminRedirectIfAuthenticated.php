<?php

namespace App\Http\Middleware;

use App\Providers\AdminServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;
use Str;

class AdminRedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Auth::guard(AdminServiceProvider::GUARD)->check()){
            return redirect()->route(AdminServiceProvider::BACKEND_LOGIN_ROUTE, ['key' => Str::random(60)]);
        }
        return $next($request);
    }
}
