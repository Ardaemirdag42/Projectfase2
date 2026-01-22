<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ConsoleController;
use App\Models\Game;
use App\Models\LibraryItem;

/*
|--------------------------------------------------------------------------
| Home Page
|--------------------------------------------------------------------------
*/
Route::get('/', [GameController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Guest routes (niet ingelogd)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Gebruiker login/register
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

    // Admin login/register
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

    Route::get('/admin/register', [AdminAuthController::class, 'showRegister'])->name('admin.register');
    Route::post('/admin/register', [AdminAuthController::class, 'register'])->name('admin.register.submit');
});

/*
|--------------------------------------------------------------------------
| Authenticated routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Library
    |--------------------------------------------------------------------------
    */
    Route::get('/library', [LibraryController::class, 'index'])->name('library.index');
    Route::post('/library/add/{game}', [LibraryController::class, 'store'])->name('library.store');

    // Download game prototype
    Route::get('/library/download/{game}', function (Game $game) {
        $user = auth()->user();

        if (!$game->file_path || !Storage::exists($game->file_path)) {
            abort(404, 'Bestand niet gevonden.');
        }

        return Storage::download($game->file_path, $game->title . '.zip');
    })->name('library.download');

    /*
    |--------------------------------------------------------------------------
    | Reviews
    |--------------------------------------------------------------------------
    */
    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    /*
    |--------------------------------------------------------------------------
    | Games beheren (admin-check in controller)
    |--------------------------------------------------------------------------
    */
    Route::get('/games/create', [GameController::class, 'create'])->name('games.create');
    Route::post('/games', [GameController::class, 'store'])->name('games.store');
    Route::get('/games/{game}/edit', [GameController::class, 'edit'])->name('games.edit');
    Route::put('/games/{game}', [GameController::class, 'update'])->name('games.update');
    Route::delete('/games/{game}', [GameController::class, 'destroy'])->name('games.destroy');

    /*
    |--------------------------------------------------------------------------
    | Consoles beheren (admin-check in controller)
    |--------------------------------------------------------------------------
    */
    Route::get('/consoles/create', [ConsoleController::class, 'create'])->name('consoles.create');
    Route::post('/consoles', [ConsoleController::class, 'store'])->name('consoles.store');

    /*
    |--------------------------------------------------------------------------
    | Winkelwagen (alleen gewone gebruikers)
    |--------------------------------------------------------------------------
    */
    Route::get('/cart', function () {
        $user = auth()->user();
        if ($user->is_admin) abort(403, 'Admins kunnen geen winkelwagen gebruiken.');
        return view('cart.index');
    })->name('cart.index');

    // Voeg item toe aan cart
    Route::post('/cart/add/{game}', function (Game $game) {
        $user = auth()->user();
        if ($user->is_admin) abort(403, 'Admins kunnen geen winkelwagen gebruiken.');

        $cart = session()->get('cart', []);

        if (!isset($cart[$game->id])) {
            $cart[$game->id] = [
                'id'       => $game->id,
                'title'    => $game->title,
                'price'    => $game->price,
                'quantity' => 1,
            ];
        } else {
            $cart[$game->id]['quantity']++;
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'count'   => count($cart),
        ]);
    })->name('cart.add');

    // Checkout: voeg games toe aan library en leeg cart
    Route::post('/cart/checkout', function () {
        $user = auth()->user();
        if ($user->is_admin) abort(403, 'Admins kunnen geen winkelwagen gebruiken.');

        $cart = session()->get('cart', []);

        foreach ($cart as $item) {
            LibraryItem::firstOrCreate([
                'user_id' => $user->id,
                'game_id' => $item['id'],
            ]);
        }

        session()->forget('cart');

        return redirect()
            ->route('library.index')
            ->with('success', 'Aankoop voltooid! Je games staan nu in je bibliotheek.');
    })->name('cart.checkout');
});

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/
// Games bekijken (voor iedereen)
Route::get('/games', [GameController::class, 'index'])->name('games.index');
Route::get('/games/{game}', [GameController::class, 'show'])->name('games.show');

// Reviews bekijken (voor iedereen)
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
