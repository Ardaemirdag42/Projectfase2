@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-center">Nieuwe Game Toevoegen</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            <ul>
                @foreach($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('games.store') }}">
        @csrf

        <input type="text" name="title" placeholder="Titel" class="w-full border px-3 py-2 rounded mb-4" required>
        <input type="text" name="console" placeholder="Console" class="w-full border px-3 py-2 rounded mb-4" required>
        <textarea name="description" placeholder="Beschrijving" class="w-full border px-3 py-2 rounded mb-4"></textarea>
        <input type="number" name="price" placeholder="Prijs" step="0.01" class="w-full border px-3 py-2 rounded mb-4" required>
        <input type="text" name="file_path" placeholder="Bestandspad (optioneel)" class="w-full border px-3 py-2 rounded mb-4">

        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded w-full">
            Game Toevoegen
        </button>
    </form>
</div>
@endsection
