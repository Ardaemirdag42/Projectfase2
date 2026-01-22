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

    // Haal alle LibraryItems van de gebruiker, inclusief de game data
    $items = LibraryItem::with('game')
        ->where('user_id', $user->id)
        ->orderBy('created_at', 'desc') // nieuwste aankopen eerst
        ->get();

    // Let op: we sturen $items naar de view
    return view('library.index', compact('items'));
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

