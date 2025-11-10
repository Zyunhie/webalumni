<header x-data="{ open: false }" class="bg-green-600 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('welcome') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo IAIT" class="h-10 w-auto">
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden sm:flex sm:space-x-8 sm:mx-auto">
                <a href="{{ route('welcome') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('welcome') ? 'border-white' : 'border-transparent' }}">Beranda</a>
                <a href="{{ route('tentang') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('tentang') ? 'border-white' : 'border-transparent' }}">Tentang</a>

                <!-- Alumni Dropdown -->
                <div x-data="{ openDropdown: false }" class="relative">
                    <button @click="openDropdown = !openDropdown" @click.away="openDropdown = false" class="inline-flex items-center px-3 pt-1 text-sm font-medium border-b-2 border-transparent hover:border-white transition">
                        Alumni
                        <svg class="ml-1 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="openDropdown" x-transition class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white text-gray-800 z-50" style="display: none;">
                        <a href="{{ route('alumni.data') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Data Alumni</a>
                        <a href="{{ route('alumni.testimoni') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Testimoni</a>
                        <a href="{{ route('alumni.agenda') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Agenda</a>
                    </div>
                </div>

                <a href="{{ route('berita') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('berita') ? 'border-white' : 'border-transparent' }}">Berita</a>
                <a href="{{ route('kontak') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('kontak') ? 'border-white' : 'border-transparent' }}">Kontak</a>
            </div>

            <!-- Login Button -->
            <div class="hidden sm:flex sm:items-center">
                <a href="{{ route('login') }}" class="px-4 py-2 bg-white text-green-600 font-semibold text-sm rounded hover:bg-green-50 transition">
                    Login
                </a>
            </div>
        </div>
    </div>
</header>
