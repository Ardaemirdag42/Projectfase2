<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Mail\ReservationConfirmed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    public function index() {
        $reservations = Reservation::all();
        return view('reservations.index', compact('reservations'));
    }

    public function create() {
        return view('reservations.create');
    }

    public function store(Request $request) {
    // Valideer input
    $request->validate([
        'employee_name' => 'required',
        'email' => 'required|email',
        'item_name' => 'required',
        'date' => 'required|date',
        'time' => 'required',
    ]);

    // Check dubbele reservering voor hetzelfde item op hetzelfde tijdstip
    $itemExists = Reservation::where('item_name', $request->item_name)
        ->where('date', $request->date)
        ->where('time', $request->time)
        ->exists();

    if ($itemExists) {
        return back()->withErrors(['msg' => 'Dit item is al gereserveerd op dit tijdstip.']);
    }

    // Check dubbele reservering voor dezelfde persoon op dezelfde dag
    $personExists = Reservation::where('email', $request->email)
        ->where('date', $request->date)
        ->exists();

    if ($personExists) {
        return back()->withErrors(['msg' => 'Deze persoon heeft al een reservering op deze dag.']);
    }

    // Sla op
    Reservation::create($request->all());

    return redirect('/')->with('success', 'Reservering succesvol aangemaakt!');
}


    public function edit($id) {
        $reservation = Reservation::findOrFail($id);
        return view('reservations.edit', compact('reservation'));
    }

    public function update(Request $request, $id) {
    $reservation = Reservation::findOrFail($id);

    $request->validate([
        'employee_name' => 'required',
        'email' => 'required|email',
        'item_name' => 'required',
        'date' => 'required|date',
        'time' => 'required',
    ]);

    // Check dubbele reservering voor hetzelfde item op hetzelfde tijdstip (anders dan huidige)
    $itemExists = Reservation::where('item_name', $request->item_name)
        ->where('date', $request->date)
        ->where('time', $request->time)
        ->where('id', '!=', $id)
        ->exists();

    if ($itemExists) {
        return back()->withErrors(['msg' => 'Dit item is al gereserveerd op dit tijdstip.']);
    }

    // Check dubbele reservering voor dezelfde persoon op dezelfde dag (anders dan huidige)
    $personExists = Reservation::where('email', $request->email)
        ->where('date', $request->date)
        ->where('id', '!=', $id)
        ->exists();

    if ($personExists) {
        return back()->withErrors(['msg' => 'Deze persoon heeft al een reservering op deze dag.']);
    }

    $reservation->update($request->all());

    Mail::to(auth()->user()->email)->send(new ReservationConfirmed($reservation));

    return redirect('/')->with('success', 'Reservering aangepast!');
}

public function destroy($id) {
    $reservation = Reservation::findOrFail($id); // Vind de reservering of geef 404
    $reservation->delete(); // Verwijder uit de database

    return redirect('/')->with('success', 'Reservering verwijderd!');
}


}
