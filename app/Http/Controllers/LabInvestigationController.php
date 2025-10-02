<?php

namespace App\Http\Controllers;

use App\Models\LabInvestigation;
use App\Http\Requests\StoreLabInvestigationRequest;
use Illuminate\Support\Facades\Auth;

class LabInvestigationController extends Controller
{
    public function store(StoreLabInvestigationRequest $request, $patientId)
    {
        $doctorId = Auth::user()->doctor->id ?? null;

        LabInvestigation::create([
            'patient_id' => $patientId,
            'doctor_id' => $doctorId,
            'test_name' => $request->test_name,
            'test_date' => $request->test_date,
            'lab' => $request->lab,
            'sample_collected_at' => $request->sample_collected_at,
            'expected_date' => $request->expected_date,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Lab test ordered successfully.');
    }
}
