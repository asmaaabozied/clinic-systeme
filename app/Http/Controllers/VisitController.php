<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Visit;
use App\Models\Doctor;
use App\Models\VisitType;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class VisitController extends Controller
{
    public function show($patientId)
    {
        $patient = Patient::with(['tpaPatient.tpa'])->findOrFail($patientId);

        $visitHistory = collect();
        if (Schema::hasTable('visits')) {
            $visitHistory = Visit::with(['doctor.user', 'department', 'visitType'])
                ->where('patient_id', $patient->id)
                ->orderByDesc('visit_date')
                ->get();
        }

        $visitStats = [
            'total_visits' => $visitHistory->count(),
            'this_month' => $visitHistory->whereBetween('visit_date', [now()->startOfMonth(), now()->endOfMonth()])->count(),
            'last_visit' => optional($visitHistory->where('visit_date', '<=', now())->sortByDesc('visit_date')->first())->visit_date?->format('d/m/Y'),
            'next_appointment' => optional($visitHistory->where('visit_date', '>', now())->sortBy('visit_date')->first())->visit_date?->format('d/m/Y'),
        ];

        $doctors = Schema::hasTable('doctors') ? Doctor::with('user')->get() : collect();
        $visitTypes = Schema::hasTable('visit_types') ? VisitType::all() : collect();
        $departments = Schema::hasTable('departments') ? Department::all() : collect();

        return view('patient.show.tabs.visits', [
            'patient' => $patient,
            'visitStats' => $visitStats,
            'visitHistory' => $visitHistory,
            'doctors' => $doctors,
            'visitTypes' => $visitTypes,
            'departments' => $departments,
        ]);
    }

    public function store(Request $request, $patientId)
    {
        $validated = $request->validate([
            'visit_date' => 'required|date',
            'visit_time' => 'required',
            'doctor_id' => 'required|exists:doctors,id',
            'case' => 'required',
            'visit_type_id' => 'required|exists:visit_types,id',
            'diagnosis' => 'nullable|string',
        ]);
        $appointment = Appointment::create([
            'patient_id' => $patientId,
            'consultant_doctor_id' => auth()->user()->doctor->id,
            'note' => $validated['diagnosis'],
            'appointment_date' => Carbon::parse($validated['visit_date'])->format('Y-m-d'),
            'case' => $validated['case'],
        ]);

//        if (Schema::hasTable('visits')) {
//            $exists = Visit::where('doctor_id', $validated['doctor_id'])
//                ->whereDate('visit_date', $validated['visit_date'])
//                ->where('visit_time', $validated['visit_time'])
//                ->exists();
//
//            if ($exists) {
//                return back()->withErrors([ 'doctor_id' => 'Doctor not available for selected time' ]);
//            }
//        }
//
//        $visit = Visit::create([
//            'patient_id' => $patientId,
//            'doctor_id' => $validated['doctor_id'],
//            'department_id' => $validated['department_id'],
//            'visit_type_id' => $validated['visit_type_id'],
//            'diagnosis' => $validated['diagnosis'],
//            'visit_date' => $validated['visit_date'],
//            'visit_time' => $validated['visit_time'],
//            'status' => 'scheduled',
        //]);

        return redirect()->back()->with('success', 'Appointment scheduled successfully');
    }
}
