<?php

namespace App\Http\Middleware;

use Closure;

class Receptionist
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
        if (auth()->user()->isReceptionist) {
            return $next($request);
        }
        return abort(403, 'Only administrators can access this page');
    }
}
