@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10">

    <h1 class="text-3xl font-bold mb-6">🎮 Mijn Bibliotheek</h1>

    {{-- Succesbericht bij nieuwe aankoop --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-6 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($items->isEmpty())
        <p class="text-gray-600 text-lg">
            Je hebt nog geen games in je bibliotheek.
        </p>
    @else
        <div class="space-y-4">
            @foreach($items as $item)
                <div class="flex border rounded shadow p-4 bg-white items-center">
                    {{-- Afbeelding vierkant --}}
                    @if($item->game && $item->game->file_path)
                        <img src="{{ asset($item->game->file_path) }}" 
                             alt="{{ $item->game->title }}" 
                             class="w-32 h-32 object-cover rounded mr-4 shrink-0">
                    @else
                        <div class="w-32 h-32 bg-gray-200 rounded mr-4 shrink-0 flex items-center justify-center">
                            Geen afbeelding
                        </div>
                    @endif

                    <div class="flex-1">
                        {{-- Titel & beschrijving --}}
                        <h2 class="text-xl font-bold mb-1">{{ $item->game ? $item->game->title : 'Onbekend spel' }}</h2>
                        <p class="text-gray-700 mb-2">{{ $item->game ? $item->game->description : '' }}</p>

                        {{-- Datum/tijd van aankoop --}}
                        <p class="text-sm text-gray-500 mb-2">
                            Gekocht op: {{ $item->created_at->format('d-m-Y H:i') }}
                        </p>

                        {{-- Prijs --}}
                        @if($item->game)
                            <p class="text-green-600 font-semibold mb-2">
                                €{{ number_format($item->game->price, 2, ',', '.') }}
                            </p>
                        @endif

                        {{-- Download knop (prototype) --}}
                        @if($item->game && $item->game->file_path)
                            <a href="{{ asset($item->game->file_path) }}" 
                               download="{{ $item->game->title }}.zip"
                               class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                Download
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
