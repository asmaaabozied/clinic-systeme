<?php

namespace App\Http\Controllers;

use App\Models\UnitType;
use Illuminate\Http\Request;

class UnitTypeController extends Controller
{
    public function index()
    {
        $unitTypes = UnitType::all();
        return view('unit_types.index', compact('unitTypes'));
    }

    public function create()
    {
        return view('unit_types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:unit_types,name',
        ]);
        UnitType::create($validated);
        return redirect()->route('unit-types.index')->with('success', 'Unit type created successfully.');
    }

    public function show(UnitType $unit_type)
    {
        return view('unit_types.show', compact('unit_type'));
    }

    public function edit(UnitType $unit_type)
    {
        return view('unit_types.edit', compact('unit_type'));
    }

    public function update(Request $request, UnitType $unit_type)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:unit_types,name,' . $unit_type->id,
        ]);
        $unit_type->update($validated);
        return redirect()->route('unit-types.index')->with('success', 'Unit type updated successfully.');
    }

    public function destroy(UnitType $unit_type)
    {
        $unit_type->delete();
        return redirect()->route('unit-types.index')->with('success', 'Unit type deleted successfully.');
    }
}
