<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class ReceptionistController extends Controller
{
    public function index()
    {
        $patients = Patient::paginate(10);
        return view('receptionist.index', compact('patients'));
    }

    public function create()
    {
        return view('receptionist.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['nullable', 'email', 'unique:patients,email'],
            'phone' => ['required', 'digits_between:10,15', 'unique:patients,phone'],
            'gender' => ['required', 'in:male,female'],
            'date_of_birth' => ['required', 'date'],
            'blood_group' => ['nullable', 'string'],
            'marital_status' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'remarks' => ['nullable', 'string'],
        ]);

        $patient = Patient::create($validated);
        $patient->patient_code = 8000 + $patient->id;
        $patient->save();

        return redirect()->route('receptionist.index')->with('success', 'Patient created successfully.');
    }
}
