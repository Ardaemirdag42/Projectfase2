<?php

namespace App\Http\Controllers;

use App\Models\Review;

class AdminReviewController extends Controller
{
    public function index()
    {
        return view('admin.reviews.moderation', [
            'reviews' => Review::with(['user', 'game'])->latest()->get()
        ]);
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Review verwijderd');
    }
}
