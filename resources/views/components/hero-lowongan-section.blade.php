@php
    $HeroLowongan = $HeroLowongan ?? null;
@endphp

<!-- ================= HERO SECTION (LOWONGAN) ================= -->
<section class="relative h-[400px] bg-cover bg-center overflow-hidden"
    style="background-image: url('{{ $HeroLowongan ? Storage::url($HeroLowongan->gambar) : asset('images/Branda.jpg') }}');">

    @if(auth()->check() && trim(auth()->user()->role) === 'admin')
        <a href="{{ route('admin.hero.index') }}"
            class="absolute bottom-4 right-4 z-10 bg-white bg-opacity-90 hover:bg-opacity-100 text-green-700 font-semibold text-xs px-4 py-2 rounded-full shadow-lg transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Kelola Slider
        </a>
    @endif
</section>

