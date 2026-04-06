@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        Alumni Pending Approval
    </h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Prodi</th>
                    <th class="px-4 py-2 text-left">Angkatan</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($alumni as $item)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $item->nama }}</td>
                        <td class="px-4 py-2">{{ $item->prodi }}</td>
                        <td class="px-4 py-2">{{ $item->angkatan }}</td>
                        <td class="px-4 py-2">{{ $item->email }}</td>
                        <td class="px-4 py-2 text-center flex gap-2 justify-center">

                            <!-- APPROVE -->
                            <form action="{{ route('admin.alumni.approve', $item->id) }}" method="POST">
                                @csrf
                                <button class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                    Approve
                                </button>
                            </form>

                            <!-- REJECT -->
                            <form action="{{ route('admin.alumni.reject', $item->id) }}" method="POST">
                                @csrf
                                <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                    Reject
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                            Tidak ada data pending
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
