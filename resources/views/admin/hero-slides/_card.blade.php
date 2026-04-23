<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden relative">

    <div class="aspect-video">
        <img src="{{ Storage::url($slide->gambar) }}" alt="Slide"
            class="w-full h-full object-cover {{ !$slide->aktif ? 'opacity-40 grayscale' : '' }}">
    </div>

    <div class="absolute top-2 left-2">
        <span class="text-xs font-bold px-2 py-0.5 rounded-full {{ $slide->aktif ? 'bg-green-500 text-white' : 'bg-gray-400 text-white' }}">
            {{ $slide->aktif ? 'Aktif' : 'Nonaktif' }}
        </span>
    </div>

    <div class="p-3 flex gap-2">
        <button onclick='openModal(@json($slide))'
            class="flex-1 text-xs font-semibold text-green-600 border border-green-200 hover:bg-green-600 hover:text-white py-1.5 rounded-lg transition">
            Ganti Foto
        </button>
        <form action="{{ route('admin.hero.destroy', $slide) }}" method="POST"
            onsubmit="return confirm('Hapus foto ini?')">
            @csrf @method('DELETE')
            <button type="submit"
                class="text-xs font-semibold text-red-500 border border-red-200 hover:bg-red-500 hover:text-white px-3 py-1.5 rounded-lg transition">
                Hapus
            </button>
        </form>
    </div>

</div>