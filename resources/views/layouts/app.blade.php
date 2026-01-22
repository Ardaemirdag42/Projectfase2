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
                {{-- Alleen gewone gebruikers: Mijn Bibliotheek --}}
                @if(!auth()->user()->is_admin)
                    <a href="{{ url('/library') }}" class="hover:text-green-400">Mijn bibliotheek</a>
                @endif

                <a href="{{ url('/reviews') }}" class="hover:text-green-400">Reviews</a>

                {{-- Admin-only: Console beheer --}}
                @if(auth()->user()->is_admin)
                    <a href="{{ route('consoles.create') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Nieuwe Console Toevoegen
                    </a>
                @endif

                {{-- Gewone gebruiker: Winkelwagen --}}
                @if(!auth()->user()->is_admin)
                    <a href="{{ route('cart.index') }}" 
                       class="relative flex items-center hover:text-green-400">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-6 w-6"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4
                                     M7 13L5.4 5
                                     M7 13l-2 9
                                     M17 13l2 9
                                     M9 21a1 1 0 100-2
                                     1 1 0 000 2zm8 0a1 1 0 100-2
                                     1 1 0 000 2z" />
                        </svg>

                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="absolute -top-2 -right-2 bg-yellow-400 text-black text-xs font-bold px-1.5 rounded-full">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>
                @endif

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

    <!-- Main content -->
    <main class="p-6">
        @auth
            <p class="mb-4 text-lg font-medium text-gray-700">
                Hallo, {{ Auth::user()->name }} 👋
            </p>
        @endauth

        {{-- Hier komt de content van child pagina --}}
        @yield('content')
    </main>

</body>
</html>