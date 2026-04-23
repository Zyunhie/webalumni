<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check() || trim(Auth::user()->role) !== trim($role)) {
            abort(403, 'Akses ditolak.');
        }
        return $next($request);
    }
}