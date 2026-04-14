<nav x-data="{ open: false }" class="relative z-[9999] bg-gradient-to-r from-green-600 to-green-700 border-b border-green-800 shadow-xl backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Left: Logo + Navigation -->
            <div class="flex items-center space-x-4">
                <!-- Logo with hover -->
                <a href="{{ route('dashboard') }}" class="group">
                    <img src="{{ asset('images/Logo.png') }}" alt="Logo IAIT" 
                         class="h-12 w-auto transition-all duration-300 group-hover:scale-110 group-hover:-rotate-3 shadow-lg rounded-xl">
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-6">
                    <a href="{{ route('dashboard') }}"
                       class="group relative px-3 py-2 text-white font-medium text-sm rounded-lg transition-all duration-300 hover:bg-white/20 hover:shadow-md hover:-translate-y-0.5 active:translate-y-0">
                        <span class="{{ request()->routeIs('dashboard') ? 'underline underline-offset-4' : '' }}">Beranda</span>
                        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-white/0 group-hover:bg-white transition-all duration-300"></div>
                    </a>

                    <a href="{{ auth()->check() ? route('tentang') : route('login') }}"
                       class="group relative px-3 py-2 text-white font-medium text-sm rounded-lg transition-all duration-300 hover:bg-white/20 hover:shadow-md hover:-translate-y-0.5 active:translate-y-0">
                        <span class="{{ request()->routeIs('tentang') ? 'underline underline-offset-4' : '' }}">Tentang</span>
                        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-white/0 group-hover:bg-white transition-all duration-300"></div>
                    </a>

                    <!-- Alumni Dropdown -->
                    <div class="relative" x-data="{ openDropdown: false }">
                        <button @click="openDropdown = !openDropdown"
                                class="group relative px-3 py-2 text-white font-medium text-sm rounded-lg transition-all duration-300 hover:bg-white/20 hover:shadow-md hover:-translate-y-0.5 flex items-center space-x-1">
                            Alumni
                            <svg class="w-4 h-4 transition-transform duration-300" :class="openDropdown ? 'rotate-180' : ''" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.04.13l3.5 4.5a.75.75 0 001.04-.13l3.5-4.5a.75.75 0 011.57 0l4.25 5.5a.75.75 0 01-1.24.88L12.75 9.1a.75.75 0 00-1.5 0v6.6a.75.75 0 01-1.5 0V9.1a.75.75 0 00-1.5 0l-3.25 4.2a.75.75 0 01-1.24-.88L5.23 7.21z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="openDropdown" @click.away="openDropdown = false" @click.stop
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute left-0 mt-1 w-64 bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/50 z-50 -translate-x-4 md:translate-x-0">
                            <a href="{{ auth()->check() ? route('alumni.data') : route('login') }}" 
                               class="block px-6 py-3 text-gray-900 hover:bg-green-50 hover:text-green-700 font-medium transition-all duration-200 first:rounded-t-2xl last:rounded-b-2xl">
                                Data Alumni
                            </a>
                            <a href="{{ route('testimoni.index') }}" 
                               class="block px-6 py-3 text-gray-900 hover:bg-green-50 hover:text-green-700 font-medium transition-all duration-200">
                                Testimoni
                            </a>
                            <a href="{{ auth()->check() ? route('alumni.agenda') : route('login') }}" 
                               class="block px-6 py-3 text-gray-900 hover:bg-green-50 hover:text-green-700 font-medium transition-all duration-200 last:rounded-b-2xl">
                                Agenda
                            </a>
                        </div>
                    </div>

                    <a href="{{ auth()->check() && auth()->user()?->role === 'admin' ? route('admin.berita.index') : route('berita.index') }}"
                       class="group relative px-3 py-2 text-white font-medium text-sm rounded-lg transition-all duration-300 hover:bg-white/20 hover:shadow-md hover:-translate-y-0.5 active:translate-y-0">
                        <span>Berita</span>
                        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-white/0 group-hover:bg-white transition-all duration-300"></div>
                    </a>

                    {{-- Lowongan link menyesuaikan role --}}
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.lowongan.index') }}"
                               class="group relative px-3 py-2 text-white font-medium text-sm rounded-lg transition-all duration-300 hover:bg-white/20 hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('admin.lowongan.*') ? 'underline underline-offset-4' : '' }}">
                                <span>Lowongan</span>
                                <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-white/0 group-hover:bg-white transition-all duration-300"></div>
                            </a>
                        @else
                            <a href="{{ route('lowongan.index') }}"
                               class="group relative px-3 py-2 text-white font-medium text-sm rounded-lg transition-all duration-300 hover:bg-white/20 hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('lowongan.*') ? 'underline underline-offset-4' : '' }}">
                                <span>Lowongan</span>
                                <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-white/0 group-hover:bg-white transition-all duration-300"></div>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('lowongan.index') }}"
                           class="group relative px-3 py-2 text-white font-medium text-sm rounded-lg transition-all duration-300 hover:bg-white/20 hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('lowongan.*') ? 'underline underline-offset-4' : '' }}">
                            <span>Lowongan</span>
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-white/0 group-hover:bg-white transition-all duration-300"></div>
                        </a>
                    @endauth

                    {{-- Kelola Pesan (Admin Only) --}}
