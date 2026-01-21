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

    <!-- Reviews lijst -->
    <div class="space-y-6">
        @foreach($reviews as $review) <!-- <--- loop over alle reviews -->
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
        @endforeach
    </div>
</div>
@endsection
