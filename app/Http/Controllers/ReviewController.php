<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Alle reviews bekijken, met filter op game
     */
    public function index(Request $request)
    {
        // Haal alle games op voor de filter-dropdown
        $games = Game::all();

        // Start query voor reviews
        $query = Review::with('game', 'user')->latest();

        // Filter op game als er een filter geselecteerd is
        if ($request->filled('game_id')) {
            $query->where('game_id', $request->game_id);
        }

        $reviews = $query->get();

        // Stuur zowel reviews als games naar de view
        return view('reviews.index', compact('reviews', 'games'));
    }

    /**
     * Formulier om een nieuwe review te maken
     */
    public function create()
    {
        $games = Game::all(); // lijst van games voor dropdown
        return view('reviews.create', compact('games'));
    }

    /**
     * Review opslaan
     */
    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:500',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'game_id' => $request->game_id,
            'rating' => $request->rating,
            'content' => $request->content,
        ]);

        return redirect()->route('reviews.index')->with('success', 'Review geplaatst!');
    }

    /**
     * Review verwijderen (alleen voor admins)
     */
    public function destroy(Review $review)
    {
        if (!auth()->user() || !auth()->user()->is_admin) {
            abort(403, 'Je hebt geen toestemming.');
        }

        $review->delete();

        return redirect()->route('reviews.index')->with('success', 'Review verwijderd!');
    }
}