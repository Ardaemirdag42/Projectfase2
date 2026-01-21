@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6">Mijn Bibliotheek</h1>

    @if($games->isEmpty())
        <p class="text-gray-600">Je hebt nog geen games in je bibliotheek.</p>
    @else
        <ul class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($games as $game)
                <li class="border p-4 rounded bg-white shadow">
                    <h2 class="font-bold">{{ $game->title }}</h2>
                    <p>{{ $game->description }}</p>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
