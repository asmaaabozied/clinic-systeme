<?php

namespace App\Http\Controllers\Dental;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DentalTreatmentPlan;

class DentalTreatmentPlanController extends Controller
{
    public function index()
    {
        $patient = \App\Models\Patient::first();
        $plans = collect();

        if ($patient) {
            $plans = DentalTreatmentPlan::where('patient_id', $patient->id)->latest()->paginate(10);
        }

        return view('doctor.specialization.dental.treatment-plans.index', compact('plans', 'patient'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'title' => 'required|string|max:255',
            'stage' => 'nullable|in:pre-op,procedure,follow-up,completed',
            'procedures' => 'nullable|string',
            'procedures.*' => 'string',
            'estimated_cost' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'estimated_completion' => 'nullable|date|after_or_equal:start_date',
        ]);

        $data['stage'] = $data['stage'] ?? 'pre-op';

        DentalTreatmentPlan::create($data);

        return back()->with('success', __('Treatment plan saved.'));
    }
}
