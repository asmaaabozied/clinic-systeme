<?php

namespace App\Http\Controllers\Doctor\Specialization;

use App\Http\Controllers\Controller;
use App\Models\DermatologyConsultation;
use App\Models\DermatologyAssessment;
use App\Models\DermatologyRecommendation;
use App\Models\DermatologyImageAnalysis;
use App\Models\DermatologyMeasurement;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class DermatologyController extends Controller
{
    public function index()
    {
        $patientId = request()->query('patient_id');
        $patient = null;

        if ($patientId) {
            $patient = Patient::find($patientId);
        }

        return view('doctor.specialization.dermatology.index', compact('patient'));
    }

    public function consultation()
    {
        $patientId = request()->query('patient_id');
        $patient = null;
        $consultations = collect();

        if ($patientId) {
            $patient = Patient::find($patientId);
            $consultations = DermatologyConsultation::where('patient_id', $patientId)
                ->where('doctor_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('doctor.specialization.dermatology.consultation', compact('patient', 'consultations'));
    }

    public function imaging()
    {
        $patientId = request()->query('patient_id');
        $patient = null;
        $imageAnalyses = collect();

        if ($patientId) {
            $patient = Patient::find($patientId);
            $imageAnalyses = DermatologyImageAnalysis::where('patient_id', $patientId)
                ->where('doctor_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('doctor.specialization.dermatology.imaging', compact('patient', 'imageAnalyses'));
    }

    public function imageAnalysis()
    {
        $patientId = request()->query('patient_id');
        $patient = null;
        $imageAnalyses = collect();

        if ($patientId) {
            $patient = Patient::find($patientId);
            $imageAnalyses = DermatologyImageAnalysis::where('patient_id', $patientId)
                ->where('doctor_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('doctor.specialization.dermatology.image-analysis', compact('patient', 'imageAnalyses'));
    }

    public function simulation()
    {
        $patientId = request()->query('patient_id');
        $patient = null;

        if ($patientId) {
            $patient = Patient::find($patientId);
        }

        return view('doctor.specialization.dermatology.simulation', compact('patient'));
    }

    public function treatment()
    {
        $patientId = request()->query('patient_id');
        $patient = null;
        $assessments = collect();
        $recommendations = collect();

        if ($patientId) {
            $patient = Patient::find($patientId);
            $assessments = DermatologyAssessment::where('patient_id', $patientId)
                ->where('doctor_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
            $recommendations = DermatologyRecommendation::where('patient_id', $patientId)
                ->where('doctor_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('doctor.specialization.dermatology.treatment', compact('patient', 'assessments', 'recommendations'));
    }

    public function history()
    {
        $patientId = request()->query('patient_id');
        $patient = null;
        $consultations = collect();
        $assessments = collect();
        $recommendations = collect();
        $imageAnalyses = collect();
        $measurements = collect();

        if ($patientId) {
            $patient = Patient::find($patientId);
            $consultations = DermatologyConsultation::where('patient_id', $patientId)
                ->where('doctor_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
            $assessments = DermatologyAssessment::where('patient_id', $patientId)
                ->where('doctor_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
            $recommendations = DermatologyRecommendation::where('patient_id', $patientId)
                ->where('doctor_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
            $imageAnalyses = DermatologyImageAnalysis::where('patient_id', $patientId)
                ->where('doctor_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
            $measurements = DermatologyMeasurement::where('patient_id', $patientId)
                ->where('doctor_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('doctor.specialization.dermatology.history', compact('patient', 'consultations', 'assessments', 'recommendations', 'imageAnalyses', 'measurements'));
    }

    public function reports()
    {
        $patientId = request()->query('patient_id');
        $patient = null;
        $consultations = collect();
        $assessments = collect();
        $recommendations = collect();
        $imageAnalyses = collect();
        $measurements = collect();
        $reports = collect();

        if ($patientId) {
            $patient = Patient::find($patientId);
            $consultations = DermatologyConsultation::where('patient_id', $patientId)
                ->where('doctor_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
            $assessments = DermatologyAssessment::where('patient_id', $patientId)
                ->where('doctor_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
            $recommendations = DermatologyRecommendation::where('patient_id', $patientId)
                ->where('doctor_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
            $imageAnalyses = DermatologyImageAnalysis::where('patient_id', $patientId)
                ->where('doctor_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
            $measurements = DermatologyMeasurement::where('patient_id', $patientId)
                ->where('doctor_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
            $reports = \App\Models\Report::where('patient_id', $patientId)
                ->where('doctor_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('doctor.specialization.dermatology.reports', compact('patient', 'consultations', 'assessments', 'recommendations', 'imageAnalyses', 'measurements', 'reports'));
    }

    public function storeReport(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        $patientId = $validated['patient_id'];
        $doctorId = Auth::id();

        // Fetch all relevant dermatology data for the patient and doctor
        $consultations = \App\Models\DermatologyConsultation::where('patient_id', $patientId)
            ->where('doctor_id', $doctorId)
            ->orderBy('created_at', 'desc')->get();
        $assessments = \App\Models\DermatologyAssessment::where('patient_id', $patientId)
            ->where('doctor_id', $doctorId)
            ->orderBy('created_at', 'desc')->get();
        $recommendations = \App\Models\DermatologyRecommendation::where('patient_id', $patientId)
            ->where('doctor_id', $doctorId)
            ->orderBy('created_at', 'desc')->get();
        $imageAnalyses = \App\Models\DermatologyImageAnalysis::where('patient_id', $patientId)
            ->where('doctor_id', $doctorId)
            ->orderBy('created_at', 'desc')->get();
        $measurements = \App\Models\DermatologyMeasurement::where('patient_id', $patientId)
            ->where('doctor_id', $doctorId)
            ->orderBy('created_at', 'desc')->get();

        $reportData = [
            'consultations' => $consultations,
            'assessments' => $assessments,
            'recommendations' => $recommendations,
            'image_analyses' => $imageAnalyses,
            'measurements' => $measurements,
        ];

        $report = \App\Models\Report::create([
            'patient_id' => $patientId,
            'doctor_id' => $doctorId,
            'name' => $validated['name'],
            'type' => $validated['type'],
            'status' => $validated['status'] ?? 'completed',
            'data' => $reportData,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Report created successfully!',
            'report' => $report
        ]);
    }

    // AJAX Methods
    public function storeConsultation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'chief_complaint' => 'required|string|max:500',
            'history_of_present_illness' => 'required|string',
            'past_medical_history' => 'nullable|string',
            'family_history' => 'nullable|string',
            'social_history' => 'nullable|string',
            'medications' => 'nullable|string',
            'allergies' => 'nullable|string',
            'vital_signs' => 'nullable|string',
            'physical_examination' => 'required|string',
            'diagnosis' => 'required|string',
            'treatment_plan' => 'required|string',
            'follow_up' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $consultation = DermatologyConsultation::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => Auth::id(),
            'chief_complaint' => $request->chief_complaint,
            'history_of_present_illness' => $request->history_of_present_illness,
            'past_medical_history' => $request->past_medical_history,
            'family_history' => $request->family_history,
            'social_history' => $request->social_history,
            'medications' => $request->medications,
            'allergies' => $request->allergies,
            'vital_signs' => $request->vital_signs,
            'physical_examination' => $request->physical_examination,
            'diagnosis' => $request->diagnosis,
            'treatment_plan' => $request->treatment_plan,
            'follow_up' => $request->follow_up,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Consultation saved successfully!',
            'consultation' => $consultation
        ]);
    }

    public function storeAssessment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'assessment_type' => 'required|string|max:100',
            'findings' => 'required|string',
            'severity' => 'required|in:mild,moderate,severe',
            'recommendations' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $assessment = DermatologyAssessment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => Auth::id(),
            'assessment_type' => $request->assessment_type,
            'findings' => $request->findings,
            'severity' => $request->severity,
            'recommendations' => $request->recommendations,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Assessment saved successfully!',
            'assessment' => $assessment
        ]);
    }

    public function storeRecommendation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'recommendation_type' => 'required|string|max:100',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'expected_outcome' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $recommendation = DermatologyRecommendation::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => Auth::id(),
            'recommendation_type' => $request->recommendation_type,
            'description' => $request->description,
            'priority' => $request->priority,
            'expected_outcome' => $request->expected_outcome,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Recommendation saved successfully!',
            'recommendation' => $recommendation
        ]);
    }

    public function storeImageAnalysis(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'image_type' => 'required|string|max:100',
            'analysis_results' => 'required|string',
            'confidence_score' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'before_image_data' => 'nullable|string',
            'after_image_data' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $beforeImagePath = null;
            $afterImagePath = null;

            // Save before image if provided
            if ($request->before_image_data) {
                $beforeImagePath = $this->saveBase64Image($request->before_image_data, 'before_' . time() . '.jpg');
            }

            // Save after image if provided
            if ($request->after_image_data) {
                $afterImagePath = $this->saveBase64Image($request->after_image_data, 'after_' . time() . '.jpg');
            }

            $imageAnalysis = DermatologyImageAnalysis::create([
                'patient_id' => $request->patient_id,
                'doctor_id' => Auth::id(),
                'image_type' => $request->image_type,
                'analysis_results' => $request->analysis_results,
                'confidence_score' => $request->confidence_score,
                'notes' => $request->notes,
                'before_image' => $beforeImagePath,
                'after_image' => $afterImagePath,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Image analysis saved successfully!',
                'imageAnalysis' => $imageAnalysis
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving image analysis: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save base64 image data to file
     */
    private function saveBase64Image($base64Data, $filename)
    {
        try {
            // Remove data URL prefix if present
            $base64Data = preg_replace('/^data:image\/\w+;base64,/', '', $base64Data);
            // Decode base64 data
            $imageData = base64_decode($base64Data);
            if ($imageData === false) {
                throw new \Exception('Invalid base64 image data');
            }
            // Validate image data
            $imageInfo = getimagesizefromstring($imageData);
            if ($imageInfo === false) {
                throw new \Exception('Invalid image format');
            }
            // Check file size (max 10MB)
            if (strlen($imageData) > 10 * 1024 * 1024) {
                throw new \Exception('Image file size exceeds 10MB limit');
            }
            // Save to public/uploads/dermatology/images
            $directory = public_path('uploads/dermatology/images');
            if (!file_exists($directory)) {
                if (!mkdir($directory, 0755, true)) {
                    throw new \Exception('Failed to create directory for image storage');
                }
            }
            $uniqueFilename = time() . '_' . uniqid() . '_' . $filename;
            $filePath = $directory . '/' . $uniqueFilename;
            if (file_put_contents($filePath, $imageData) === false) {
                throw new \Exception('Failed to save image file');
            }
            // Return public path for use in the frontend
            return 'uploads/dermatology/images/' . $uniqueFilename;
        } catch (\Exception $e) {
            \Log::error('Image save error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function storeMeasurement(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'measurement_type' => 'required|string|max:100',
            'value' => 'required|numeric',
            'unit' => 'required|string|max:20',
            'body_part' => 'required|string|max:100',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $measurement = DermatologyMeasurement::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => Auth::id(),
            'measurement_type' => $request->measurement_type,
            'value' => $request->value,
            'unit' => $request->unit,
            'body_part' => $request->body_part,
            'notes' => $request->notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Measurement saved successfully!',
            'measurement' => $measurement
        ]);
    }

    public function getImageAnalysis($id)
    {
        $imageAnalysis = DermatologyImageAnalysis::where('id', $id)
            ->where('doctor_id', Auth::id())
            ->with('patient')
            ->first();

        if (!$imageAnalysis) {
            return response()->json([
                'success' => false,
                'message' => 'Image analysis not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'imageAnalysis' => $imageAnalysis
        ]);
    }

    public function downloadReportPdf($id)
    {
        $report = \App\Models\Report::with('patient', 'doctor')->findOrFail($id);
        $view = 'doctor.specialization.dermatology.report-pdf';
        $pdf = Pdf::loadView($view, ['report' => $report]);
        $filename = 'report_' . $report->id . '.pdf';
        return $pdf->download($filename);
    }
}
