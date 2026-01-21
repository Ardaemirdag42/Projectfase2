<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Retro Game Site</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-red-600 text-white px-6 py-4 flex justify-between items-center">
        <a href="{{ url('/') }}" class="text-xl font-bold text-green-400">
            🎮 RetroGame
        </a>

        <div class="flex items-center gap-4">
            <a href="{{ url('/games') }}" class="hover:text-green-400">Games</a>

            @auth
                <a href="{{ url('/library') }}" class="hover:text-green-400">
                    Mijn bibliotheek
                </a>

                <a href="{{ url('/reviews') }}" class="hover:text-green-400">
                    Reviews
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded">
                        Uitloggen
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded">
                     Inloggen
                </a>
            @endauth
        </div>
    </nav>

    <!-- Content -->
    <main class="p-6">

        @auth
            <p class="mb-4 text-lg font-medium text-gray-700">
                Hallo, {{ Auth::user()->name }} 👋
            </p>
        @endauth

        @yield('content')
    </main>

</body>
</html>
