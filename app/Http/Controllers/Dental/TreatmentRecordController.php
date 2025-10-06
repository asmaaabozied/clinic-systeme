<?php

namespace App\Http\Controllers\Dental;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TreatmentRecord;

class TreatmentRecordController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'date' => 'required|date',
            'procedure' => 'required|string',
            'tooth_numbers' => 'nullable|array',
            'tooth_numbers.*' => 'integer|between:1,32',
            'notes' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
            'status' => 'required|in:completed,in-progress,planned',
        ]);

        TreatmentRecord::create($data);

        return back()->with('success', __('Treatment record saved.'));
    }
}
