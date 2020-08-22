<?php

namespace App\Http\Middleware;

use Closure;

class setToken
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
        if($token = $request->get('token')){
            $request->header('Authorization','Bearer '.$token);
        }
        return $next($request);
    }
}
