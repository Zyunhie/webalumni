@extends('layouts.app')

@section('title', 'Profil Saya')

@push('styles')
<style>
    .profile-hero {
        background: linear-gradient(135deg, #15803d 0%, #166534 60%, #14532d 100%);
        position: relative;
        overflow: hidden;
    }
    .profile-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .section-card {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        border: 1px solid rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .section-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .section-card-header .icon-wrap {
        width: 36px;
        height: 36px;
        background: #f0fdf4;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #16a34a;
        flex-shrink: 0;
    }
    .section-card-header h3 {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }
    .section-card-header p {
        font-size: 0.75rem;
        color: #9ca3af;
        margin: 0;
    }
    .section-card-body {
        padding: 1.5rem;
    }

    /* Form Inputs */
    .form-group { margin-bottom: 1.25rem; }
    .form-group label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.4rem;
    }
    .form-control {
        width: 100%;
        padding: 0.6rem 0.875rem;
        border: 1.5px solid #e5e7eb;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        color: #1f2937;
        background: #f9fafb;
        transition: border-color .15s, box-shadow .15s, background .15s;
        outline: none;
    }
    .form-control:focus {
        border-color: #16a34a;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(22,163,74,0.1);
    }
    .form-control.error { border-color: #ef4444; }
    .form-error { font-size: 0.72rem; color: #ef4444; margin-top: 0.3rem; }

    /* Btn */
    .btn-primary {
        background: #16a34a;
        color: #fff;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.55rem 1.5rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        transition: background .15s, transform .1s;
    }
    .btn-primary:hover { background: #15803d; transform: translateY(-1px); }
    .btn-primary:active { transform: translateY(0); }

    .btn-danger {
        background: #fff;
        color: #ef4444;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.55rem 1.5rem;
        border-radius: 0.5rem;
        border: 1.5px solid #fecaca;
        cursor: pointer;
        transition: all .15s;
    }
    .btn-danger:hover { background: #fef2f2; border-color: #ef4444; }

    /* Avatar - DIPERBAIKI agar bulat */
    .avatar-ring {
        width: 80px;
        height: 80px;
        border-radius: 9999px;
        border: 3px solid rgba(255,255,255,0.3);
        background: #166534;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 2rem;
        font-weight: 700;
        flex-shrink: 0;
        overflow: hidden;  /* Kunci agar gambar terpotong bulat */
    }
    .avatar-ring img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .photo-upload-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        background: #f9fafb;
        margin-bottom: 1.25rem;
    }
    .photo-preview {
        width: 64px;
        height: 64px;
        border-radius: 9999px;
        object-fit: cover;
        background: #ecfdf5;
        border: 2px solid #d1fae5;
        flex-shrink: 0;
    }

    /* Alert success */
    .alert-success {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.78rem;
        color: #15803d;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 0.5rem;
        padding: 0.4rem 0.85rem;
    }

    /* Danger zone */
    .danger-zone {
        border: 1.5px solid #fecaca;
        border-radius: 1rem;
        overflow: hidden;
    }
    .danger-zone-header {
        background: #fef2f2;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #fecaca;
    }
    .danger-zone-body { padding: 1.5rem; }

    /* Modal */
    .modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 50;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }
    .modal-backdrop.active { display: flex; }
    .modal-box {
        background: #fff;
        border-radius: 1rem;
        width: 100%;
        max-width: 420px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        overflow: hidden;
    }
    .modal-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
    }
    .modal-body { padding: 1.5rem; }
    .modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid #f3f4f6;
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
    }
    .btn-cancel {
        background: #f3f4f6;
        color: #374151;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.55rem 1.25rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
    }
    .btn-cancel:hover { background: #e5e7eb; }

    /* Verify email notice */
    .verify-notice {
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        font-size: 0.78rem;
        color: #92400e;
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }
</style>
@endpush

@section('content')

{{-- HERO BANNER --}}
<div class="profile-hero py-10 px-4">
    <div class="max-w-3xl mx-auto flex items-center gap-5">
        {{-- Avatar bulat --}}
        <div class="avatar-ring">
            <img src="{{ $user->profile_photo_url }}" alt="Foto profil {{ $user->name }}">
        </div>
        <div class="text-white">
            <div class="text-xs font-semibold uppercase tracking-widest opacity-70 mb-1">Profil Saya</div>
            <h1 class="text-2xl font-bold leading-tight">{{ $user->name }}</h1>
            <div class="text-sm opacity-80 mt-0.5">{{ $user->email }}</div>
        </div>
    </div>
</div>

{{-- CONTENT --}}
<div class="bg-gray-50 min-h-screen py-8 px-4">
    <div class="max-w-3xl mx-auto space-y-6">

        {{-- UPDATE PROFILE --}}
        <div class="section-card">
            <div class="section-card-header">
                <div class="icon-wrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <h3>Informasi Profil</h3>
                    <p>Perbarui nama dan alamat email akun Anda</p>
                </div>
            </div>
            <div class="section-card-body">
                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <div class="photo-upload-row">
                        <img src="{{ $user->profile_photo_url }}" alt="Foto profil {{ $user->name }}" class="photo-preview">
                        <div class="flex-1">
                            <label for="profile_photo">Foto Profil</label>
                            <input id="profile_photo" name="profile_photo" type="file" accept="image/*"
                                class="form-control {{ $errors->get('profile_photo') ? 'error' : '' }}">
                            <p style="font-size:0.72rem;color:#9ca3af;margin-top:0.35rem">Format JPG/PNG, maksimal 2MB.</p>
                            @foreach($errors->get('profile_photo') as $error)
                                <div class="form-error">{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input id="name" name="name" type="text"
                            class="form-control {{ $errors->get('name') ? 'error' : '' }}"
                            value="{{ old('name', $user->name) }}"
                            required autofocus autocomplete="name">
                        @foreach($errors->get('name') as $error)
                            <div class="form-error">{{ $error }}</div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <input id="email" name="email" type="email"
                            class="form-control {{ $errors->get('email') ? 'error' : '' }}"
                            value="{{ old('email', $user->email) }}"
                            required autocomplete="username">
                        @foreach($errors->get('email') as $error)
                            <div class="form-error">{{ $error }}</div>
                        @endforeach

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="verify-notice">
                                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>
                                    Email belum terverifikasi.
                                    <form id="send-verification" method="post" action="{{ route('verification.send') }}" style="display:inline">
                                        @csrf
                                        <button type="submit" style="text-decoration:underline;background:none;border:none;cursor:pointer;font-size:inherit;color:inherit;padding:0">
                                            Kirim ulang email verifikasi
                                        </button>
                                    </form>
                                </span>
                            </div>

                            @if (session('status') === 'verification-link-sent')
                                <div class="alert-success mt-2">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Link verifikasi berhasil dikirim.
                                </div>
                            @endif
                        @endif
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" class="btn-primary">Simpan Perubahan</button>
                        @if (session('status') === 'profile-updated')
                            <div class="alert-success"
                                x-data="{ show: true }"
                                x-show="show"
                                x-init="setTimeout(() => show = false, 2000)">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Tersimpan!
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- UPDATE PASSWORD --}}
        <div class="section-card">
            <div class="section-card-header">
                <div class="icon-wrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <div>
                    <h3>Ubah Password</h3>
                    <p>Pastikan password baru cukup panjang dan aman</p>
                </div>
            </div>
            <div class="section-card-body">
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="form-group">
                        <label for="current_password">Password Saat Ini</label>
                        <input id="current_password" name="current_password" type="password"
                            class="form-control {{ $errors->updatePassword->get('current_password') ? 'error' : '' }}"
                            autocomplete="current-password">
                        @foreach($errors->updatePassword->get('current_password') as $error)
                            <div class="form-error">{{ $error }}</div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <input id="password" name="password" type="password"
                            class="form-control {{ $errors->updatePassword->get('password') ? 'error' : '' }}"
                            autocomplete="new-password">
                        @foreach($errors->updatePassword->get('password') as $error)
                            <div class="form-error">{{ $error }}</div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password Baru</label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                            class="form-control"
                            autocomplete="new-password">
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" class="btn-primary">Perbarui Password</button>
                        @if (session('status') === 'password-updated')
                            <div class="alert-success">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Password diperbarui!
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- DELETE ACCOUNT --}}
        @if(trim(auth()->user()->role) === 'admin')
        <div class="danger-zone">
            <div class="danger-zone-header">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span style="font-size:0.9rem;font-weight:700;color:#b91c1c">Zona Berbahaya</span>
                </div>
            </div>
            <div class="danger-zone-body">
                <p style="font-size:0.82rem;color:#6b7280;margin-bottom:1rem">
                    Setelah akun dihapus, semua data akan hilang permanen. Pastikan Anda sudah mengunduh data yang diperlukan sebelum melanjutkan.
                </p>
                <button type="button" class="btn-danger" onclick="document.getElementById('deleteModal').classList.add('active')">
                    Hapus Akun
                </button>
            </div>
        </div>
        @endif

    </div>
</div>

{{-- DELETE MODAL --}}
<div id="deleteModal" class="modal-backdrop" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="modal-box">
        <div class="modal-header">
            <div style="font-size:1rem;font-weight:700;color:#1f2937">Konfirmasi Hapus Akun</div>
            <div style="font-size:0.78rem;color:#9ca3af;margin-top:0.25rem">Tindakan ini tidak dapat dibatalkan.</div>
        </div>
        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')
            <div class="modal-body">
                <div class="form-group" style="margin-bottom:0">
                    <label for="delete_password">Masukkan password untuk konfirmasi</label>
                    <input id="delete_password" name="password" type="password"
                        class="form-control {{ $errors->userDeletion->get('password') ? 'error' : '' }}"
                        placeholder="Password Anda">
                    @foreach($errors->userDeletion->get('password') as $error)
                        <div class="form-error">{{ $error }}</div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="document.getElementById('deleteModal').classList.remove('active')">Batal</button>
                <button type="submit" class="btn-danger" style="border-color:#ef4444;background:#ef4444;color:#fff">Hapus Akun</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Auto open delete modal if there are deletion errors
    @if($errors->userDeletion->isNotEmpty())
        document.getElementById('deleteModal').classList.add('active');
    @endif
</script>
@endpush