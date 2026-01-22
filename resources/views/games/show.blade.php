@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-3xl bg-white rounded shadow">
    {{-- Titel --}}
    <h1 class="text-3xl font-bold mb-4">{{ $game->title }}</h1>

    {{-- Console --}}
    <p class="text-gray-500 italic mb-2">Console: {{ $game->console }}</p>

    {{-- Prijs --}}
    <p class="text-green-600 font-semibold mb-4">Prijs: €{{ number_format($game->price, 2, ',', '.') }}</p>

    {{-- Afbeelding --}}
    @if($game->file_path)
        <img src="{{ asset($game->file_path) }}" alt="{{ $game->title }}" class="mb-4 w-full h-auto rounded shadow">
    @endif

    {{-- Volledige beschrijving --}}
    <p class="text-gray-700 mb-4">{{ $game->description }}</p>

    {{-- Gemiddelde rating en aantal reviews --}}
    <p class="text-yellow-600 font-semibold mb-4">
        ⭐ Gemiddelde rating: {{ number_format($game->averageRating(), 1) ?? '0.0' }} 
        ({{ $game->reviews->count() }} reviews)
    </p>

    {{-- Admin acties --}}
    @auth
        @if(auth()->user()->is_admin)
            <div class="mb-4 flex gap-2">
                <a href="{{ route('games.edit', $game->id) }}" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                    Bewerk game
                </a>

                <form action="{{ route('games.destroy', $game->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze game wilt verwijderen?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                        Verwijder game
                    </button>
                </form>
            </div>
        @endif
    @endauth

    {{-- Terug naar overzicht --}}
    <a href="{{ route('games.index') }}" class="text-blue-500 hover:underline mt-4 inline-block">
        ← Terug naar alle games
    </a>
</div>
@endsection
