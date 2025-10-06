<?php

namespace App\Http\Controllers\Dental;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OralHealthAssessment;

class OralHealthAssessmentController extends Controller
{
    public function store(Request $request)
    {
//        dd($request->all());
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'gum_health' => 'required|in:excellent,good,fair,poor',
            'oral_hygiene' => 'required|in:excellent,good,fair,poor',
            'issues' => 'nullable|array',
            'issues.*' => 'string',
            'risk_factors' => 'nullable|array',
            'risk_factors.*' => 'string',
            'recommendations' => 'nullable|array',
            'recommendations.*' => 'string',
//            'assessment_date' => 'required|date',
        ]);

        OralHealthAssessment::updateOrCreate(
            ['patient_id' => $data['patient_id']],
            $data
        );

        return back()->with('success', __('Assessment saved.'));
    }
}
