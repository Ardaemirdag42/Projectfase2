@extends('layouts.app')
@section('content')
<div class="container mx-auto p-6">
<h1 class="text-3xl font-bold mb-6">Alle Games</h1>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
@foreach($games as $game)
<div class="p-4 border rounded-lg shadow">
<h2 class="text-xl font-semibold">{{ $game->title }}</h2>
<p class="text-gray-600 mt-2">{{ Str::limit($game->description, 100) }}</p>
<a href="{{ route('games.show', $game) }}" class="text-blue-500 mt-4 inline-block">Bekijk game</a>
</div>
@endforeach
</div>
</div>
@endsection