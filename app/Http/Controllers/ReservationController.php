<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Inventaris;
use App\Mail\ReservationConfirmed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    /**
     * Toon alle reserveringen
     */
    public function index()
    {
        $reservations = Reservation::all();
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Toon formulier om een nieuwe reservering te maken
     */
    public function create()
    {
        $inventarisItems = Inventaris::all(); // Haal alle items op
        return view('reservations.create', compact('inventarisItems'));
    }

    /**
     * Sla nieuwe reservering op
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'inventaris' => 'required|exists:inventaris,naam',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        // Check dubbele reservering voor hetzelfde item op hetzelfde tijdstip
        $itemExists = Reservation::where('inventaris', $request->inventaris)
            ->where('date', $request->date)
            ->where('time', $request->time)
            ->exists();

        if ($itemExists) {
            return back()->withErrors(['msg' => 'Dit item is al gereserveerd op dit tijdstip.'])->withInput();
        }

        // Check dubbele reservering voor dezelfde persoon op dezelfde dag
        $personExists = Reservation::where('email', $request->email)
            ->where('date', $request->date)
            ->exists();

        if ($personExists) {
            return back()->withErrors(['msg' => 'Deze persoon heeft al een reservering op deze dag.'])->withInput();
        }

        // Opslaan
        Reservation::create([
            'employee_name' => $request->employee_name,
            'email' => $request->email,
            'inventaris' => $request->inventaris,
            'date' => $request->date,
            'time' => $request->time,
        ]);

        return redirect('/')->with('success', 'Reservering succesvol aangemaakt!');
    }

    /**
     * Toon formulier om een reservering te bewerken
     */
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        $inventarisItems = Inventaris::all();
        return view('reservations.edit', compact('reservation', 'inventarisItems'));
    }

    /**
     * Update bestaande reservering
     */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'employee_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'inventaris' => 'required|exists:inventaris,naam',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        // Check dubbele reservering voor hetzelfde item op hetzelfde tijdstip (anders dan huidige)
        $itemExists = Reservation::where('inventaris', $request->inventaris)
            ->where('date', $request->date)
            ->where('time', $request->time)
            ->where('id', '!=', $id)
            ->exists();

        if ($itemExists) {
            return back()->withErrors(['msg' => 'Dit item is al gereserveerd op dit tijdstip.'])->withInput();
        }

        // Check dubbele reservering voor dezelfde persoon op dezelfde dag (anders dan huidige)
        $personExists = Reservation::where('email', $request->email)
            ->where('date', $request->date)
            ->where('id', '!=', $id)
            ->exists();

        if ($personExists) {
            return back()->withErrors(['msg' => 'Deze persoon heeft al een reservering op deze dag.'])->withInput();
        }

        // Update
        $reservation->update([
            'employee_name' => $request->employee_name,
            'email' => $request->email,
            'inventaris' => $request->inventaris,
            'date' => $request->date,
            'time' => $request->time,
        ]);

        // Stuur bevestigingsmail
        if(auth()->check()){
            Mail::to(auth()->user()->email)->send(new ReservationConfirmed($reservation));
        }

        return redirect('/')->with('success', 'Reservering aangepast!');
    }

    /**
     * Verwijder reservering
     */
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect('/')->with('success', 'Reservering verwijderd!');
    }
}
