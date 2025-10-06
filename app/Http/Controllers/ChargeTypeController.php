<?php

namespace App\Http\Controllers;

use App\Models\ChargeType;
use Illuminate\Http\Request;

class ChargeTypeController extends Controller
{
    public function index()
    {
        $chargeTypes = ChargeType::all();
        return view('charge_types.index', compact('chargeTypes'));
    }

    public function create()
    {
        $modules = \App\Models\Module::all();
        return view('charge_types.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:charge_types,name',
            'module_ids' => 'nullable|array',
            'module_ids.*' => 'exists:modules,id',
        ]);
        $chargeType = \App\Models\ChargeType::create(['name' => $validated['name']]);
        if (!empty($validated['module_ids'])) {
            $chargeType->modules()->sync($validated['module_ids']);
        }
        return redirect()->route('charge-types.index')->with('success', 'Charge type created successfully.');
    }

    public function show(ChargeType $charge_type)
    {
        return view('charge_types.show', compact('charge_type'));
    }

    public function edit(ChargeType $charge_type)
    {
        $modules = \App\Models\Module::all();
        $selectedModules = $charge_type->modules->pluck('id')->toArray();
        return view('charge_types.edit', compact('charge_type', 'modules', 'selectedModules'));
    }

    public function update(Request $request, ChargeType $charge_type)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:charge_types,name,' . $charge_type->id,
            'module_ids' => 'nullable|array',
            'module_ids.*' => 'exists:modules,id',
        ]);
        $charge_type->update(['name' => $validated['name']]);
        $charge_type->modules()->sync($validated['module_ids'] ?? []);
        return redirect()->route('charge-types.index')->with('success', 'Charge type updated successfully.');
    }

    public function destroy(ChargeType $charge_type)
    {
        $charge_type->delete();
        return redirect()->route('charge-types.index')->with('success', 'Charge type deleted successfully.');
    }
}
