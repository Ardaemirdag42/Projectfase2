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
        @foreach($reviews as $review)
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-1">{{ $review->game->title }} - {{ $review->rating }}/5 ⭐</h3>
                <p class="mb-3 text-gray-700">{{ $review->content }}</p>
                <small class="text-gray-500">Geschreven door: {{ $review->user->name }} op {{ $review->created_at->format('d-m-Y') }}</small>
            </div>
        @endforeach
    </div>
</div>
@endsection
