<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Artikel bewerken</h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('inventaris.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label>Naam</label>
                <input type="text" name="naam" value="{{ $item->naam }}" class="border p-2 w-full">
            </div>
            <div class="mb-4">
                <label>Categorie</label>
                <input type="text" name="categorie" value="{{ $item->categorie }}" class="border p-2 w-full">
            </div>
            <div class="mb-4">
                <label>Aantal</label>
                <input type="number" name="aantal" value="{{ $item->aantal }}" class="border p-2 w-full">
            </div>
            <div class="mb-4">
                <label>Locatie</label>
                <input type="text" name="locatie" value="{{ $item->locatie }}" class="border p-2 w-full">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Bijwerken</button>
        </form>
    </div>
</x-app-layout>
