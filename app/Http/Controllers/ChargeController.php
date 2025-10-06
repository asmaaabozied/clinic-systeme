<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use App\Models\ChargeType;
use App\Models\ChargeCategory;
use App\Models\UnitType;
use App\Models\Tax;
use Illuminate\Http\Request;

class ChargeController extends Controller
{
    public function index()
    {
        $charges = Charge::with(['chargeType', 'chargeCategory', 'unitType', 'tax'])->get();
        return view('charges.index', compact('charges'));
    }

    public function create()
    {
        $chargeTypes = ChargeType::all();
        $chargeCategories = ChargeCategory::all();
        $unitTypes = UnitType::all();
        $taxes = Tax::all();
        return view('charges.create', compact('chargeTypes', 'chargeCategories', 'unitTypes', 'taxes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'charge_type_id' => 'required|exists:charge_types,id',
            'charge_category_id' => 'required|exists:charge_categories,id',
            'unit_type_id' => 'required|exists:unit_types,id',
            'charge_name' => 'required|string|max:255',
            'tax_id' => 'nullable|exists:taxes,id',
            'tax_percentage' => 'nullable|numeric',
            'standard_charge' => 'required|numeric',
            'description' => 'nullable|string',
        ]);
        Charge::create($validated);
        return redirect()->route('charges.index')->with('success', 'Charge created successfully.');
    }

    public function show(Charge $charge)
    {
        return view('charges.show', compact('charge'));
    }

    public function edit(Charge $charge)
    {
        $chargeTypes = ChargeType::all();
        $chargeCategories = ChargeCategory::all();
        $unitTypes = UnitType::all();
        $taxes = Tax::all();
        return view('charges.edit', compact('charge', 'chargeTypes', 'chargeCategories', 'unitTypes', 'taxes'));
    }

    public function update(Request $request, Charge $charge)
    {
        $validated = $request->validate([
            'charge_type_id' => 'required|exists:charge_types,id',
            'charge_category_id' => 'required|exists:charge_categories,id',
            'unit_type_id' => 'required|exists:unit_types,id',
            'charge_name' => 'required|string|max:255',
            'tax_id' => 'nullable|exists:taxes,id',
            'tax_percentage' => 'nullable|numeric',
            'standard_charge' => 'required|numeric',
            'description' => 'nullable|string',
        ]);
        $charge->update($validated);
        return redirect()->route('charges.index')->with('success', 'Charge updated successfully.');
    }

    public function destroy(Charge $charge)
    {
        $charge->delete();
        return redirect()->route('charges.index')->with('success', 'Charge deleted successfully.');
    }
    public function getChargesByCategory($id)
    {
        return  $charges = Charge::where('charge_category_id', $id)->get();

        return response()->json($charges);
    }

    public function getAllCharges()
    {
//        $id = ChargeCategory::first()->id; // Assuming you want to get charges for the first category
         $charges = Charge::query()->get();

        return response()->json($charges);
    }
    public function getChargeDetails($id)
    {
        $charge = Charge::findOrFail($id);

        return response()->json([
            'charge_name' => $charge->charge_name,
            'standard_charge' => $charge->standard_charge,
            'tax_percentage' => $charge->tax_percentage,
        ]);
    }
}
