<?php

namespace App\Http\Controllers;

use App\Models\ChargeCategory;
use App\Models\ChargeType;
use Illuminate\Http\Request;

class ChargeCategoryController extends Controller
{
    public function index()
    {
        $categories = ChargeCategory::with('chargeType')->get();
        return view('charge_categories.index', compact('categories'));
    }

    public function create()
    {
        $chargeTypes = ChargeType::all();
        return view('charge_categories.create', compact('chargeTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'charge_type_id' => 'required|exists:charge_types,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        ChargeCategory::create($validated);
        return redirect()->route('charge-categories.index')->with('success', 'Charge category created successfully.');
    }

    public function show(ChargeCategory $charge_category)
    {
        return view('charge_categories.show', compact('charge_category'));
    }

    public function edit(ChargeCategory $charge_category)
    {
        $chargeTypes = ChargeType::all();
        return view('charge_categories.edit', compact('charge_category', 'chargeTypes'));
    }

    public function update(Request $request, ChargeCategory $charge_category)
    {
        $validated = $request->validate([
            'charge_type_id' => 'required|exists:charge_types,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $charge_category->update($validated);
        return redirect()->route('charge-categories.index')->with('success', 'Charge category updated successfully.');
    }

    public function destroy(ChargeCategory $charge_category)
    {
        $charge_category->delete();
        return redirect()->route('charge-categories.index')->with('success', 'Charge category deleted successfully.');
    }

    public function getByType($typeId)
    {
        $categories = \App\Models\ChargeCategory::where('charge_type_id', $typeId)->get();
        return response()->json($categories);
    }
}
