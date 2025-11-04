<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Inventarisbeheer
        </h2>
    </x-slot>

    <div class="p-6">
        <!-- Nieuwe artikel knop -->
        <a href="{{ route('inventaris.create') }}" class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600">
            Nieuw artikel
        </a>

        <!-- Succesmelding -->
        @if (session('success'))
            <div class="mt-4 bg-green-100 border-l-4 border-green-500 p-3 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel met voorraad -->
        <table class="mt-6 w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="border border-gray-300 p-2">Naam</th>
                    <th class="border border-gray-300 p-2">Categorie</th>
                    <th class="border border-gray-300 p-2">Aantal</th>
                    <th class="border border-gray-300 p-2">Locatie</th>
                    <th class="border border-gray-300 p-2 w-1/4">Acties</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 p-2">{{ $item->naam }}</td>
                        <td class="border border-gray-300 p-2">{{ $item->categorie }}</td>

                        <!-- Voorraad + waarschuwing -->
                        <td class="border border-gray-300 p-2">
                            @if ($item->aantal <= $item->minimum)
                                <span class="text-red-600 font-bold">{{ $item->aantal }} ⚠️</span>
                            @else
                                {{ $item->aantal }}
                            @endif
                        </td>

                        <td class="border border-gray-300 p-2">{{ $item->locatie }}</td>

                        <!-- Actieknoppen -->
                        <td class="border border-gray-300 p-2 space-x-2">
                            <a href="{{ route('inventaris.mutaties', $item->id) }}" class="text-green-600 hover:underline">
                                Mutaties
                            </a> |
                            <a href="{{ route('inventaris.edit', $item->id) }}" class="text-blue-600 hover:underline">
                                Bewerken
                            </a> |
                            <form action="{{ route('inventaris.destroy', $item->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline"
                                    onclick="return confirm('Weet je het zeker dat je dit artikel wilt verwijderen?')">
                                    Verwijderen
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-4">
                            Geen artikelen gevonden.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
