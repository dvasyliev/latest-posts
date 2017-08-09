<?php

namespace App\Http\Middleware;

use Closure;
use Facebook\Facebook;

class FacebookUserAuthenticated
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
        echo 'run Middleware<br>';
        return $next($request);
    }
}
