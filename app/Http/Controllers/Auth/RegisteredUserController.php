<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'string', 'max:20', 'unique:users'],
            'prodi' => ['required', 'string', 'max:50'],
            'angkatan' => ['required', 'digits:4'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Cek NIM + nama + prodi + angkatan cocok di alumni table
        $alumni = Alumni::where('nim', $request->nim)
            ->whereRaw('LOWER(nama) = ?', [strtolower($request->name)])
            ->where('prodi', $request->prodi)
            ->where('angkatan', $request->angkatan)
            ->first();

        if (!$alumni) {
            return back()
                ->withInput()
                ->withErrors(['nim' => 'Data tidak ditemukan. Pastikan NIM, nama, prodi, dan angkatan sesuai data kelulusan.']);
        }

        // Cek alumni belum punya akun
        if ($alumni->user_id) {
            return back()
                ->withInput()
                ->withErrors(['nim' => 'NIM ini sudah terdaftar. Silakan login atau hubungi admin.']);
        }

        $user = User::create([
            'name' => $request->name,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'angkatan' => $request->angkatan,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'alumni',
            'status' => 'pending',
            'alumni_id' => $alumni->id,
        ]);

        // Link alumni ke user
        $alumni->update(['user_id' => $user->id]);

        event(new Registered($user));
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Akun kamu sedang menunggu verifikasi admin.');
    }
}