<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientAssessment;
use App\Models\Appointment;
use Illuminate\Http\Request;

class NurseController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor.user'])
            ->whereDate('appointment_date', today())
            ->get();

        return view('nurse.index', compact('appointments'));
    }

    public function showForm($patientId)
    {
        $patient = Patient::with(['assessment','visits'])->findOrFail($patientId);
        $appointmentId = request()->get('appointment');

        return view('nurse.form', compact('patient', 'appointmentId'));
    }

    public function visitDetails($id)
    {
        $appointment = Appointment::with('patient')->findOrFail($id);
        $assessments = $appointment->patient->assessments()->latest()->get();

        return view('nurse.visit-details', compact('appointment', 'assessments'));
    }

    public function assessmentDetails($id)
    {
        $assessment = PatientAssessment::findOrFail($id);

        return response()->json([
            'id' => $assessment->id,
            'created_at' => $assessment->created_at->format('m/d/Y h:i A'),
            'temperature' => $assessment->temperature,
            'blood_pressure_systolic' => $assessment->blood_pressure_systolic,
            'blood_pressure_diastolic' => $assessment->blood_pressure_diastolic,
            'heart_rate' => $assessment->heart_rate,
            'respiratory_rate' => $assessment->respiratory_rate,
            'oxygen_saturation' => $assessment->oxygen_saturation,
            'weight' => $assessment->weight,
            'height' => $assessment->height,
            'bmi' => $assessment->bmi,
            'allergies' => $assessment->allergies,
            'fall_risk' => $assessment->fall_risk,
            'pain_level' => $assessment->pain_level,
            'smoking_status' => $assessment->smoking_status,
            'alcohol_consumption' => $assessment->alcohol_consumption,
            'chronic_conditions' => $assessment->chronic_conditions,
        ]);
    }

    public function update(Request $request, $patientId)
    {
        $validated = $request->validate([
            'temperature' => 'nullable|numeric',
            'blood_pressure_systolic' => 'nullable|integer',
            'blood_pressure_diastolic' => 'nullable|integer',
            'heart_rate' => 'nullable|integer',
            'respiratory_rate' => 'nullable|integer',
            'oxygen_saturation' => 'nullable|integer',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'bmi' => 'nullable|numeric',
            'allergies' => 'nullable|string',
            'fall_risk' => 'nullable|in:low,moderate,high',
            'pain_level' => 'nullable|integer',
            'smoking_status' => 'nullable|in:never,former,current',
            'alcohol_consumption' => 'nullable|string',
            'chronic_conditions' => 'nullable|array',
        ]);

        if (isset($validated['chronic_conditions'])) {
            $validated['chronic_conditions'] = json_encode($validated['chronic_conditions']);
        }

        $validated['patient_id'] = $patientId;
        $validated['appointment_id'] = $request->input('appointment_id');

        PatientAssessment::create($validated);

        $redirectId = $request->input('appointment_id');

        return redirect()->route('nurse.visit-details', ['id' => $redirectId])
            ->with('status', 'Assessment saved');
    }
}
