<?php

namespace App\Http\Controllers;

use App\Models\SymptomType;
use Illuminate\Http\Request;

class SymptomTypeController extends Controller
{
    public function index()
    {
        $symptoms = SymptomType::all();
        return view('symptom-types.index', compact('symptoms'));
    }

    public function create()
    {
        return view('symptom-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:symptom_types,name',

        ]);
        SymptomType::create($validated);
        return redirect()->route('symptom-types.index')->with('success', 'Symptom created successfully.');
    }

    public function show(SymptomType $symptomType)
    {
        $categories = $symptomType->symptomCategories;
        return view('symptom-types.show', compact('symptomType', 'categories'));
    }

    public function edit(SymptomType $symptomType)
    {
        return view('symptom-types.edit', compact('symptomType'));
    }

    public function update(Request $request, SymptomType $symptomType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',

        ]);
        $symptomType->update($validated);
        return redirect()->route('symptom-types.index')->with('success', 'Symptom updated successfully.');
    }

    public function destroy(SymptomType $symptomType)
    {
        $symptomType->delete();
        return redirect()->route('symptom-types.index')->with('success', 'Symptom deleted successfully.');
    }
}
