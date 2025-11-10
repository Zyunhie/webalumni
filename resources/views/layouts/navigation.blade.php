<nav x-data="{ open: false }" class="bg-green-600 border-b border-green-700 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <!-- Left: Logo + Navigation -->
            <div class="flex items-center">
                
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/logo-iait.png') }}" alt="Logo IAIT" class="block h-10 w-auto">
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    
                    <!-- Beranda -->
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out
                              {{ request()->routeIs('home') ? 'border-white' : 'border-transparent' }}">
                        {{ __('Beranda') }}
                    </a>

                    <!-- Tentang -->
                    <a href="{{ route('tentang') }}" 
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out
                              {{ request()->routeIs('tentang') ? 'border-white' : 'border-transparent' }}">
                        {{ __('Tentang') }}
                    </a>

                    <!-- Alumni Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ms-6" x-data="{ openDropdown: false }">
                        <button @click="openDropdown = !openDropdown" 
                                @click.away="openDropdown = false"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md transition ease-in-out duration-150">
                            <div>{{ __('Alumni') }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>

                        <!-- Dropdown Content -->
                        <div x-show="openDropdown"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="dropdown-content absolute z-50 mt-2 w-48 rounded-md shadow-lg origin-top-left left-0"
                             style="display: none;">
                            <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white">
                                <a href="{{ route('alumni.data') }}" 
                                   class="block px-4 py-2 text-sm leading-5 transition duration-150 ease-in-out">
                                    {{ __('Data Alumni') }}
                                </a>
                                <a href="{{ route('alumni.testimoni') }}" 
                                   class="block px-4 py-2 text-sm leading-5 transition duration-150 ease-in-out">
                                    {{ __('Testimoni Alumni') }}
                                </a>
                                <a href="{{ route('alumni.agenda') }}" 
                                   class="block px-4 py-2 text-sm leading-5 transition duration-150 ease-in-out">
                                    {{ __('Agenda') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Berita -->
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out
                              {{ request()->routeIs('dashboard') ? 'border-white' : 'border-transparent' }}">
                        {{ __('Berita') }}
                    </a>

                    <!-- Kontak -->
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out
                              {{ request()->routeIs('dashboard') ? 'border-white' : 'border-transparent' }}">
                        {{ __('Kontak') }}
                    </a>
                </div>
            </div>

            <!-- Right: Login Button (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center px-4 py-2 bg-white border border-transparent rounded-md font-semibold text-xs text-green-600 uppercase tracking-widest hover:bg-green-50 focus:bg-green-50 active:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Login') }}
                </a>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" 
                        class="inline-flex items-center justify-center p-2 rounded-md transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-green-700">
        <div class="pt-2 pb-3 space-y-1">
            
            <!-- Beranda Mobile -->
            <a href="{{ route('home') }}" 
               class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out
                      {{ request()->routeIs('home') ? 'border-white' : 'border-transparent' }}">
                {{ __('Beranda') }}
            </a>

            <!-- Tentang Mobile -->
            <a href="{{ route('tentang') }}" 
               class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out
                      {{ request()->routeIs('tentang') ? 'border-white' : 'border-transparent' }}">
                {{ __('Tentang') }}
            </a>

            <!-- Alumni Dropdown Mobile -->
            <div x-data="{ alumniOpen: false }" class="border-t border-green-600">
                <button @click="alumniOpen = ! alumniOpen" 
                        class="w-full flex items-center justify-between ps-3 pe-4 py-2 text-start text-base font-medium transition duration-150 ease-in-out">
                    <span>{{ __('Alumni') }}</span>
                    <svg class="h-4 w-4 transition-transform duration-200" :class="{'rotate-180': alumniOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                
                <div x-show="alumniOpen" class="bg-green-800">
                    <a href="{{ route('alumni.data') }}" 
                       class="block w-full ps-8 pe-4 py-2 text-start text-base font-medium transition duration-150 ease-in-out">
                        {{ __('Data Alumni') }}
                    </a>
                    <a href="{{ route('alumni.testimoni') }}" 
                       class="block w-full ps-8 pe-4 py-2 text-start text-base font-medium transition duration-150 ease-in-out">
                        {{ __('Testimoni Alumni') }}
                    </a>
                    <a href="{{ route('alumni.agenda') }}" 
                       class="block w-full ps-8 pe-4 py-2 text-start text-base font-medium transition duration-150 ease-in-out">
                        {{ __('Agenda') }}
                    </a>
                </div>
            </div>

            <!-- Berita Mobile -->
            <a href="{{ route('dashboard') }}" 
               class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out
                      {{ request()->routeIs('dashboard') ? 'border-white' : 'border-transparent' }}">
                {{ __('Berita') }}
            </a>

            <!-- Kontak Mobile -->
            <a href="{{ route('dashboard') }}" 
               class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out
                      {{ request()->routeIs('dashboard') ? 'border-white' : 'border-transparent' }}">
                {{ __('Kontak') }}
            </a>
        </div>

        <!-- Responsive Login Button -->
        <div class="pt-4 pb-1 border-t border-green-600">
            <div class="px-4">
                <a href="{{ route('login') }}" 
                   class="block w-full px-4 py-2 bg-white text-center rounded-md font-semibold text-xs text-green-600 uppercase tracking-widest hover:bg-green-50 focus:bg-green-50 active:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Login') }}
                </a>
            </div>
        </div>
    </div>
</nav>