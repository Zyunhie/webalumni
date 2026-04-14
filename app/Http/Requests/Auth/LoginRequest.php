<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $login = $this->input('login');
        $password = $this->input('password');
        $remember = $this->boolean('remember');

        // Coba login dengan name (Admin)
        try {
            if (Auth::attempt(['name' => $login, 'password' => $password], $remember)) {
                RateLimiter::clear($this->throttleKey());
                return;
            }
        } catch (\RuntimeException $e) {
            // Password di database bukan Bcrypt, coba fallback manual untuk admin
            $user = User::where('name', $login)->first();
            if ($user && $this->legacyPasswordCheck($user, $password)) {
                $this->upgradePassword($user, $password);
                Auth::login($user, $remember);
                RateLimiter::clear($this->throttleKey());
                return;
            }
        }

        // Coba login dengan NIM (Alumni)
        try {
            if (Auth::attempt(['nim' => $login, 'password' => $password], $remember)) {
                RateLimiter::clear($this->throttleKey());
                return;
            }
        } catch (\RuntimeException $e) {
            // Password di database bukan Bcrypt, coba fallback manual untuk alumni
            $user = User::where('nim', $login)->first();
            if ($user && $this->legacyPasswordCheck($user, $password)) {
                $this->upgradePassword($user, $password);
                Auth::login($user, $remember);
                RateLimiter::clear($this->throttleKey());
                return;
            }
        }

        // Jika semua gagal, catat percobaan dan lempar error
        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => 'Username / NIM atau password salah.',
        ]);
    }

    /**
     * Periksa kecocokan password dengan cara legacy (plaintext atau md5, dll).
     * Sesuaikan dengan format password lama yang ada di database.
     */
    protected function legacyPasswordCheck(User $user, string $password): bool
    {
        // Asumsi password di database adalah plaintext
        return $user->password === $password;

        // Contoh jika password lama menggunakan MD5:
        // return $user->password === md5($password);
    }

    /**
     * Perbarui password user ke Bcrypt.
     */
    protected function upgradePassword(User $user, string $password): void
    {
        $user->password = Hash::make($password);
        $user->save();
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::lower($this->input('login')).'|'.$this->ip();
    }
}