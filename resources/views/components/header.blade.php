<nav x-data="{ open: false }" class="bg-green-600 border-b border-green-700 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Left: Logo + Navigation -->
            <div class="flex items-center">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/Logo.png') }}" alt="Logo IAIT" class="block h-10 w-auto">
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">

                    <!-- Beranda (selalu publik) -->
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium
                       {{ request()->routeIs('dashboard') ? 'border-white text-white' : 'border-transparent text-gray-200 hover:text-white' }}">
                        Beranda
                    </a>

                    <!-- Tentang -->
                    <a href="{{ auth()->check() ? route('tentang') : route('login') }}"
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium
                       {{ request()->routeIs('tentang') ? 'border-white text-white' : 'border-transparent text-gray-200 hover:text-white' }}">
                        Tentang
                    </a>

                    <!-- Alumni Dropdown -->
                    <div class="relative" x-data="{ openDropdown: false }">
                        <button @click="openDropdown = !openDropdown"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-200 hover:text-white focus:outline-none">
                            Alumni
                            <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5.293 7.293L10 12l4.707-4.707" />
                            </svg>
                        </button>

                        <div x-show="openDropdown" @click.away="openDropdown = false"
                             x-transition
                             class="absolute mt-2 w-48 bg-white rounded shadow-lg z-50">

                            <a href="{{ auth()->check() ? route('alumni.data') : route('login') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                                Data Alumni
                            </a>
                            <a href="{{ auth()->check() ? route('testimoni.index') : route('testimoni.index') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                                Testimoni

                            </a>
                            <a href="{{ auth()->check() ? route('alumni.agenda') : route('login') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                                Agenda
                            </a>
                        </div>
                    </div>

                    <!-- Berita -->
                    <a href="{{ auth()->check() ? route('berita.index') : route('login') }}"
                       class="inline-flex items-center px-1 pt-1 text-sm text-gray-200 hover:text-white">
                        Berita
                    </a>

                    <!-- Kontak -->
                    <a href="{{ auth()->check() ? route('kontak') : route('login') }}"
                       class="inline-flex items-center px-1 pt-1 text-sm text-gray-200 hover:text-white">
                        Kontak
                    </a>
                </div>
            </div>

            <!-- Right Desktop -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                @auth
                    <span class="text-white text-sm">{{ auth()->user()->name }}</span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-red-500 text-white rounded text-xs hover:bg-red-600">
                            Logout
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 bg-white text-green-600 rounded text-xs font-semibold hover:bg-gray-100">
                        Login
                    </a>
                @endguest
            </div>

            <!-- Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" class="focus:outline-none">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-transition class="sm:hidden bg-green-700">
        <div class="px-4 pt-4 pb-2 space-y-1">

            <a href="{{ route('dashboard') }}" class="block text-white hover:bg-green-600 px-2 py-1 rounded">Beranda</a>
            <a href="{{ auth()->check() ? route('tentang') : route('login') }}" class="block text-white hover:bg-green-600 px-2 py-1 rounded">Tentang</a>
            <a href="{{ auth()->check() ? route('alumni.data') : route('login') }}" class="block text-white hover:bg-green-600 px-2 py-1 rounded">Data Alumni</a>
            <a href="{{ route('testimoni.index') }}" class="block text-white hover:bg-green-600 px-2 py-1 rounded">Testimoni</a>
</xai:function_call}

<xai:function_call name="edit_file">
<parameter name="path">resources/views/layouts/navigation.blade.php
            <a href="{{ auth()->check() ? route('alumni.agenda') : route('login') }}" class="block text-white hover:bg-green-600 px-2 py-1 rounded">Agenda</a>
            <a href="{{ auth()->check() ? route('berita.index') : route('login') }}" class="block text-white hover:bg-green-600 px-2 py-1 rounded">Berita</a>
            <a href="{{ auth()->check() ? route('kontak') : route('login') }}" class="block text-white hover:bg-green-600 px-2 py-1 rounded">Kontak</a>

            @auth
                <div class="border-t border-green-500 pt-2">
                    <div class="text-white text-sm mb-2">{{ auth()->user()->name }}</div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-left text-red-300 hover:text-red-400 px-2 py-1 rounded">
                            Logout
                        </button>
                    </form>
                </div>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="block text-white hover:bg-green-600 px-2 py-1 rounded">Login</a>
            @endguest
        </div>
    </div>
</nav>
