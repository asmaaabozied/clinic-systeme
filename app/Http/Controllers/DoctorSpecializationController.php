<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorSpecialization;

class DoctorSpecializationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctorSpecializations = DoctorSpecialization::all();
        return view('doctor_specializations.index', compact('doctorSpecializations'));
    }

    public function doctors($id)
    {
        $specialization = DoctorSpecialization::with('doctors.user')->findOrFail($id);

        return view('doctor_specializations.doctors', [
            'specialization' => $specialization,
            'doctors' => $specialization->doctors,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('doctor_specializations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:doctor_specializations,name',
            'description' => 'nullable|string',
        ]);

        DoctorSpecialization::create($validated);

        return redirect()->route('doctor-specializations.index')->with('success', 'Doctor Specialization created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $specialization = DoctorSpecialization::findOrFail($id);
        return view('doctor_specializations.show', compact('specialization'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $specialization = DoctorSpecialization::findOrFail($id);
        return view('doctor_specializations.edit', compact('specialization'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $specialization = DoctorSpecialization::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|unique:doctor_specializations,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $specialization->update($validated);

        return redirect()->route('doctor-specializations.index')->with('success', 'Doctor Specialization updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $specialization = DoctorSpecialization::findOrFail($id);
        $specialization->delete();

        return redirect()->route('doctor-specializations.index')->with('success', 'Doctor Specialization deleted successfully.');
    }

    public function livesearch(Request $request)
    {
        $query = $request->input('q');
        $specializations = DoctorSpecialization::query()
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%$query%");
            })
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
        return response()->json(['specializations' => $specializations]);
    }
}
