<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Alle reviews bekijken
    public function index()
    {
        $reviews = Review::with('game', 'user')->latest()->get();
        return view('reviews.index', compact('reviews'));
    }

    // Formulier om een nieuwe review te maken
    public function create()
    {
        $games = Game::all(); // lijst van games voor dropdown
        return view('reviews.create', compact('games'));
    }

    // Review opslaan
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

    // Review verwijderen (alleen voor admins)
    public function destroy(Review $review)
{
        if (!auth()->user() || !auth()->user()->is_admin) {
        abort(403, 'Je hebt geen toestemming.');
    }

        $review->delete();

        return redirect()->route('reviews.index')->with('success', 'Review verwijderd!');
    }

}
