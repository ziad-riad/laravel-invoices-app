<?php

namespace App\Http\Middleware;
use App\User;
use Closure;

class Ensurelogin
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
    
        return $next($request);
    }
}
