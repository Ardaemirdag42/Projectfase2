@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-center">Game Bewerken</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('games.update', $game) }}">
        @csrf
        @method('PUT')

        <input type="text" name="title" placeholder="Titel" value="{{ old('title', $game->title) }}"
               class="w-full border px-3 py-2 rounded mb-4" required>

        <select name="console" class="w-full border px-3 py-2 rounded mb-4">
        @foreach($consoles as $console)
        <option value="{{ $console->name }}"
            {{ old('console', $game->console ?? '') == $console->name ? 'selected' : '' }}>
            {{ $console->name }}
        </option>
    @endforeach
</select>


        <textarea name="description" placeholder="Beschrijving"
                  class="w-full border px-3 py-2 rounded mb-4">{{ old('description', $game->description) }}</textarea>

        <input type="number" name="price" placeholder="Prijs" step="0.01"
               value="{{ old('price', $game->price) }}" class="w-full border px-3 py-2 rounded mb-4" required>

        <input type="text" name="file_path" placeholder="Bestandspad (optioneel)"
               value="{{ old('file_path', $game->file_path) }}" class="w-full border px-3 py-2 rounded mb-4">

        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded w-full">
            Game Bijwerken
        </button>
    </form>
</div>
@endsection
