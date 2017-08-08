<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RegistryAuth
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

        if (Auth::user()->roles->count() < 2) {
            return redirect('dashboard');
        }

        return $next($request);
    }
}
