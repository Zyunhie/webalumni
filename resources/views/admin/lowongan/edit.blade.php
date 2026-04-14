@extends('layouts.app')

@section('title', 'Edit Lowongan Kerja')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Edit Lowongan</h3>
                <p class="mt-1 text-sm text-gray-600">Perbarui informasi lowongan kerja.</p>
            </div>
        </div>
        <div class="mt-5 md:col-span-2 md:mt-0">
            <form action="{{ route('admin.lowongan.update', $lowongan) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="shadow sm:overflow-hidden sm:rounded-md">
                    <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                        <!-- Judul -->
                        <div>
                            <label for="judul" class="block text-sm font-medium text-gray-700">Judul Lowongan</label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul', $lowongan->judul) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                            @error('judul') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Perusahaan -->
                        <div>
                            <label for="perusahaan" class="block text-sm font-medium text-gray-700">Perusahaan</label>
                            <input type="text" name="perusahaan" id="perusahaan" value="{{ old('perusahaan', $lowongan->perusahaan) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                            @error('perusahaan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Lokasi -->
                        <div>
                            <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi</label>
                            <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi', $lowongan->lokasi) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                            @error('lokasi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Gambar -->
                        <div>
                            <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar (opsional)</label>
                            @if($lowongan->gambar)
                                <div class="mt-2 mb-2">
                                    <img src="{{ asset('storage/' . $lowongan->gambar) }}" alt="Current Image" class="h-32 w-auto object-cover rounded-md">
                                    <p class="text-xs text-gray-500 mt-1">Upload gambar baru untuk mengganti.</p>
                                </div>
                            @endif
                            <input type="file" name="gambar" id="gambar" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                            @error('gambar') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Pekerjaan</label>
                            <textarea name="deskripsi" id="deskripsi" rows="5" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">{{ old('deskripsi', $lowongan->deskripsi) }}</textarea>
                            @error('deskripsi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Kualifikasi -->
                        <div>
                            <label for="kualifikasi" class="block text-sm font-medium text-gray-700">Kualifikasi</label>
                            <textarea name="kualifikasi" id="kualifikasi" rows="5" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">{{ old('kualifikasi', $lowongan->kualifikasi) }}</textarea>
                            @error('kualifikasi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Cara Melamar -->
                        <div>
                            <label for="cara_melamar" class="block text-sm font-medium text-gray-700">Cara Melamar</label>
                            <textarea name="cara_melamar" id="cara_melamar" rows="3" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">{{ old('cara_melamar', $lowongan->cara_melamar) }}</textarea>
                            @error('cara_melamar') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Link Eksternal -->
                        <div>
                            <label for="external_link" class="block text-sm font-medium text-gray-700">Link Eksternal (opsional)</label>
                            <input type="url" name="external_link" id="external_link" value="{{ old('external_link', $lowongan->external_link) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                            @error('external_link') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Target Prodi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Target Program Studi</label>
                            <div class="mt-2 grid grid-cols-2 gap-2">
                                @php $prodis = ['pgmi', 'pai', 'piaud', 'mpi', 'bkpi', 'eksyar', 'as', 'htn', 'pai-s2']; @endphp
                                @foreach($prodis as $prodi)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="target_prodi[]" value="{{ $prodi }}"
                                            {{ in_array($prodi, old('target_prodi', $lowongan->target_prodi ?? [])) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-500 focus:ring-green-500">
                                        <span class="ml-2 text-sm text-gray-700">{{ strtoupper($prodi) }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('target_prodi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Internal / Eksternal -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tipe Lowongan</label>
                            <div class="mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="is_internal" value="1" {{ old('is_internal', $lowongan->is_internal) == '1' ? 'checked' : '' }}
                                        class="border-gray-300 text-green-600 shadow-sm focus:ring-green-500">
                                    <span class="ml-2 text-sm text-gray-700">Internal (menerima lamaran via sistem)</span>
                                </label>
                                <label class="inline-flex items-center ml-6">
                                    <input type="radio" name="is_internal" value="0" {{ old('is_internal', $lowongan->is_internal) == '0' ? 'checked' : '' }}
                                        class="border-gray-300 text-green-600 shadow-sm focus:ring-green-500">
                                    <span class="ml-2 text-sm text-gray-700">Eksternal (hanya link luar)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                                <option value="pending" {{ old('status', $lowongan->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ old('status', $lowongan->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ old('status', $lowongan->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                        <a href="{{ route('admin.lowongan.show', $lowongan) }}" class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 mr-3">Batal</a>
                        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-green-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection