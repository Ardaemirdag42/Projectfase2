@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-center">Alle Reviews</h1>

    <!-- Knop naar create review pagina -->
    @auth
        <div class="mb-6 text-center">
            <a href="{{ route('reviews.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md shadow">
                Nieuwe Review Plaatsen
            </a>
        </div>
    @endauth

    <!-- Filter dropdown -->
    <div class="mb-6 flex justify-center">
        <form method="GET" action="{{ route('reviews.index') }}" class="flex gap-2 items-center">
            <label for="game_id" class="font-medium">Filter op game:</label>
            <select name="game_id" id="game_id" class="border rounded px-3 py-1">
                <option value="">Alle games</option>
                @foreach($games as $game)
                    <option value="{{ $game->id }}" {{ request('game_id') == $game->id ? 'selected' : '' }}>
                        {{ $game->title }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">Filter</button>
        </form>
    </div>

    <!-- Reviews lijst -->
    <div class="space-y-6">
        @forelse($reviews as $review)
            <div class="bg-white shadow-md rounded-lg p-6 relative">
                <h3 class="text-lg font-semibold mb-1">
                    {{ $review->game->title }} - {{ $review->rating }}/5 ⭐
                </h3>

                <p class="mb-3 text-gray-700">{{ $review->content }}</p>

                <small class="text-gray-500 block mb-3">
                    Geschreven door: {{ $review->user->name }}
                    op {{ $review->created_at->format('d-m-Y') }}
                </small>

                {{-- Alleen admins zien deze knop --}}
                @auth
                    @if(auth()->user()->is_admin)
                        <form
                            action="{{ route('reviews.destroy', $review) }}"
                            method="POST"
                            onsubmit="return confirm('Weet je zeker dat je deze review wilt verwijderen?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm"
                            >
                                Verwijderen
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        @empty
            <p class="text-gray-600 text-center">Geen reviews gevonden.</p>
        @endforelse
    </div>
</div>
@endsection