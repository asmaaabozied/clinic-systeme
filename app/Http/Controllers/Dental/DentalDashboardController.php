<?php

namespace App\Http\Controllers\Dental;

use App\Http\Controllers\Controller;
use App\Models\DentalTreatmentPlan;
use App\Models\TreatmentRecord;
use App\Models\OralHealthAssessment;
use App\Models\Patient;
use App\Models\Doctor;

class DentalDashboardController extends Controller
{
    public function index()
    {
        $patient = Patient::find(request()->get('patient_id'));
        $doctor = auth()->user()->doctor ?? Doctor::first();

        $latestPlan = null;
        $treatmentRecords = collect();
        $latestAssessment = null;
        $toothConditions = collect();

        if ($patient) {
            $latestPlan = DentalTreatmentPlan::where('patient_id', $patient->id)->latest()->first();
            $treatmentRecords = TreatmentRecord::where('patient_id', $patient->id)->latest()->get();
            $latestAssessment = OralHealthAssessment::where('patient_id', $patient->id)->latest()->first();
            $toothConditions = \App\Models\ToothCondition::where('patient_id', $patient->id)->get()->keyBy('tooth_number');
        }

        return view('doctor.specialization.dental.layout.main', compact('patient', 'doctor', 'latestPlan', 'treatmentRecords', 'latestAssessment', 'toothConditions'));
    }
}
