<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicineCategory;

class MedicineCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicineCategories = MedicineCategory::all();
        return view('medicineCategories.index', compact('medicineCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('medicineCategories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:medicine_categories,name',
        ]);

        MedicineCategory::create($validated);

        return redirect()->route('medicineCategories.index')->with('success', 'Doctor Specialization created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = MedicineCategory::findOrFail($id);
        return view('medicineCategories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = MedicineCategory::findOrFail($id);
        return view('medicineCategories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $specialization = MedicineCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|unique:medicine_categories,name,' . $id,
        ]);

        $specialization->update($validated);

        return redirect()->route('medicineCategories.index')->with('success', 'Doctor Specialization updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $specialization = MedicineCategory::findOrFail($id);
        $specialization->delete();

        return redirect()->route('medicineCategories.index')->with('success', 'Doctor Specialization deleted successfully.');
    }

    public function livesearch(Request $request)
    {
        $query = $request->input('q');
        $specializations = MedicineCategory::query()
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%$query%");
            })
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
        return response()->json(['specializations' => $specializations]);
    }
}
