<?php

namespace App\Http\Middleware;

use Closure;

class SessionAuthMiddleware
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (null !== (app('session')->get('location'))) {
            return $next($request);
        }

        return redirect('/');
    }

}