<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->status !== 'approved') {
            Auth::logout();
            
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda belum di-approve oleh admin.',
            ]);
        }
        
        return $next($request);
    }
}