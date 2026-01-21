@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h1 class="text-2xl font-bold mb-6 text-center">Nieuwe Review Plaatsen</h1>

    <form action="{{ route('reviews.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Game select -->
        <div>
            <label for="game_id" class="block font-medium mb-1">Selecteer Game:</label>
            <select name="game_id" id="game_id" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @foreach($games as $game)
                    <option value="{{ $game->id }}">{{ $game->title }}</option>
                @endforeach
            </select>
        </div>

        <!-- Rating sterren -->
        <div>
            <label class="block font-medium mb-1">Rating:</label>
            <div class="flex space-x-1">
                @for ($i = 1; $i <= 5; $i++)
                    <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" class="hidden" required>
                    <label for="star{{ $i }}" class="cursor-pointer text-3xl text-gray-300 hover:text-yellow-400 transition-colors">
                        ★
                    </label>
                @endfor
            </div>
        </div>

        <!-- Review content -->
        <div>
            <label for="content" class="block font-medium mb-1">Review:</label>
            <textarea name="content" rows="4" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
        </div>

        <!-- Submit knop -->
        <div class="text-center">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md shadow">
                Plaats Review
            </button>
        </div>
    </form>
</div>

<!-- Optioneel: kleine JS om hover sterren mooi te laten kleuren -->
<script>
    const stars = document.querySelectorAll('label[for^="star"]');
    stars.forEach((star, idx) => {
        star.addEventListener('mouseover', () => {
            for (let i = 0; i <= idx; i++) {
                stars[i].classList.add('text-yellow-400');
            }
            for (let i = idx + 1; i < stars.length; i++) {
                stars[i].classList.remove('text-yellow-400');
            }
        });
        star.addEventListener('mouseout', () => {
            stars.forEach(s => s.classList.remove('text-yellow-400'));
            const checked = document.querySelector('input[name="rating"]:checked');
            if (checked) {
                for (let i = 0; i < parseInt(checked.value); i++) {
                    stars[i].classList.add('text-yellow-400');
                }
            }
        });
    });

    // Zet gekleurde sterren voor geselecteerde rating bij laden
    const checked = document.querySelector('input[name="rating"]:checked');
    if (checked) {
        for (let i = 0; i < parseInt(checked.value); i++) {
            stars[i].classList.add('text-yellow-400');
        }
    }

    // Update kleuren bij selecteren
    const radios = document.querySelectorAll('input[name="rating"]');
    radios.forEach(radio => {
        radio.addEventListener('change', () => {
            stars.forEach(s => s.classList.remove('text-yellow-400'));
            for (let i = 0; i < parseInt(radio.value); i++) {
                stars[i].classList.add('text-yellow-400');
            }
        });
    });
</script>
@endsection
