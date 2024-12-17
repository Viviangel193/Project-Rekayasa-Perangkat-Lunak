<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (Auth::check() && Auth::user()->peran === $role) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Anda tidak memiliki akses!');
    }
}
