@extends('layouts.app')
@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-center">Alle Games</h1>

    {{-- Alleen zichtbaar voor admins --}}
    @auth
        @if(auth()->user()->is_admin)
            <div class="mb-6 text-center">
                <a href="{{ route('games.create') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-md shadow">
                    Game Toevoegen
                </a>
            </div>
        @endif
    @endauth

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($games as $game)
            <div class="p-4 border rounded-lg shadow">
                <h2 class="text-xl font-semibold">{{ $game->title }}</h2>

                {{-- Console van de game --}}
                <p class="text-gray-500 italic mt-1">Console: {{ $game->console }}</p>

                {{-- Gemiddelde beoordeling en aantal reviews --}}
                <p class="text-yellow-600 font-semibold mt-1">
                    ⭐ Gemiddelde rating: {{ number_format($game->averageRating(), 1) ?? '0.0' }} 
                    ({{ $game->reviews->count() }} reviews)
                </p>

                <p class="text-gray-600 mt-2">{{ Str::limit($game->description, 100) }}</p>
                <a href="{{ route('games.show', $game) }}" class="text-blue-500 mt-4 inline-block">Bekijk game</a>
            </div>
        @endforeach
    </div>
</div>
@endsection