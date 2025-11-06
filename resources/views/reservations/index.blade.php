<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reserveringssysteem
        </h2>
    </x-slot>

    <div class="p-6">
        <!-- Success / Error messages -->
        @if(session('success'))
            <div class="mt-4 bg-green-100 border-l-4 border-green-500 p-3 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mt-4 bg-red-100 border-l-4 border-red-500 p-3 text-red-800 rounded">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Link naar nieuwe reservering -->
        <a href="/reservations/create" class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600">
            Nieuwe Reservering
        </a>

        <!-- Tabel met reserveringen -->
        <table class="mt-6 w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="border border-gray-300 p-2">Medewerker</th>
                    <th class="border border-gray-300 p-2">Item</th>
                    <th class="border border-gray-300 p-2">Datum</th>
                    <th class="border border-gray-300 p-2">Tijd</th>
                    <th class="border border-gray-300 p-2">Acties</th>
                    <th class="border border-gray-300 p-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 p-2">{{ $reservation->employee_name }}</td>
                        <td class="border border-gray-300 p-2">{{ $reservation->inventaris }}</td>
                        <td class="border border-gray-300 p-2">{{ $reservation->date }}</td>
                        <td class="border border-gray-300 p-2">{{ $reservation->time }}</td>
                        <td class="border border-gray-300 p-2">{{ $reservation->status }}</td>
                        <td class="border border-gray-300 p-2 space-x-2">
                            <a href="/reservations/{{ $reservation->id }}/edit" class="text-blue-600 hover:underline">Bewerken</a>
                            <form action="/reservations/{{ $reservation->id }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline"
                                        onclick="return confirm('Weet je het zeker?')">Verwijderen</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
