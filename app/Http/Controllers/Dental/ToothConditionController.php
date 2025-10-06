<?php

namespace App\Http\Controllers\Dental;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ToothCondition;

class ToothConditionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'tooth_number' => 'required|integer|between:1,32',
            'condition' => 'required|in:healthy,decay,filling,crown,missing,implant,root-canal',
            'severity' => 'nullable|in:mild,moderate,severe',
            'notes' => 'nullable|string',
            'date' => 'required|date',
        ]);

        ToothCondition::updateOrCreate(
            ['patient_id' => $data['patient_id'], 'tooth_number' => $data['tooth_number']],
            $data
        );

        return back()->with('success', __('Tooth condition saved.'));
    }
}
