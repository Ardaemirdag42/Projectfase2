@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded shadow">

    <h1 class="text-3xl font-bold mb-6">🛒 Mijn Winkelmandje</h1>

    {{-- Success message --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Check of de cart leeg is --}}
    @if(!session('cart') || count(session('cart')) === 0)
        <p class="text-gray-600 text-lg">
            Je winkelmandje is leeg.
        </p>
    @else
        {{-- Cart table --}}
        <table class="w-full border-collapse mb-6">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 text-left">Game</th>
                    <th class="p-2 text-center">Aantal</th>
                    <th class="p-2 text-center">Prijs</th>
                    <th class="p-2 text-center">Subtotaal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp

                @foreach(session('cart') as $item)
                    @php
                        // Gebruik altijd een fallback als quantity ontbreekt
                        $qty = $item['quantity'] ?? 1;
                        $subtotal = $item['price'] * $qty;
                        $total += $subtotal;
                    @endphp
                    <tr class="border-t">
                        <td class="p-2">{{ $item['title'] }}</td>
                        <td class="p-2 text-center">{{ $qty }}</td>
                        <td class="p-2 text-center">€{{ number_format($item['price'], 2, ',', '.') }}</td>
                        <td class="p-2 text-center">€{{ number_format($subtotal, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Totaal en checkout knop --}}
        <div class="flex justify-between items-center">
            <p class="text-xl font-bold">
                Totaal: €{{ number_format($total, 2, ',', '.') }}
            </p>

            <form method="POST" action="{{ route('cart.checkout') }}">
                @csrf
                <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">
                    Betalen
                </button>
            </form>
        </div>
    @endif
</div>
@endsection
