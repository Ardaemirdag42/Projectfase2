<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    // Alle games overzicht met gemiddelde reviews en aantal reviews
    public function index()
    {
        $games = Game::withCount('reviews')     // telt het aantal reviews per game
                     ->withAvg('reviews', 'rating') // berekent gemiddelde rating
                     ->get();

        return view('games.index', compact('games'));
    }

    // Specifieke game bekijken
    public function show(Game $game)
    {
        // Optioneel: laad ook reviews bij de game
        $game->load('reviews.user');

        return view('games.show', compact('game'));
    }

    // Formulier om game toe te voegen
    public function create()
    {
        if (!auth()->user() || !auth()->user()->is_admin) {
            abort(403, 'Je hebt geen toegang.');
        }
        return view('games.create');
    }

    // Opslaan van nieuwe game
    public function store(Request $request)
    {
        if (!auth()->user() || !auth()->user()->is_admin) {
            abort(403, 'Je hebt geen toegang.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'console' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'file_path' => 'nullable|string|max:255',
        ]);

        Game::create($request->all());

        return redirect()->route('games.index')->with('success', 'Game toegevoegd!');
    }
}