<nav x-data="{ open: false }" class="relative z-[9999] bg-gradient-to-r from-green-600 to-green-700 border-b border-green-800 shadow-xl backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            {{-- Kiri: Logo + Navigasi Desktop --}}
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="group">
                    <img src="{{ asset('images/Logo.png') }}" alt="Logo IAIT" 
                         class="h-12 w-auto transition-all duration-300 group-hover:scale-110 group-hover:-rotate-3 shadow-lg rounded-xl">
                </a>

                {{-- Menu Desktop --}}
                <div class="hidden md:flex space-x-6">
                    {{-- Beranda --}}
                    @php $isHome = request()->routeIs('home*', 'dashboard'); @endphp
                    <a href="{{ route('home') }}"
                       class="group relative px-3 py-2 text-white font-medium text-sm rounded-lg transition-all duration-300 
                              {{ $isHome ? 'bg-white/20 font-semibold shadow-md' : 'hover:bg-white/20 hover:shadow-md hover:-translate-y-0.5' }}">
                        <span class="{{ $isHome ? 'underline underline-offset-4' : '' }}">Beranda</span>
                        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-white/0 group-hover:bg-white transition-all duration-300"></div>
                    </a>

                    {{-- Tentang --}}
                    @php $isTentang = request()->routeIs('tentang'); @endphp
                    <a href="{{ route('tentang') }}"
                       class="group relative px-3 py-2 text-white font-medium text-sm rounded-lg transition-all duration-300 
                              {{ $isTentang ? 'bg-white/20 font-semibold shadow-md' : 'hover:bg-white/20 hover:shadow-md hover:-translate-y-0.5' }}">
                        <span class="{{ $isTentang ? 'underline underline-offset-4' : '' }}">Tentang</span>
                        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-white/0 group-hover:bg-white transition-all duration-300"></div>
                    </a>

                    {{-- Dropdown Alumni --}}
                    @php 
                        $isAlumniActive = request()->routeIs('alumni.*', 'testimoni.*', 'alumni.agenda'); 
                    @endphp
                    <div class="relative" x-data="{ openDropdown: false }">
                        <button @click="openDropdown = !openDropdown"
                                class="group relative px-3 py-2 text-white font-medium text-sm rounded-lg transition-all duration-300 flex items-center space-x-1
                                       {{ $isAlumniActive ? 'bg-white/20 font-semibold shadow-md' : 'hover:bg-white/20 hover:shadow-md hover:-translate-y-0.5' }}">
                            <span class="{{ $isAlumniActive ? 'underline underline-offset-4' : '' }}">Alumni</span>
                            <svg class="w-4 h-4 transition-transform duration-300" :class="openDropdown ? 'rotate-180' : ''" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.04.13l3.5 4.5a.75.75 0 001.04-.13l3.5-4.5a.75.75 0 011.57 0l4.25 5.5a.75.75 0 01-1.24.88L12.75 9.1a.75.75 0 00-1.5 0v6.6a.75.75 0 01-1.5 0V9.1a.75.75 0 00-1.5 0l-3.25 4.2a.75.75 0 01-1.24-.88L5.23 7.21z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="openDropdown" @click.away="openDropdown = false" @click.stop
                             x-transition.opacity.duration.200
                             class="absolute left-0 mt-1 w-64 bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/50 z-50 -translate-x-4 md:translate-x-0">
                            <a href="{{ route('alumni.data') }}" 
                               class="block px-6 py-3 text-gray-900 hover:bg-green-50 hover:text-green-700 font-medium transition-all duration-200 first:rounded-t-2xl
                                      {{ request()->routeIs('alumni.data') ? 'bg-green-100 text-green-800' : '' }}">
                                Data Alumni
                            </a>
                            <a href="{{ route('testimoni.index') }}" 
                               class="block px-6 py-3 text-gray-900 hover:bg-green-50 hover:text-green-700 font-medium transition-all duration-200
                                      {{ request()->routeIs('testimoni.*') ? 'bg-green-100 text-green-800' : '' }}">
                                Testimoni
                            </a>
                            <a href="{{ route('alumni.agenda') }}" 
                               class="block px-6 py-3 text-gray-900 hover:bg-green-50 hover:text-green-700 font-medium transition-all duration-200 last:rounded-b-2xl
                                      {{ request()->routeIs('alumni.agenda') ? 'bg-green-100 text-green-800' : '' }}">
                                Agenda
                            </a>
                        </div>
                    </div>

                    {{-- Berita --}}
                    @php 
                        $beritaRoute = auth()->check() && auth()->user()?->role === 'admin' 
                                        ? 'admin.berita.index' 
                                        : 'berita.index';
                        $isBerita = request()->routeIs($beritaRoute, 'berita.*', 'admin.berita.*');
                    @endphp
                    <a href="{{ route($beritaRoute) }}"
                       class="group relative px-3 py-2 text-white font-medium text-sm rounded-lg transition-all duration-300 
                              {{ $isBerita ? 'bg-white/20 font-semibold shadow-md' : 'hover:bg-white/20 hover:shadow-md hover:-translate-y-0.5' }}">
                        <span class="{{ $isBerita ? 'underline underline-offset-4' : '' }}">Berita</span>
                        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-white/0 group-hover:bg-white transition-all duration-300"></div>
                    </a>

                    {{-- Lowongan (role-based) --}}
                    @auth
                        @php
                            $lowonganRoute = auth()->user()->role === 'admin' 
                                                ? 'admin.lowongan.index' 
                                                : 'lowongan.index';
                            $isLowongan = request()->routeIs('admin.lowongan.*', 'lowongan.*');
                        @endphp
                        <a href="{{ route($lowonganRoute) }}"
                           class="group relative px-3 py-2 text-white font-medium text-sm rounded-lg transition-all duration-300 
                                  {{ $isLowongan ? 'bg-white/20 font-semibold shadow-md' : 'hover:bg-white/20 hover:shadow-md hover:-translate-y-0.5' }}">
                            <span class="{{ $isLowongan ? 'underline underline-offset-4' : '' }}">Lowongan</span>
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-white/0 group-hover:bg-white transition-all duration-300"></div>
                        </a>
                    @else
                        @php $isLowongan = request()->routeIs('lowongan.*'); @endphp
                        <a href="{{ route('lowongan.index') }}"
                           class="group relative px-3 py-2 text-white font-medium text-sm rounded-lg transition-all duration-300 
                                  {{ $isLowongan ? 'bg-white/20 font-semibold shadow-md' : 'hover:bg-white/20 hover:shadow-md hover:-translate-y-0.5' }}">
                            <span class="{{ $isLowongan ? 'underline underline-offset-4' : '' }}">Lowongan</span>
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-white/0 group-hover:bg-white transition-all duration-300"></div>
                        </a>
                    @endauth

                    {{-- ✅ VERIFIKASI AKUN (Admin Only) - TAMBAHKAN DI SINI ✅ --}}
                    @auth
                        @if(auth()->user()->role === 'admin')
                            @php 
                                $pendingCount = \App\Models\User::where('status', 'pending')->count();
                                $isVerifikasi = request()->routeIs('admin.users.*');
                            @endphp
                            <a href="{{ route('admin.users.pending') }}"
                               class="group relative px-3 py-2 text-white font-medium text-sm rounded-lg transition-all duration-300 
                                      {{ $isVerifikasi ? 'bg-white/20 font-semibold shadow-md' : 'hover:bg-white/20 hover:shadow-md hover:-translate-y-0.5' }}">
                                <span class="{{ $isVerifikasi ? 'underline underline-offset-4' : '' }}">Verifikasi Akun</span>
                                @if($pendingCount > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full animate-pulse">
                                        {{ $pendingCount }}
                                    </span>
                                @endif
                                <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-white/0 group-hover:bg-white transition-all duration-300"></div>
                            </a>
                        @endif
                    @endauth

                    {{-- Kelola Pesan (Admin Only) --}}
                    @auth
                        @if(auth()->user()->role === 'admin')
                            @php $isKontakAdmin = request()->routeIs('admin.kontak.*'); @endphp
                            <a href="{{ route('admin.kontak.index') }}"
                               class="group relative px-3 py-2 text-white font-medium text-sm rounded-lg transition-all duration-300 
                                      {{ $isKontakAdmin ? 'bg-white/20 font-semibold shadow-md' : 'hover:bg-white/20 hover:shadow-md hover:-translate-y-0.5' }}">
                                <span class="{{ $isKontakAdmin ? 'underline underline-offset-4' : '' }}">Kelola Pesan</span>
                                <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-white/0 group-hover:bg-white transition-all duration-300"></div>
                            </a>
                        @endif
                    @endauth

                    {{-- Kelola User (Admin Only) --}}
                    @auth
                        @if(auth()->user()->role === 'admin')
                            @php $isKelolaUser = request()->routeIs('admin.users.*'); @endphp
                            <a href="{{ route('admin.users.index') }}"
                               class="group relative px-3 py-2 text-white font-medium text-sm rounded-lg transition-all duration-300 
                                      {{ $isKelolaUser ? 'bg-white/20 font-semibold shadow-md' : 'hover:bg-white/20 hover:shadow-md hover:-translate-y-0.5' }}">
                                <span class="{{ $isKelolaUser ? 'underline underline-offset-4' : '' }}">Kelola User</span>
                                <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-white/0 group-hover:bg-white transition-all duration-300"></div>
                            </a>
                        @endif
                    @endauth

                    {{-- Kontak (Non‑Admin / Guest) --}}
                    @auth
                        @if(auth()->user()->role !== 'admin')
                            @php $isKontak = request()->routeIs('kontak'); @endphp
                            <a href="{{ route('kontak') }}"
                               class="group relative px-3 py-2 text-white font-medium text-sm rounded-lg transition-all duration-300 
                                      {{ $isKontak ? 'bg-white/20 font-semibold shadow-md' : 'hover:bg-white/20 hover:shadow-md hover:-translate-y-0.5' }}">
                                <span class="{{ $isKontak ? 'underline underline-offset-4' : '' }}">Kontak</span>
                                <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-white/0 group-hover:bg-white transition-all duration-300"></div>
                            </a>
                        @endif
                    @else
                        @php $isKontak = request()->routeIs('kontak'); @endphp
                        <a href="{{ route('kontak') }}"
                           class="group relative px-3 py-2 text-white font-medium text-sm rounded-lg transition-all duration-300 
                                  {{ $isKontak ? 'bg-white/20 font-semibold shadow-md' : 'hover:bg-white/20 hover:shadow-md hover:-translate-y-0.5' }}">
                            <span class="{{ $isKontak ? 'underline underline-offset-4' : '' }}">Kontak</span>
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-white/0 group-hover:bg-white transition-all duration-300"></div>
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Right: User Profile & Actions -->
            <div class="flex items-center space-x-3">
                @auth
                    {{-- Desktop: seluruh card jadi link ke profile --}}
                    <a href="{{ route('profile') }}"
                       class="flex items-center space-x-2 bg-white/10 px-3 py-1.5 rounded-xl backdrop-blur hover:bg-white/20 transition-all duration-300 border border-white/30 hover:shadow-md">
                        <img src="{{ auth()->user()->profile_photo_url }}"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=10b981&color=ffffff&bold=true'; this.onerror=null;"
                             class="w-8 h-8 rounded-full shadow-md ring-2 ring-white/40 transition-all duration-200" alt="Foto Profile">
                        <span class="text-white font-medium text-xs max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="p-3 bg-gradient-to-r from-red-500 to-orange-500 hover:from-red-600 hover:to-orange-600 text-white rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center space-x-2 text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7"/>
                            </svg>
                            <span class="hidden md:inline">Keluar</span>
                        </button>
                    </form>
                @else
                    {{-- Tombol Register (baru) --}}
                    <a href="{{ route('register') }}"
                       class="px-6 py-2.5 border-2 border-white/50 text-white font-semibold rounded-2xl hover:bg-white/10 hover:border-white hover:-translate-y-0.5 transition-all duration-300">
                        Register
                    </a>

                    {{-- Tombol Login --}}
                    <a href="{{ route('login') }}"
                       class="px-6 py-2.5 bg-gradient-to-r from-emerald-400 to-teal-500 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        Login
                    </a>
                @endauth

                <button @click="open = !open" class="md:hidden p-2 rounded-xl bg-white/10 hover:bg-white/20 transition-all duration-300">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu (dengan indikator aktif) --}}
    <div x-show="open" class="md:hidden bg-gradient-to-b from-green-700 via-green-600 to-green-800 p-6 space-y-4 rounded-t-3xl shadow-2xl -mt-4 mx-4 backdrop-blur-xl border border-white/20">
        {{-- Info user mobile --}}
        <div class="flex items-center space-x-3 p-3 bg-white/10 rounded-xl backdrop-blur border border-white/20">
            @auth
                <img src="{{ auth()->user()->profile_photo_url }}" 
                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=10b981&color=ffffff&bold=true'; this.onerror=null;"
                     class="w-10 h-10 rounded-xl shadow-md cursor-pointer hover:scale-105 transition-all" alt="Foto Profile">
                <div>
                    <div class="text-white font-bold text-base">{{ auth()->user()->name ?? 'User' }}</div>
                    <div class="text-green-100 text-xs">{{ auth()->user()->role === 'admin' ? 'Admin' : 'Alumni IAIT' }}</div>
                </div>
            @else
                <div class="text-white">Selamat datang</div>
            @endauth
        </div>

        {{-- Beranda --}}
        <a href="{{ route('home') }}" 
           class="block p-4 rounded-2xl transition-all duration-300 flex items-center space-x-3
                  {{ request()->routeIs('home*', 'dashboard') ? 'bg-white/30 border-l-4 border-white pl-3' : 'bg-white/10 hover:bg-white/20' }}">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
            </svg>
            <span class="text-white font-medium">Beranda</span>
        </a>

        {{-- Tentang --}}
        <a href="{{ route('tentang') }}" 
           class="block p-4 rounded-2xl transition-all duration-300 flex items-center space-x-3
                  {{ request()->routeIs('tentang') ? 'bg-white/30 border-l-4 border-white pl-3' : 'bg-white/10 hover:bg-white/20' }}">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"/>
            </svg>
            <span class="text-white font-medium">Tentang</span>
        </a>

        {{-- Data Alumni --}}
        <a href="{{ route('alumni.data') }}" 
           class="block p-4 rounded-2xl transition-all duration-300 flex items-center space-x-3
                  {{ request()->routeIs('alumni.data') ? 'bg-white/30 border-l-4 border-white pl-3' : 'bg-white/10 hover:bg-white/20' }}">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
            </svg>
            <span class="text-white font-medium">Data Alumni</span>
        </a>

        {{-- Berita (role-based) --}}
        @php
            $beritaRoute = auth()->check() && auth()->user()?->role === 'admin' 
                            ? 'admin.berita.index' 
                            : 'berita.index';
            $isBeritaMobile = request()->routeIs($beritaRoute, 'berita.*', 'admin.berita.*');
        @endphp
        <a href="{{ route($beritaRoute) }}" 
           class="block p-4 rounded-2xl transition-all duration-300 flex items-center space-x-3
                  {{ $isBeritaMobile ? 'bg-white/30 border-l-4 border-white pl-3' : 'bg-white/10 hover:bg-white/20' }}">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M12 9a3 3 0 00-6 0v6a3 3 0 006 0V9z"/>
            </svg>
            <span class="text-white font-medium">Berita</span>
        </a>

        {{-- Lowongan (role-based) --}}
        @auth
            @php
                $lowonganRoute = auth()->user()->role === 'admin' 
                                    ? 'admin.lowongan.index' 
                                    : 'lowongan.index';
                $isLowonganMobile = request()->routeIs('admin.lowongan.*', 'lowongan.*');
            @endphp
            <a href="{{ route($lowonganRoute) }}" 
               class="block p-4 rounded-2xl transition-all duration-300 flex items-center space-x-3
                      {{ $isLowonganMobile ? 'bg-white/30 border-l-4 border-white pl-3' : 'bg-white/10 hover:bg-white/20' }}">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m1-4h6m-6 4h6m1 4h1m-1 4h1"/>
                </svg>
                <span class="text-white font-medium">
                    {{ auth()->user()->role === 'admin' ? 'Kelola Lowongan' : 'Lowongan Kerja' }}
                </span>
            </a>
        @else
            @php $isLowonganMobile = request()->routeIs('lowongan.*'); @endphp
            <a href="{{ route('lowongan.index') }}" 
               class="block p-4 rounded-2xl transition-all duration-300 flex items-center space-x-3
                      {{ $isLowonganMobile ? 'bg-white/30 border-l-4 border-white pl-3' : 'bg-white/10 hover:bg-white/20' }}">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m1-4h6m-6 4h6m1 4h1m-1 4h1"/>
                </svg>
                <span class="text-white font-medium">Lowongan Kerja</span>
            </a>
        @endauth

        {{-- ✅ VERIFIKASI AKUN (Admin Only) - TAMBAHKAN DI MOBILE MENU ✅ --}}
        @auth
            @if(auth()->user()->role === 'admin')
                @php $pendingCount = \App\Models\User::where('status', 'pending')->count(); @endphp
                <a href="{{ route('admin.users.pending') }}" 
                   class="block p-4 rounded-2xl transition-all duration-300 flex items-center justify-between
                          {{ request()->routeIs('admin.users.*') ? 'bg-white/30 border-l-4 border-white pl-3' : 'bg-white/10 hover:bg-white/20' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/>
                        </svg>
                        <span class="text-white font-medium">Verifikasi Akun</span>
                    </div>
                    @if($pendingCount > 0)
                        <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full animate-pulse">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>
            @endif
        @endauth

        {{-- Kelola Pesan (Admin) --}}
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.kontak.index') }}" 
                   class="block p-4 rounded-2xl transition-all duration-300 flex items-center space-x-3
                          {{ request()->routeIs('admin.kontak.*') ? 'bg-white/30 border-l-4 border-white pl-3' : 'bg-white/10 hover:bg-white/20' }}">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89-3.26a2 2 0 012.22 0L21 8M5 19h14a2 2 0 002-2v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-white font-medium">Kelola Pesan</span>
                </a>
            @endif
        @endauth

        {{-- Kelola User (Admin) --}}
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.users.index') }}" 
                   class="block p-4 rounded-2xl transition-all duration-300 flex items-center space-x-3
                          {{ request()->routeIs('admin.users.*') ? 'bg-white/30 border-l-4 border-white pl-3' : 'bg-white/10 hover:bg-white/20' }}">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span class="text-white font-medium">Kelola User</span>
                </a>
            @endif
        @endauth

        {{-- Kontak (Non‑Admin / Guest) --}}
        @auth
            @if(auth()->user()->role !== 'admin')
                <a href="{{ route('kontak') }}" 
                   class="block p-4 rounded-2xl transition-all duration-300 flex items-center space-x-3
                          {{ request()->routeIs('kontak') ? 'bg-white/30 border-l-4 border-white pl-3' : 'bg-white/10 hover:bg-white/20' }}">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89-3.26a2 2 0 012.22 0L21 8M5 19h14a2 2 0 002-2v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-white font-medium">Kontak</span>
                </a>
            @endif
        @else
            <a href="{{ route('kontak') }}" 
               class="block p-4 rounded-2xl transition-all duration-300 flex items-center space-x-3
                      {{ request()->routeIs('kontak') ? 'bg-white/30 border-l-4 border-white pl-3' : 'bg-white/10 hover:bg-white/20' }}">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89-3.26a2 2 0 012.22 0L21 8M5 19h14a2 2 0 002-2v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                </svg>
                <span class="text-white font-medium">Kontak</span>
            </a>
        @endauth

        {{-- Tombol Register & Login di mobile (jika tamu) --}}
        @guest
            <div class="space-y-3 pt-2">
                <a href="{{ route('register') }}" 
                   class="block p-4 bg-white/10 border border-white/40 text-white text-center font-semibold rounded-2xl hover:bg-white/20 transition-all duration-300">
                    Register
                </a>
                <a href="{{ route('login') }}" 
                   class="block p-4 bg-gradient-to-r from-emerald-400 to-teal-500 text-white text-center font-semibold rounded-2xl hover:shadow-lg transition-all duration-300">
                    Login
                </a>
            </div>
        @endguest

        {{-- Tombol Logout (mobile) --}}
        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full p-4 bg-gradient-to-r from-red-500 to-orange-500 hover:from-red-600 hover:to-orange-600 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center space-x-3 justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7"/>
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        @endauth
    </div>
</nav>
