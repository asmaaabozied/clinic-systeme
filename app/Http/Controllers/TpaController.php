<?php

namespace App\Http\Controllers;

use App\Models\Tpa;
use Illuminate\Http\Request;

class TpaController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $tpas = Tpa::all();
        return view('tpa.index', compact('tpas'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        return view('tpa.create');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        Tpa::create($validated);
        return redirect()->route('tpas.index')->with('success', 'TPA created successfully.');
    }

    // Display the specified resource.
    public function show(Tpa $tpa)
    {
        return view('tpa.show', compact('tpa'));
    }

    // Show the form for editing the specified resource.
    public function edit(Tpa $tpa)
    {
        return view('tpa.edit', compact('tpa'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, Tpa $tpa)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $tpa->update($validated);
        return redirect()->route('tpas.index')->with('success', 'TPA updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy(Tpa $tpa)
    {
        $tpa->delete();
        return redirect()->route('tpas.index')->with('success', 'TPA deleted successfully.');
    }
}
