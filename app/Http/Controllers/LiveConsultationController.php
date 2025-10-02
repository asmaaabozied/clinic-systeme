<?php

namespace App\Http\Controllers;

use App\Models\LiveConsultation;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\User;
use App\Models\ConsultationNote;
use App\Traits\ZoomMeetingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class LiveConsultationController extends Controller
{
    use ZoomMeetingTrait;

    public function __construct()
    {
        $this->middleware(['auth', 'XSS']);
    }

    /**
     * Start an instant consultation
     */
    public function startInstantConsultation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'consultation_type' => 'required|in:instant,follow-up,emergency,second-opinion,routine',
            'notes' => 'nullable|string',
            'symptoms' => 'nullable|array',
            'is_emergency' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        try {
            $patient = Patient::findOrFail($request->patient_id);
            $doctorId = Auth::user()->doctor->id;
            $doctor = Doctor::findOrFail($doctorId);

            // Create Zoom meeting
            $zoomData = [
                'title' => "Consultation: {$patient->name} with Dr. {$doctor->user->name}",
                'duration' => 60,
                'agenda' => $request->notes ?? "Medical consultation between {$patient->name} and Dr. {$doctor->user->name}",
            ];

            $zoomMeeting = $this->createInstantMeeting($zoomData);

            if (!$zoomMeeting['success']) {
                return response()->json(['success' => false, 'message' => 'Failed to create Zoom meeting'], 500);
            }

            // Create consultation record
            $consultation = LiveConsultation::create([
                'patient_id' => $request->patient_id,
                'doctor_id' => $doctorId,
                'consultation_type' => $request->consultation_type,
                'title' => "Consultation: {$patient->name} with Dr. {$doctor->user->name}",
                'reason' => $request->notes ?? null,
                'status' => 'active',
                'started_at' => now(),
                'zoom_meeting_id' => $zoomMeeting['data']['id'],
                'zoom_start_url' => $zoomMeeting['data']['start_url'],
                'zoom_join_url' => $zoomMeeting['data']['join_url'],
                'zoom_password' => $zoomMeeting['data']['password'],
                'created_by' => Auth::id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Consultation started successfully',
                'consultation' => $consultation->load(['patient', 'doctor.user']),
                'zoom_urls' => [
                    'start_url' => $zoomMeeting['data']['start_url'],
                    'join_url' => $zoomMeeting['data']['join_url'],
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error starting consultation: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Schedule a consultation
     */
    public function scheduleConsultation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'consultation_type' => 'required|in:follow-up,initial,emergency,second-opinion,routine',
            'scheduled_at' => 'required|date|after:now',
            'duration_minutes' => 'required|integer|min:15|max:180',
            'notes' => 'nullable|string',
            'is_emergency' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        try {
            $doctorId = Auth::user()->doctor->id;
            $doctor = Doctor::findOrFail($doctorId);
            $patientId = $request->route('patient_id') ?? $request->patient_id ?? null;
            if (!$patientId) {
                return response()->json(['success' => false, 'message' => 'Patient not found'], 422);
            }
            $patient = Patient::findOrFail($patientId);

            $zoomData = [
                'title' => "Scheduled Consultation: {$patient->name} with Dr. {$doctor->user->name}",
                'type' => 2, // Scheduled meeting
                'start_time' => $request->scheduled_at,
                'duration' => $request->duration_minutes,
                'agenda' => $request->notes ?? "Scheduled medical consultation between {$patient->name} and Dr. {$doctor->user->name}",
            ];

            $zoomMeeting = $this->createMeeting($zoomData);

            if (!$zoomMeeting['success']) {
                return response()->json(['success' => false, 'message' => 'Failed to create Zoom meeting'], 500);
            }

            $consultation = LiveConsultation::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctorId,
                'consultation_type' => $request->consultation_type,
                'title' => "Scheduled Consultation: {$patient->name} with Dr. {$doctor->user->name}",
                'reason' => $request->notes ?? null,
                'status' => 'scheduled',
                'scheduled_at' => $request->scheduled_at,
                'duration' => $request->duration_minutes,
                'zoom_meeting_id' => $zoomMeeting['data']['id'],
                'zoom_start_url' => $zoomMeeting['data']['start_url'],
                'zoom_join_url' => $zoomMeeting['data']['join_url'],
                'zoom_password' => $zoomMeeting['data']['password'],
                'is_emergency' => $request->is_emergency ?? false,
                'created_by' => Auth::id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Consultation scheduled successfully',
                'consultation' => $consultation->load(['patient', 'doctor.user']),
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error scheduling consultation: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Start a consultation session
     */
    public function startConsultation($id)
    {
        $consultation = LiveConsultation::findOrFail($id);

        if (!$consultation->canStart()) {
            return response()->json(['success' => false, 'message' => 'Consultation cannot be started at this time'], 400);
        }

        $consultation->update([
            'status' => 'active',
            'started_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Consultation started successfully',
            'consultation' => $consultation->load(['patient', 'doctor.user']),
        ]);
    }

    /**
     * End a consultation session
     */
    public function endConsultation($id)
    {
        $consultation = LiveConsultation::findOrFail($id);

        if (!$consultation->isActive()) {
            return response()->json(['success' => false, 'message' => 'Consultation is not active'], 400);
        }

        $consultation->update([
            'status' => 'completed',
            'ended_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Consultation ended successfully',
            'consultation' => $consultation->load(['patient', 'doctor.user']),
        ]);
    }

    /**
     * Get consultation details
     */
    public function show($id)
    {
        $consultation = LiveConsultation::with(['patient', 'doctor.user', 'appointment'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'consultation' => $consultation,
        ]);
    }

    /**
     * Update consultation notes
     */
    public function updateNotes(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'notes' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'prescription' => 'nullable|string',
            'vital_signs' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $consultation = LiveConsultation::findOrFail($id);
        $consultation->update($request->only(['notes', 'diagnosis', 'prescription', 'vital_signs']));

        return response()->json([
            'success' => true,
            'message' => 'Notes updated successfully',
            'consultation' => $consultation->load(['patient', 'doctor.user']),
        ]);
    }

    /**
     * Get patient consultation history
     */
    public function getPatientHistory($patientId)
    {
        $consultations = LiveConsultation::with(['doctor.user'])
            ->where('patient_id', $patientId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'consultations' => $consultations,
        ]);
    }

    /**
     * Get active consultation
     */
    public function getActiveConsultation($patientId)
    {
        $consultation = LiveConsultation::with(['doctor.user'])
            ->where('patient_id', $patientId)
            ->where('status', 'active')
            ->first();

        return response()->json([
            'success' => true,
            'consultation' => $consultation,
        ]);
    }

    /**
     * Get doctor's consultations
     */
    public function getDoctorConsultations($doctorId = null)
    {
        $doctorId = $doctorId ?? Auth::user()->doctor->id ?? null;

        if (!$doctorId) {
            return response()->json([
                'success' => false,
                'message' => 'Doctor not found'
            ], 404);
        }

        $consultations = LiveConsultation::with(['patient', 'appointment'])
            ->where('doctor_id', $doctorId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'consultations' => $consultations,
        ]);
    }

    /**
     * Cancel a consultation
     */
    public function cancelConsultation($id)
    {
        $consultation = LiveConsultation::findOrFail($id);

        if ($consultation->isCompleted()) {
            return response()->json(['success' => false, 'message' => 'Cannot cancel completed consultation'], 400);
        }

        $consultation->update([
            'status' => 'cancelled',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Consultation cancelled successfully',
        ]);
    }

    /**
     * Get available doctors for consultation
     */
    public function getAvailableDoctors()
    {
        $doctors = Doctor::with('user')
            ->whereHas('user', function($query) {
                $query->where('is_active', true);
            })
            ->get()
            ->map(function($doctor) {
                return [
                    'id' => $doctor->id,
                    'name' => $doctor->user->name,
                    'specialization' => $doctor->specialization ?? 'General Medicine',
                    'email' => $doctor->user->email,
                ];
            });

        return response()->json([
            'success' => true,
            'doctors' => $doctors,
        ]);
    }

    /**
     * Get consultation types
     */
    public function getConsultationTypes()
    {
        $types = [
            ['value' => 'instant', 'label' => 'Instant Consultation'],
            ['value' => 'follow-up', 'label' => 'Follow-up'],
            ['value' => 'initial', 'label' => 'Initial Consultation'],
            ['value' => 'emergency', 'label' => 'Emergency Consultation'],
            ['value' => 'second-opinion', 'label' => 'Second Opinion'],
            ['value' => 'routine', 'label' => 'Routine Checkup'],
        ];

        return response()->json([
            'success' => true,
            'types' => $types,
        ]);
    }

    /**
     * Get all notes for a consultation
     */
    public function getNotes($consultationId)
    {
        $consultation = LiveConsultation::findOrFail($consultationId);
        $notes = $consultation->notes()->with('author')->orderBy('created_at', 'desc')->get();
        return response()->json(['success' => true, 'notes' => $notes]);
    }

    /**
     * Add a new note to a consultation
     */
    public function addNote(Request $request, $consultationId)
    {
        $request->validate([
            'notes' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'prescription' => 'nullable|string',
        ]);
        $consultation = LiveConsultation::findOrFail($consultationId);
        $note = $consultation->notes()->create([
            'notes' => $request->notes,
            'diagnosis' => $request->diagnosis,
            'prescription' => $request->prescription,
            'created_by' => auth()->id(),
        ]);
        return response()->json(['success' => true, 'note' => $note->load('author')]);
    }

    /**
     * Update a note
     */
    public function updateNote(Request $request, $noteId)
    {
        $request->validate([
            'notes' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'prescription' => 'nullable|string',
        ]);
        $note = ConsultationNote::findOrFail($noteId);
        $note->update($request->only(['notes', 'diagnosis', 'prescription']));
        return response()->json(['success' => true, 'note' => $note->fresh('author')]);
    }

    /**
     * Delete a note
     */
    public function deleteNote($noteId)
    {
        $note = ConsultationNote::findOrFail($noteId);
        $note->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Send WhatsApp message to patient with meeting link
     */
    public function sendWhatsApp($consultationId)
    {
        $consultation = LiveConsultation::with(['patient', 'doctor.user'])->findOrFail($consultationId);
        $patient = $consultation->patient;
        $doctor = $consultation->doctor->user;
        $clinicName = config('app.name', 'Our Clinic');
        $meetingDateTime = $consultation->scheduled_at ? $consultation->scheduled_at->format('d/m/Y h:i A') : ($consultation->started_at ? $consultation->started_at->format('d/m/Y h:i A') : '');
        $meetingLink = $consultation->zoom_join_url;
        $message = "Hello {$patient->name},\n\nThis is a reminder for your upcoming online consultation with Dr. {$doctor->name}.\n\n🗓 Date & Time: {$meetingDateTime}\n🔗 Meeting Link: {$meetingLink}\n\nPlease join the meeting a few minutes before your scheduled time. If you have any questions, feel free to reply to this message.\n\nThank you,\n{$clinicName}";
        $whatsappUrl = "https://wa.me/{$patient->phone}?text=" . urlencode($message);
        return response()->json(['success' => true, 'url' => $whatsappUrl]);
    }

    /**
     * Send Email to patient with meeting link
     */
    public function sendEmail($consultationId)
    {
        $consultation = LiveConsultation::with(['patient', 'doctor.user'])->findOrFail($consultationId);
        $patient = $consultation->patient;
        $doctor = $consultation->doctor->user;
        $clinicName = config('app.name', 'Our Clinic');
        $meetingDateTime = $consultation->scheduled_at ? $consultation->scheduled_at->format('d/m/Y h:i A') : ($consultation->started_at ? $consultation->started_at->format('d/m/Y h:i A') : '');
        $meetingLink = $consultation->zoom_join_url;
        $subject = "Your Online Consultation with Dr. {$doctor->name} – {$meetingDateTime}";
        $body = view('emails.consultation_meeting_link', [
            'patient' => $patient,
            'doctor' => $doctor,
            'meetingDateTime' => $meetingDateTime,
            'meetingLink' => $meetingLink,
            'clinicName' => $clinicName,
        ])->render();
        try {
            Mail::send([], [], function ($message) use ($patient, $subject, $body) {
                $message->to($patient->email)
                    ->subject($subject)
                    ->setBody($body, 'text/html');
            });
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

}
