<nav x-data="{ open: false }" class="bg-green-600 border-b border-green-700 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Left -->
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <img src="{{ asset('images/logo-iait.png') }}" class="h-10" alt="Logo IAIT">
                </a>

                <!-- Desktop Menu -->
                <div class="hidden sm:flex sm:space-x-8 sm:ml-10">
                    <a href="{{ route('dashboard') }}"
                       class="text-white border-b-2 px-1 pt-1 text-sm
                       {{ request()->routeIs('dashboard') ? 'border-white' : 'border-transparent' }}">
                        Beranda
                    </a>

                    <a href="{{ route('tentang') }}"
                       class="text-white border-b-2 px-1 pt-1 text-sm
                       {{ request()->routeIs('tentang') ? 'border-white' : 'border-transparent' }}">
                        Tentang
                    </a>

                    <!-- Alumni Dropdown -->
                    <div class="relative" x-data="{ openDropdown: false }">
                        <button @click="openDropdown = !openDropdown"
                                class="text-white text-sm inline-flex items-center">
                            Alumni
                            <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5.293 7.293L10 12l4.707-4.707"/>
                            </svg>
                        </button>

                        <div x-show="openDropdown" @click.away="openDropdown = false"
                             class="absolute mt-2 w-48 bg-white rounded shadow-lg z-50">
                            <a href="{{ route('alumni.data') }}" class="block px-4 py-2 text-sm">Data Alumni</a>
                            <a href="{{ route('testimoni.index') }}" class="block px-4 py-2 text-sm">Testimoni</a>
</xai:function_call)

<xai:function_call name="edit_file">
<parameter name="path">resources/views/components/header.blade.php
                            <a href="{{ route('alumni.agenda') }}" class="block px-4 py-2 text-sm">Agenda</a>
                        </div>
                    </div>

                    <a href="{{ route('dashboard') }}" class="text-white text-sm">Berita</a>
                    <a href="{{ route('kontak') }}" class="text-white text-sm">Kontak</a>
                </div>
            </div>

            <!-- Right Desktop -->
            <div class="hidden sm:flex sm:items-center space-x-4">

                @auth
                    <span class="text-white text-sm">
                        {{ auth()->user()->name ?? auth()->user()->nim }}
                    </span>

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
                       class="px-4 py-2 bg-white text-green-600 rounded text-xs font-semibold">
                        Login
                    </a>
                @endguest
            </div>

            <!-- Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" class="sm:hidden bg-green-700">
        <div class="px-4 pt-4 pb-2 space-y-2">
            <a href="{{ route('dashboard') }}" class="block text-white">Beranda</a>
            <a href="{{ route('tentang') }}" class="block text-white">Tentang</a>
            <a href="{{ route('alumni.data') }}" class="block text-white">Data Alumni</a>

            @auth
                <div class="border-t border-green-500 pt-2">
                    <div class="text-white text-sm mb-2">
                        {{ auth()->user()->name ?? auth()->user()->nim }}
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-left text-red-300">
                            Logout
                        </button>
                    </form>
                </div>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="block text-white">Login</a>
            @endguest
        </div>
    </div>
</nav>
