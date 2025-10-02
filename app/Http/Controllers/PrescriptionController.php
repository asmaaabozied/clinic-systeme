<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\PrescriptionMedicine;
use App\Models\MedicineCategory;
use App\Models\Medicine;
use App\Models\Dose;
use App\Models\DoseInterval;
use App\Models\DoseDuration;
use App\Models\Pathology;
use App\Models\Radiology; 
use App\Models\Finding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PrescriptionController extends Controller
{
    public function create()
    {
        
    } 
    
    public function getMedicines($categoryId)
    {
        $medicines = Medicine::where('medicine_category_id', $categoryId)->get();
        return response()->json($medicines);
    }

    public function getFindings($categoryId)
    {
        $medicines = Finding::where('finding_category_id', $categoryId)->get();
        return response()->json($medicines);
    }
    
    public function store(Request $request)
    {
      
        $validated = $request->validate([
            'header_note' => 'nullable|string',
            'finding_category_id' => 'required|exists:finding_categories,id',
            'finding_id' => 'required|exists:findings,id',
            'finding_description' => 'nullable|string',
            'finding_print' => 'nullable|string',
            'footer_note' => 'nullable|string',
            'pathology_id' => 'nullable|exists:pathologies,id',
            'radiology_id' => 'nullable|exists:radiologies,id',
            'attachment' => 'nullable|file|max:2048',
            'medicines' => 'required|array|min:1',
            'medicines.*.category_id' => 'required|exists:medicine_categories,id',
            'medicines.*.medicine_id' => 'required|exists:medicines,id',
            'medicines.*.dose_id' => 'required|exists:doses,id',
            'medicines.*.dose_interval_id' => 'required|exists:dose_intervals,id',
            'medicines.*.dose_duration_id' => 'required|exists:dose_durations,id',
            'medicines.*.instruction' => 'nullable|string',
            'notifications' => 'nullable|array',
            'notifications.*' => 'exists:roles,id',
        ]);

        // Handle file upload
        $attachmentPath = null;

        if ($image = $request->file('attachment')) {
            $attachmentPath = store_file($image, 'prescriptions');
        }

        // Create prescription
        $prescription = Prescription::create([
            'patient_id' => $request->patient_id, 
            'doctor_id' => Auth::id(),
            'header_note' => $request->header_note,
            'finding_description' => $request->finding_description,
            'finding_print' => $request->finding_print,
            'footer_note' => $request->footer_note,
            'attachment_path' => $attachmentPath,
            'pathology_id' => $request->pathology_id,
            'radiology_id' => $request->radiology_id,
        ]);

        // Add medicines
        foreach ($request->medicines as $medicineData) {
            $prescription->medicines()->create([
                'medicine_id' => $medicineData['medicine_id'],
                'dose_id' => $medicineData['dose_id'],
                'dose_interval_id' => $medicineData['dose_interval_id'],
                'dose_duration_id' => $medicineData['dose_duration_id'],
                'instruction' => $medicineData['instruction'],
            ]);
        }

        // Handle notifications (if needed)
        // if ($request->notifications) {
        //     $prescription->notifications()->sync($request->notifications);
        // }

        return redirect()->back()->with('success', 'Prescription created successfully');
    }
}