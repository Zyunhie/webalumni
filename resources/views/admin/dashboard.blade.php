@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-green-700">
        Dashboard Admin
    </h1>

    <p class="mt-2 text-gray-600">
        Selamat datang, {{ auth()->user()->name }} 👋
    </p>
</div>
@endsection
