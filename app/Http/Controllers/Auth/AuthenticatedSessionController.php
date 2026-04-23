<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // ADMIN
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // CEK STATUS ALUMNI
        if ($user->status === 'pending') {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['login' => 'Akun kamu masih menunggu verifikasi admin.']);
        }

        if ($user->status === 'rejected') {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['login' => 'Akun kamu ditolak. Hubungi admin untuk informasi lebih lanjut.']);
        }

        // ALUMNI APPROVED
        return redirect()->route('dashboard');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}