<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventaris;

class InventarisController extends Controller
{
    public function index()
    {
        $items = Inventaris::all();
        return view('inventaris.index', compact('items'));
    }

    public function create()
    {
        return view('inventaris.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'naam' => 'required',
            'categorie' => 'required',
            'aantal' => 'required|integer|min:0',
            'locatie' => 'required',
        ]);

        Inventaris::create($request->all());

        return redirect()->route('inventaris.index')->with('success', 'Artikel toegevoegd!');
    }

    public function edit($id)
    {
        $item = Inventaris::findOrFail($id);
        return view('inventaris.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Inventaris::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('inventaris.index')->with('success', 'Artikel bijgewerkt!');
    }

    public function destroy($id)
    {
        $item = Inventaris::findOrFail($id);
        $item->delete();

        return redirect()->route('inventaris.index')->with('success', 'Artikel verwijderd!');
    }

    public function mutaties($id)
{
    $item = Inventaris::findOrFail($id);
    $mutaties = $item->mutaties()->latest()->get();
    return view('inventaris.mutaties', compact('item', 'mutaties'));
}

public function voegMutatieToe(Request $request, $id)
{
    $item = Inventaris::findOrFail($id);

    $request->validate([
        'type' => 'required|in:inkomend,uitgaand',
        'aantal' => 'required|integer|min:1',
        'opmerking' => 'nullable|string'
    ]);

    // Nieuwe mutatie opslaan
    $item->mutaties()->create([
        'type' => $request->type,
        'aantal' => $request->aantal,
        'opmerking' => $request->opmerking,
    ]);

    // Voorraad aanpassen
    if ($request->type === 'inkomend') {
        $item->aantal += $request->aantal;
    } else {
        $item->aantal -= $request->aantal;
    }

    $item->save();

    return redirect()->route('inventaris.mutaties', $id)->with('success', 'Mutatie toegevoegd!');
}

}
