@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Admin Registreren</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.register.submit') }}">
    @csrf

    <input type="text" name="name" placeholder="Naam"
           class="w-full border px-3 py-2 rounded mb-4" required>

    <input type="email" name="email" placeholder="E-mail"
           class="w-full border px-3 py-2 rounded mb-4" required>

    <input type="password" name="password" placeholder="Wachtwoord"
           class="w-full border px-3 py-2 rounded mb-4" required>

    <input type="password" name="password_confirmation"
           placeholder="Herhaal wachtwoord"
           class="w-full border px-3 py-2 rounded mb-4" required>

    <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded w-full">
        Admin Account Maken
    </button>
</form>

    <p class="mt-4 text-sm text-center text-gray-600">
        Al een account?
        <a href="{{ route('login') }}" class="text-green-600 hover:text-green-800 font-medium">
            Klik hier om in te loggen
        </a>
    </p>
</div>
@endsection
