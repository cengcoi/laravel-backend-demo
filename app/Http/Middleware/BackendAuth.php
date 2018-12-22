<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * 后台认证中间件
 * Class BackendAuth
 * @package App\Http\Middleware
 */
class BackendAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if(!Auth::check()){
            return redirect('login');
        }

        return $next($request);
    }
}

