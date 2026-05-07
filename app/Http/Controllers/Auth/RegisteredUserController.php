<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlumniRegisterRequest;
use App\Models\User;
use App\Models\Alumni;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(AlumniRegisterRequest $request): RedirectResponse
    {
        try {
            Log::info('Registration attempt started', [
                'name' => $request->name,
                'nim' => $request->nim,
                'email' => $request->email,
            ]);

            // Buat user baru
            $user = User::create([
                'alumni_id' => $request->alumni_id,
                'name' => $request->name,
                'nim' => $request->nim,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'alumni',
                'prodi' => $request->prodi,
                'angkatan' => $request->angkatan,
                'status' => 'pending', // Gunakan kolom 'status'
                'is_data_matched' => $request->is_data_matched ?? false,
            ]);

            event(new Registered($user));

            // Jika data cocok dengan alumni import, update user_id di tabel alumni
            if (($request->is_data_matched ?? false) && $request->alumni_id) {
                Alumni::where('id', $request->alumni_id)->update([
                    'user_id' => $user->id,
                    'email' => $request->email,
                ]);
            }

            Log::info('User registered successfully', [
                'user_id' => $user->id,
                'nim' => $user->nim,
                'status' => $user->status
            ]);

            $message = ($request->is_data_matched ?? false)
                ? 'Pendaftaran berhasil! Data Anda sesuai dengan database alumni. Akun akan diverifikasi oleh admin.'
                : 'Pendaftaran berhasil! Data Anda akan diverifikasi oleh admin terlebih dahulu.';

            return redirect()->route('login')->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Registration failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->with('error', 'Terjadi kesalahan saat pendaftaran: ' . $e->getMessage())->withInput();
        }
    }
}