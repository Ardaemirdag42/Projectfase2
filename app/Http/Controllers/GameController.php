<?php

namespace App\Http\Controllers;

use App\Models\Game;

class GameController extends Controller
{
    public function index()
    {
        return view('games.index', [
            'games' => Game::all()
        ]);
    }

    public function show(Game $game)
    {
        return view('games.show', compact('game'));
    }
}
