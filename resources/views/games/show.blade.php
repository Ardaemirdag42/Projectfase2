@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-3xl bg-white rounded shadow">

    {{-- Titel --}}
    <h1 class="text-3xl font-bold mb-4">{{ $game->title }}</h1>

    {{-- Console --}}
    <p class="text-gray-500 italic mb-2">
        Console: {{ $game->console }}
    </p>

    {{-- Prijs --}}
    <p class="text-green-600 font-semibold mb-4">
        Prijs: €{{ number_format($game->price, 2, ',', '.') }}
    </p>

    {{-- Afbeelding --}}
    @if($game->file_path)
        <img src="{{ asset($game->file_path) }}"
             alt="{{ $game->title }}"
             class="mb-4 w-full h-auto rounded shadow">
    @endif

    {{-- Beschrijving --}}
    <p class="text-gray-700 mb-6">
        {{ $game->description }}
    </p>

    {{-- Rating --}}
    <p class="text-yellow-600 font-semibold mb-6">
        ⭐ Gemiddelde rating:
        {{ number_format($game->averageRating() ?? 0, 1) }}
        ({{ $game->reviews->count() }} reviews)
    </p>

    {{-- Toevoegen aan winkelmandje (ALLEEN gewone gebruikers) --}}
    @auth
        @if(!auth()->user()->is_admin)
            <button
                onclick="addToCart({{ $game->id }})"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded mb-6">
                🛒 Voeg toe aan winkelmandje
            </button>
        @endif
    @endauth

    {{-- Admin acties --}}
    @auth
        @if(auth()->user()->is_admin)
            <div class="mb-6 flex gap-2">
                <a href="{{ route('games.edit', $game->id) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                    Bewerk game
                </a>

                <form action="{{ route('games.destroy', $game->id) }}"
                      method="POST"
                      onsubmit="return confirm('Weet je zeker dat je deze game wilt verwijderen?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                        Verwijder game
                    </button>
                </form>
            </div>
        @endif
    @endauth

    {{-- Terug --}}
    <a href="{{ route('games.index') }}"
       class="text-blue-500 hover:underline inline-block">
        ← Terug naar alle games
    </a>
</div>

{{-- Popup --}}
<div id="cartPopup"
     class="fixed top-6 right-6 bg-green-600 text-white px-4 py-3 rounded shadow hidden z-50">
    ✅ Toegevoegd aan winkelmandje
</div>

<script>
function addToCart(gameId) {
    fetch(`/cart/add/${gameId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const popup = document.getElementById('cartPopup');
            popup.classList.remove('hidden');

            setTimeout(() => {
                popup.classList.add('hidden');
            }, 2000);
        }
    });
}
</script>
@endsection
