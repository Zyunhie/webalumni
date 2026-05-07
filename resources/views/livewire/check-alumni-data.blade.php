<div>
    <!-- Box Pencarian NIM -->
    <div class="mb-4 p-4 bg-blue-50 rounded-xl border border-blue-200">
        <label class="block text-sm font-medium text-blue-800 mb-2">
            🔍 Cek Data Alumni
        </label>
        <input type="text" 
               wire:model.live.debounce.500ms="nim" 
               class="input-field bg-white"
               placeholder="Masukkan NIM untuk cek data otomatis">
        
        @if($message)
            <div class="mt-2 p-2 rounded-lg text-xs 
                {{ $messageType == 'success' ? 'bg-green-100 text-green-700 border border-green-200' : '' }}
                {{ $messageType == 'warning' ? 'bg-yellow-100 text-yellow-700 border border-yellow-200' : '' }}
                {{ $messageType == 'error' ? 'bg-red-100 text-red-700 border border-red-200' : '' }}">
                {{ $message }}
            </div>
        @endif
    </div>
    
    <!-- Form Fields -->
    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1.5">Nama Lengkap</label>
            <input type="text" 
                   name="name" 
                   wire:model="name"
                   value="{{ old('name') }}" 
                   required 
                   class="input-field"
                   placeholder="Sesuai ijazah">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1.5">NIM</label>
            <input type="text" 
                   name="nim" 
                   wire:model="nim"
                   value="{{ old('nim') }}" 
                   required 
                   class="input-field"
                   placeholder="Nomor Induk Mahasiswa">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1.5">Program Studi</label>
            <select name="prodi" wire:model="prodi" required class="input-field">
                <option value="" disabled>Pilih Prodi</option>
                @foreach(['PGMI','PAI','PIAUD','MPI','BKPI','Ekonomi Syariah','Hukum Keluarga Islam','Hukum Tata Negara','S2 PAI'] as $p)
                    <option value="{{ $p }}">{{ $p }}</option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1.5">Angkatan</label>
            <select name="angkatan" wire:model="angkatan" required class="input-field">
                <option value="" disabled>Pilih Angkatan</option>
                @for($year = date('Y'); $year >= 2000; $year--)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1.5">Email</label>
            <input type="email" 
                   name="email" 
                   wire:model="email"
                   value="{{ old('email') }}" 
                   required 
                   class="input-field"
                   placeholder="email@contoh.com">
        </div>
    </div>
</div>