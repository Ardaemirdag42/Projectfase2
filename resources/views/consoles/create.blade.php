@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-center">Nieuwe Console Toevoegen</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('consoles.store') }}">
        @csrf
        <input type="text"
               name="name"
               value="{{ old('name') }}"
               placeholder="Console Naam"
               class="w-full border px-3 py-2 rounded mb-4"
               required>

        <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded w-full">
            Console Toevoegen
        </button>
    </form>
</div>
@endsection
