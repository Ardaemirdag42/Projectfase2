<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Console;

class ConsoleController extends Controller
{
    public function __construct()
    {
        // Alleen ingelogde admins mogen deze acties
        $this->middleware('auth'); // eerst ingelogd
        $this->middleware(function ($request, $next) {
            $user = $request->user(); // veiliger in minimal setups
            if (!$user || (int)$user->is_admin !== 1) {
                abort(403, 'Je hebt geen toegang.');
            }
            return $next($request);
        });
    }

    // Formulier om console toe te voegen
    public function create()
    {
        return view('consoles.create');
    }

    // Opslaan in DB
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:consoles,name',
        ]);

        Console::create([
            'name' => $request->name,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Console succesvol toegevoegd!');
    }
}