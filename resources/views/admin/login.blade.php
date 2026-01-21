@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-center text-red-600">
        Admin Inloggen
    </h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="block mb-1">E-mail</label>
            <input
                type="email"
                name="email"
                id="email"
                class="w-full border px-3 py-2 rounded"
                required
            >
        </div>

        <div class="mb-4">
            <label for="password" class="block mb-1">Wachtwoord</label>
            <input
                type="password"
                name="password"
                id="password"
                class="w-full border px-3 py-2 rounded"
                required
            >
        </div>

        <p class="mt-4 text-sm text-center text-gray-600">
            Nog geen account?
            <a href="{{ route('admin.register') }}"
               class="text-red-600 hover:text-red-800 font-medium">
                Klik hier
            </a>
        </p>

        <p class="mt-4 text-sm text-center text-gray-600">
            Geen admin?
            <a href="{{ route('login') }}"
               class="text-red-600 hover:text-red-800 font-medium">
                Normaal inloggen
            </a>
        </p>

        <!-- Knoppen naast elkaar (zelfde als login pagina) -->
        <div class="flex justify-between mt-6">
            <button
                type="submit"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded w-full"
            >
                Inloggen als Admin
            </button>
        </div>
    </form>
</div>
@endsection
