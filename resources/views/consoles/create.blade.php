@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-center">Nieuwe Console Toevoegen</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('consoles.store') }}">
        @csrf
        <input type="text" name="name" placeholder="Console Naam" class="w-full border px-3 py-2 rounded mb-4" required>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded w-full">
            Console Toevoegen
        </button>
    </form>
</div>
@endsection
