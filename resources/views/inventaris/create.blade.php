<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-800">Nieuw artikel toevoegen</h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('inventaris.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label>Naam</label>
                <input type="text" name="naam" class="border p-2 w-full" required>
            </div>
            <div class="mb-4">
                <label>Categorie</label>
                <input type="text" name="categorie" class="border p-2 w-full" required>
            </div>
            <div class="mb-4">
                <label>Aantal</label>
                <input type="number" name="aantal" class="border p-2 w-full" required>
            </div>
            <div class="mb-4">
                <label>Locatie</label>
                <input type="text" name="locatie" class="border p-2 w-full" required>
            </div>
            <button type="submit" class="bg-blue-500 text-orange px-4 py-2 rounded">Opslaan</button>
        </form>
    </div>
</x-app-layout>
