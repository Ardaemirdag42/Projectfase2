<?php

namespace App\Http\Controllers;

use App\Models\LibraryItem;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $games = $user->libraryGames; // afhankelijk van je relatie
        return view('library.index', compact('games'));
    }


    public function store(Game $game)
    {
        LibraryItem::firstOrCreate([
            'user_id' => Auth::id(),
            'game_id' => $game->id,
        ]);

        return back()->with('success', 'Game toegevoegd aan jouw bibliotheek!');
    }
}

