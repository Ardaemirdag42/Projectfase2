<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Console;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Alle games overzicht met gemiddelde reviews en aantal reviews
     */
    public function index()
    {
        $games = Game::withCount('reviews')      // aantal reviews per game
                     ->withAvg('reviews', 'rating') // gemiddelde rating
                     ->get();

        return view('games.index', compact('games'));
    }

    /**
     * Specifieke game bekijken
     */
    public function show(Game $game)
    {
        $game->load('reviews.user'); // Optioneel: reviews + gebruikers
        return view('games.show', compact('game'));
    }

    /**
     * Formulier om game toe te voegen
     */
    public function create()
    {
        if (!auth()->user() || !auth()->user()->is_admin) {
            abort(403, 'Je hebt geen toegang.');
        }

        $consoles = Console::all();
        return view('games.create', compact('consoles'));
    }

    /**
     * Opslaan van nieuwe game
     */
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

    /**
     * Formulier om game te bewerken
     */
    public function edit(Game $game)
    {
        if (!auth()->user() || !auth()->user()->is_admin) {
            abort(403, 'Je hebt geen toegang.');
        }

        $consoles = Console::all(); // Dropdown consoles
        return view('games.edit', compact('game', 'consoles'));
    }

    /**
     * Game updaten
     */
    public function update(Request $request, Game $game)
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

        $game->update($request->all());

        return redirect()->route('games.index')->with('success', 'Game bijgewerkt!');
    }

    /**
     * Game verwijderen
     */
    public function destroy(Game $game)
    {
        if (!auth()->user() || !auth()->user()->is_admin) {
            abort(403, 'Je hebt geen toegang.');
        }

        $game->delete();

        return redirect()->route('games.index')->with('success', 'Game verwijderd!');
    }
}