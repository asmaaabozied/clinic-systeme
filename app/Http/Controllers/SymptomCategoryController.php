<?php

namespace App\Http\Controllers;

use App\Models\rc;
use App\Models\SymptomType;
use Illuminate\Http\Request;
use App\Models\SymptomCategory;

class SymptomCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = SymptomCategory::all();
        return view('symptom_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id = null)
    {
        $symptomType = null;

        if ($id) {
            $symptomType = SymptomType::find($id);
        }

        $types = SymptomType::all();

        return view('symptom_categories.create', compact('types', 'symptomType'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'symptom_type_id' => 'required|exists:symptom_types,id',
            'description' => 'nullable|string',
        ]);
        SymptomCategory::create($validated);
        return redirect()->route('symptom-categories.index')->with('success', 'Symptom category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SymptomCategory $symptom_category)
    {
      
        return view('symptom_categories.show', ['category' => $symptom_category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SymptomCategory $symptom_category)
    {
        $types = SymptomType::all();
        return view('symptom_categories.edit', ['category' => $symptom_category, 'types' => $types]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SymptomCategory $symptom_category)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'symptom_type_id' => 'required|exists:symptom_types,id',
            'description' => 'required|string',
        ]);
        $symptom_category->update($validated);
        return redirect()->route('symptom-categories.index')->with('success', 'Symptom category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SymptomCategory $symptom_category)
    {
        $symptom_category->delete();
        return redirect()->route('symptom-categories.index')->with('success', 'Symptom category deleted successfully.');
    }
    public function getCategories($typeId)
{
    $categories = SymptomCategory::where('symptom_type_id', $typeId)->get(); 
    return response()->json($categories);
}


}
