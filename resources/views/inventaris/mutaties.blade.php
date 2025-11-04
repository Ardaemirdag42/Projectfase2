<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Mutaties voor: {{ $item->naam }}
        </h2>
    </x-slot>

    <div class="p-6">
        <a href="{{ route('inventaris.index') }}" class="text-blue-600">&larr; Terug naar overzicht</a>

        @if (session('success'))
            <div class="mt-4 bg-green-100 p-2 rounded text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <h3 class="mt-6 text-lg font-semibold">Nieuwe mutatie toevoegen</h3>
        <form action="{{ route('inventaris.voegMutatieToe', $item->id) }}" method="POST" class="mt-2">
            @csrf
            <div class="mb-2">
                <label>Type:</label>
                <select name="type" class="border p-2 rounded">
                    <option value="inkomend">Inkomend</option>
                    <option value="uitgaand">Uitgaand</option>
                </select>
            </div>
            <div class="mb-2">
                <label>Aantal:</label>
                <input type="number" name="aantal" class="border p-2 w-32" required>
            </div>
            <div class="mb-2">
                <label>Opmerking (optioneel):</label>
                <input type="text" name="opmerking" class="border p-2 w-full">
            </div>
            <button type="submit" class="bg-blue-500 text-orange px-4 py-2 rounded">Opslaan</button>
        </form>

        <h3 class="mt-6 text-lg font-semibold">Mutatiegeschiedenis</h3>
        <table class="mt-2 w-full border-collapse border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Datum</th>
                    <th class="border p-2">Type</th>
                    <th class="border p-2">Aantal</th>
                    <th class="border p-2">Opmerking</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mutaties as $m)
                    <tr>
                        <td class="border p-2">{{ $m->created_at->format('d-m-Y H:i') }}</td>
                        <td class="border p-2">{{ ucfirst($m->type) }}</td>
                        <td class="border p-2">{{ $m->aantal }}</td>
                        <td class="border p-2">{{ $m->opmerking ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
