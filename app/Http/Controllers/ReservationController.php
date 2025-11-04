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
            'item_name' => 'required',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        // Check dubbele reservering
        $exists = Reservation::where('item_name', $request->item_name)
            ->where('date', $request->date)
            ->where('time', $request->time)
            ->exists();

        if($exists){
            return back()->withErrors(['msg' => 'Dit item is al gereserveerd op dit tijdstip.']);
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
            'item_name' => 'required',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        // Check dubbele reservering
        $exists = Reservation::where('item_name', $request->item_name)
            ->where('date', $request->date)
            ->where('time', $request->time)
            ->where('id', '!=', $id)
            ->exists();

        if($exists){
            return back()->withErrors(['msg' => 'Dit item is al gereserveerd op dit tijdstip.']);
        }

        $reservation->update($request->all());

        Mail::to(auth()->user()->email)->send(new ReservationConfirmed($reservation));

        return redirect('/')->with('success', 'Reservering aangepast!');
    }

    public function destroy($id) {
        Reservation::findOrFail($id)->delete();
        return redirect('/')->with('success', 'Reservering verwijderd!');
    }
}