@auth
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.kontak.index') }}"
           class="group relative px-3 py-2 text-white font-medium text-sm rounded-lg transition-all duration-300 hover:bg-white/20 hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('admin.kontak.*') ? 'underline underline-offset-4' : '' }}">
            <span>Kelola Pesan</span>
            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-white/0 group-hover:bg-white transition-all duration-300"></div>
        </a>
    @endif
@endauth

{{-- Kontak (Hanya untuk NON-ADMIN atau GUEST) --}}
@auth
    @if(auth()->user()->role !== 'admin')
        <a href="{{ route('kontak') }}"
           class="group relative px-3 py-2 text-white font-medium text-sm rounded-lg transition-all duration-300 hover:bg-white/20 hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('kontak') ? 'underline underline-offset-4' : '' }}">
            <span>Kontak</span>
            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-white/0 group-hover:bg-white transition-all duration-300"></div>
        </a>
    @endif
@else
    <a href="{{ route('kontak') }}"
       class="group relative px-3 py-2 text-white font-medium text-sm rounded-lg transition-all duration-300 hover:bg-white/20 hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('kontak') ? 'underline underline-offset-4' : '' }}">
        <span>Kontak</span>
        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-white/0 group-hover:bg-white transition-all duration-300"></div>
    </a>
@endauth
                </div>
            </div>

            <!-- Right: User Profile & Actions -->
            <div class="flex items-center space-x-3">
                @auth
                    <div class="flex items-center space-x-2 bg-white/10 px-3 py-1.5 rounded-xl backdrop-blur hover:bg-white/20 transition-all duration-300 border border-white/30 hover:shadow-md">
                        <img src="{{ asset('upload/foto/K.jpeg') }}" 
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=10b981&color=ffffff&bold=true'; this.onerror=null;"
                             class="w-8 h-8 rounded-full shadow-md ring-2 ring-white/40 hover:scale-105 transition-all duration-200 cursor-pointer" alt="Foto Profile">
                        <span class="text-white font-medium text-xs max-w-[120px] truncate cursor-pointer">{{ auth()->user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="group p-3 bg-gradient-to-r from-red-500 to-orange-500 hover:from-red-600 hover:to-orange-600 text-white rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center space-x-2 text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7"/>
                            </svg>
                            <span>Keluar</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="group px-6 py-2.5 bg-gradient-to-r from-emerald-400 to-teal-500 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        Login
                    </a>
                @endauth
                
                <!-- Mobile hamburger -->
                <button @click="open = !open" class="md:hidden p-2 rounded-xl bg-white/10 hover:bg-white/20 transition-all duration-300">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" class="md:hidden bg-gradient-to-b from-green-700 via-green-600 to-green-800 p-6 space-y-4 rounded-t-3xl shadow-2xl -mt-4 mx-4 backdrop-blur-xl border border-white/20">
        <div class="flex items-center space-x-3 p-3 bg-white/10 rounded-xl backdrop-blur border border-white/20">
            @auth
                <img src="{{ asset('upload/foto/K.jpeg') }}" 
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
        <a href="{{ route('dashboard') }}" class="block p-4 bg-white/10 hover:bg-white/20 rounded-2xl transition-all duration-300 flex items-center space-x-3">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
            </svg>
            <span class="text-white font-medium">Beranda</span>
        </a>

        {{-- Mobile Lowongan link menyesuaikan role --}}
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.lowongan.index') }}" class="block p-4 bg-white/10 hover:bg-white/20 rounded-2xl transition-all duration-300 flex items-center space-x-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m1-4h6m-6 4h6m1 4h1m-1 4h1"></path>
                    </svg>
                    <span class="text-white font-medium">Kelola Lowongan</span>
                </a>
            @else
                <a href="{{ route('lowongan.index') }}" class="block p-4 bg-white/10 hover:bg-white/20 rounded-2xl transition-all duration-300 flex items-center space-x-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m1-4h6m-6 4h6m1 4h1m-1 4h1"></path>
                    </svg>
                    <span class="text-white font-medium">Lowongan Kerja</span>
                </a>
            @endif
        @else
            <a href="{{ route('lowongan.index') }}" class="block p-4 bg-white/10 hover:bg-white/20 rounded-2xl transition-all duration-300 flex items-center space-x-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m1-4h6m-6 4h6m1 4h1m-1 4h1"></path>
                </svg>
                <span class="text-white font-medium">Lowongan Kerja</span>
            </a>
        @endauth

        {{-- Mobile Kelola Pesan (Admin Only) --}}
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.kontak.index') }}" class="block p-4 bg-white/10 hover:bg-white/20 rounded-2xl transition-all duration-300 flex items-center space-x-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89-3.26a2 2 0 012.22 0L21 8M5 19h14a2 2 0 002-2v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-white font-medium">Kelola Pesan</span>
                </a>
            @endif
        @endauth

        <a href="{{ route('tentang') }}" class="block p-4 bg-white/10 hover:bg-white/20 rounded-2xl transition-all duration-300 flex items-center space-x-3">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"/>
            </svg>
            <span class="text-white font-medium">Tentang</span>
        </a>
        <a href="{{ route('dashboard') }}" class="block p-4 bg-white/10 hover:bg-white/20 rounded-2xl transition-all duration-300 flex items-center space-x-3">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
            </svg>
            <span class="text-white font-medium">Dashboard</span>
        </a>

        {{-- Admin only links (mobile) --}}
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.berita.index') }}" class="block p-4 bg-white/10 hover:bg-white/20 rounded-2xl transition-all duration-300 flex items-center space-x-3">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12 9a3 3 0 00-6 0v6a3 3 0 006 0V9z"/>
                    </svg>
                    <span class="text-white font-medium">Kelola Berita</span>
                </a>
            @endif
        @endauth

        <a href="{{ route('alumni.data') }}" class="block p-4 bg-white/10 hover:bg-white/20 rounded-2xl transition-all duration-300 flex items-center space-x-3">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L12 12.414V6z"/>
            </svg>
            <span class="text-white font-medium">Data Alumni</span>
        </a>
        {{-- Mobile: Kontak hanya untuk NON-ADMIN --}}
@auth
    @if(auth()->user()->role !== 'admin')
        <a href="{{ route('kontak') }}" class="block p-4 bg-white/10 hover:bg-white/20 rounded-2xl transition-all duration-300 flex items-center space-x-3">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89-3.26a2 2 0 012.22 0L21 8M5 19h14a2 2 0 002-2v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2z"/>
            </svg>
            <span class="text-white font-medium">Kontak</span>
        </a>
    @endif
@else
    <a href="{{ route('kontak') }}" class="block p-4 bg-white/10 hover:bg-white/20 rounded-2xl transition-all duration-300 flex items-center space-x-3">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89-3.26a2 2 0 012.22 0L21 8M5 19h14a2 2 0 002-2v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2z"/>
        </svg>
        <span class="text-white font-medium">Kontak</span>
    </a>
@endauth
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