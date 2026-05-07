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
        if (Auth::check()) {
            $user = Auth::user();
            
            // Admin selalu bisa akses
            if ($user->role === 'admin') {
                return $next($request);
            }
            
            // Cek status user (gunakan kolom 'status')
            $status = $user->status ?? 'pending';
            
            if ($status === 'pending') {
                Auth::logout();
                return redirect()->route('login')->with('error', 
                    "Akun Anda masih menunggu verifikasi admin. Silakan hubungi admin untuk informasi lebih lanjut."
                );
            }
            
            if ($status === 'rejected') {
                Auth::logout();
                $reason = $user->rejection_reason ? " Alasan: {$user->rejection_reason}" : '';
                return redirect()->route('login')->with('error', 
                    "Akun Anda ditolak oleh admin.{$reason} Silakan hubungi admin."
                );
            }
        }
        
        return $next($request);
    }
}