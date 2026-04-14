@forelse($alumni as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $item->nama }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $item->nim ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        <a href="{{ route($routePrefix . '.index', array_merge(request()->except('prodi'), ['prodi' => $item->prodi])) }}" 
                           class="text-blue-600 hover:underline">
                            {{ $item->prodi }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $item->angkatan ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-center space-x-2">
                        @auth
                            <a href="{{ route($routePrefix . '.show', $item->id) }}" class="text-blue-600 hover:underline">Detail</a>

                            @if(auth()->user()->role == 'admin')
                                <a href="{{ route($routePrefix . '.edit', $item->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                                <form action="{{ route($routePrefix . '.destroy', $item->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                                </form>
                            @elseif($item->user_id == auth()->id())
                                <a href="{{ route($routePrefix . '.edit', $item->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                                @if(!$item->ijazah || !$item->transkrip)
                                    <a href="{{ route($routePrefix . '.upload', $item->id) }}" class="text-green-600 hover:underline">Upload</a>
                                @endif
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        @else
                            @if($item->status == 'approved')
                                <a href="{{ route($routePrefix . '.show', $item->id) }}" class="text-blue-600 hover:underline">Detail</a>
                            @else
                                <span class="text-gray-400">Tidak tersedia</span>
                            @endif
                        @endauth
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada data alumni.</td>
                </tr>
                @endforelse
