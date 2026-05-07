<?php

namespace App\Http\Requests;

use App\Models\Alumni;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class AlumniRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:users,nim',
            'prodi' => 'required|string|max:50',
            'angkatan' => 'required|integer|min:1990|max:' . date('Y'),
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // CEK: Apakah data ini ADA di tabel alumni (hasil import admin)?
            $matchedAlumni = Alumni::where('nim', $this->nim)
                ->where('nama', $this->name)
                ->where('prodi', $this->prodi)
                ->where('angkatan', $this->angkatan)
                ->first();

            if ($matchedAlumni) {
                // DATA COCOK! Simpan alumni_id dan flag
                $this->merge([
                    'alumni_id' => $matchedAlumni->id,
                    'is_data_matched' => true,
                ]);
                
                // Jika alumni sudah punya user?
                if ($matchedAlumni->user_id) {
                    $validator->errors()->add(
                        'nim',
                        'NIM ini sudah terdaftar. Silakan login atau hubungi admin.'
                    );
                }
            } else {
                // DATA TIDAK COCOK! Registrasi biasa
                $this->merge([
                    'alumni_id' => null,
                    'is_data_matched' => false,
                ]);
            }
        });
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi.',
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM sudah terdaftar. Silakan login atau gunakan NIM lain.',
            'prodi.required' => 'Program studi wajib dipilih.',
            'angkatan.required' => 'Tahun angkatan wajib dipilih.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ];
    }
}