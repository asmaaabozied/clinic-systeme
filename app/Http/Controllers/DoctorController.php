<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\DoctorSpecialization;
use App\Models\Appointment;
use App\Models\PatientInvoice;
use App\Models\Patient;
use App\Models\ProductService;
use App\Models\PrescriptionMedicine;
use App\Models\Operation;
use App\Models\VisitType;
use App\Models\Department;
use App\Models\PatientMedication;
use App\Models\MedicationHistory;
use App\Models\LabInvestigation;
use App\Models\LabInvestigationResult;
use App\Models\PreOperativeChecklist;
use App\Models\TreatmentPlan;
use App\Http\Requests\StoreMedicationRequest;
use App\Http\Requests\StoreOperationRequest;
use App\Http\Requests\StorePreOperativeChecklistRequest;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Milon\Barcode\DNS1D;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'XSS']);
    }

    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        if (!auth()->user()->hasRole('Doctor')) {
            return redirect()->route('login');
        }

        $doctor = Doctor::withoutGlobalScope('tenant')
            ->where('user_id', Auth::id())
            ->first();

        if (!$doctor) {
            //logout
            Auth::logout();
            return redirect()->route('login')->with('error', 'Doctor profile not found.');
        }

        // Overview Tab Data
        $todayPatients = Appointment::where('consultant_doctor_id', $doctor->id)
            ->whereDate('appointment_date', today())
            ->count();

        $weeklySurgeries = Appointment::where('consultant_doctor_id', $doctor->id)
            ->where('case', 'emergency')
            ->whereBetween('appointment_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        $monthlyRevenue = PatientInvoice::join('appointments', 'patient_invoices.appointment_id', '=', 'appointments.id')
            ->where('appointments.consultant_doctor_id', $doctor->id)
            ->whereMonth('patient_invoices.created_at', now()->month)
            ->sum('patient_invoices.amount');

        $satisfactionRate = 98; // This could be calculated based on patient feedback if available

        $recentPatients = Appointment::with(['patient'])
            ->where('consultant_doctor_id', $doctor->id)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($appointment) {
                return [
                    'id' => $appointment->patient?->id,
                    'name' => $appointment->patient?->name ?? 'Unknown Patient',
                    'avatar' => $appointment->patient?->photo ?? 'default-avatar.png',
                    'last_visit' => \Carbon\Carbon::parse($appointment->appointment_date)->diffForHumans(),
                    'status' => $appointment->case,
                    ];
            });

        $todayAppointments = Appointment::with(['patient', 'charge'])
            ->where('consultant_doctor_id', $doctor->id)
            ->whereDate('appointment_date', today())
            ->get()
            ->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'time' => $appointment->appointment_date->format('h:i A'),
                    'patient_name' => $appointment->patient->name,
                    'type' => $appointment->charge->name ?? 'General Checkup',
                    'status' => $appointment->case,
                ];
            });

        $inventoryAlerts = ProductService::where('quantity', '<', 10)
            ->where('type', 'product')
            ->take(5)
            ->get()
            ->map(function($product) {
                return [
                    'item_name' => $product->name,
                    'message' => "Only {$product->quantity} items left in stock",
                    'priority' => $product->quantity < 5 ? 'high' : 'medium'
                ];
            });

        // Patients Tab Data with pagination
        $patients = Patient::whereHas('appointments', function ($query) use ($doctor) {
                $query->where('consultant_doctor_id', $doctor->id);
            })
            ->with(['appointments.charge', 'appointments.doctor.user'])
            ->latest()
            ->get()
            ->each(function ($patient) {
                $appointment = $patient->appointments->first();

                return [
                    'id' => $patient->id,
                    'name' => $patient->name,
                    'avatar' => $patient->photo ?? 'default-avatar.png',
                    'date_of_birth' => $patient->date_of_birth,
                    'gender' => $patient->gender,
                    'phone' => $patient->phone,
                    'email' => $patient->email,
                    'procedure' => $appointment?->charge?->name ?? '',
                    'date' => $appointment?->appointment_date?->format('Y-m-d') ?? '',
                    'status' => $appointment?->case ?? '',
                    'doctor' => $appointment?->doctor?->user?->name ?? '',
                ];
            });

        // Surgical Tab Data
        $surgicalSchedule = Appointment::with(['patient', 'charge', 'doctor'])
            ->where('consultant_doctor_id', $doctor->id)
            ->where('case', 'emergency')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($case) {
                return [
                    'id' => $case->id,
                    'date' => $case->appointment_date->format('Y-m-d'),
                    'time' => $case->appointment_date->format('H:i'),
                    'status' => $case->case,
                    'procedure' => $case->charge->name ?? 'Surgery',
                    'patient' => $case->patient->name ?? 'Unknown',
                    'surgeon' => $case->doctor->user->name ?? 'N/A',
                    'room' => $case->room ?? 'OR-1',
                    'duration' => $case->duration ?? '2h',
                    'anesthesia' => $case->anesthesia ?? 'General',
                    'assistants' => [],
                    'equipment' => [],
                    'notes' => $case->note ?? '',
                ];
            });

        // Inventory Tab Data
        $inventory = ProductService::where('type', 'product')
            ->with(['category', 'unit'])
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'brand' => $item->sku,
                    'size' => '',
                    'category' => $item->category->name ?? '',
                    'quantity' => $item->quantity ?? 0,
                    'unit' => $item->unit->name ?? '',
                    'minStock' => $item->min_stock ?? 0,
                    'maxStock' => $item->max_stock ?? 100,
                    'cost' => $item->purchase_price,
                    'supplier' => '',
                    'lastOrdered' => $item->created_at->format('Y-m-d'),
                    'expiryDate' => $item->expire_date ?? now()->format('Y-m-d'),
                    'location' => '',
                    'status' => $item->quantity > 10 ? 'good' : ($item->quantity > 0 ? 'low' : 'critical'),
                ];
            });

        $inventoryData = $inventory;

        return view('doctor.dashboard', compact(
            'todayPatients',
            'weeklySurgeries',
            'monthlyRevenue',
            'satisfactionRate',
            'recentPatients',
            'todayAppointments',
            'inventoryAlerts',
            'patients',
            'surgicalSchedule',
            'inventory',
            'inventoryData'
        ));
    }

    public function index()
    {
        $doctors = Doctor::with('specialization')->latest()->paginate(10);
        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = User::where('type', 'doctor')->get();
        $specializations = DoctorSpecialization::all();

        return view('doctors.create', compact('doctors', 'specializations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'specialization_id' => 'required|exists:doctor_specializations,id',
            'phone' => 'nullable|string|max:20',
            'clinic_address' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'bio' => 'nullable|string',
        ]);

        $doctor = Doctor::create($validated);

        $doctor->doctor_code = 1000 + $doctor->id;
        $doctor->save();
        return redirect()->route('doctors.index')->with('success', 'Doctor added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        return view('doctors.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        $specializations = DoctorSpecialization::all();
        $doctors = User::where('type', 'doctor')->get();
        return view('doctors.edit', compact('doctor', 'specializations', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'doctor_specialization_id' => 'required|exists:doctor_specializations,id',
            'email' => 'nullable|email|unique:doctors,email,' . $doctor->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0',
            'clinic_address' => 'nullable|string|max:255',
        ]);

        $doctor->update([
            'user_id' => $request->input('user_id'),
            'specialization_id' => $request->input('doctor_specialization_id'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'bio' => $request->input('bio'),
            'experience_years' => $request->input('experience_years'),
            'clinic_address' => $request->input('clinic_address'),
        ]);

        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
    }

    public function livesearch(Request $request)
    {
        $query = $request->get('q');

        $doctors = Doctor::with(['specialization', 'user'])
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->whereHas('user', function ($q) use ($query) {
                    $q->where('name', 'like', "%$query%")
                        ->orWhere('email', 'like', "%$query%");
                })->orWhereHas('specialization', function ($q) use ($query) {
                    $q->where('name', 'like', "%$query%");
                });
            })
            ->get()
            ->map(function ($doctor) {
                return [
                    'id' => $doctor->id,
                    'name' => $doctor->user->name ?? null,
                    'email' => $doctor->user->email ?? null,
                    'phone' => $doctor->phone,
                    'specialization_name' => $doctor->specialization->name ?? null,
                ];
            });
        return response()->json(['doctors' => $doctors]);
    }

    public function patients()
    {
        return $this->dashboard()->with('activeTab', 'patients');
    }

    public function surgical()
    {
        return $this->dashboard()->with('activeTab', 'surgical');
    }

    public function inventory()
    {
        return $this->dashboard()->with('activeTab', 'inventory');
    }

    public function patientShow($id)
    {
        $patient = Patient::with(['tpaPatient.tpa'])->findOrFail($id);

        $modules = ['OPD', 'Pharmacy', 'Pathology', 'Radiology', 'Blood Bank', 'Ambulance'];
        $billing = [];
        $specializations = DoctorSpecialization::query()->get();

        foreach ($modules as $moduleName) {
            $summary = PatientInvoice::selectRaw('SUM(paidAmount) as paid, SUM(amount) as total')
                ->join('charge_categories', 'patient_invoices.charge_category_id', '=', 'charge_categories.id')
                ->join('charge_types', 'charge_categories.charge_type_id', '=', 'charge_types.id')
                ->join('charge_type_module', 'charge_types.id', '=', 'charge_type_module.charge_type_id')
                ->join('modules', 'charge_type_module.module_id', '=', 'modules.id')
                ->where('modules.name', $moduleName)
                ->where('patient_invoices.patient_id', $patient->id)
                ->first();

            $paid = $summary->paid ?? 0;
            $total = $summary->total ?? 0;
            $percentage = $total > 0 ? round(($paid / $total) * 100, 2) : 0;

            $billing[strtolower(str_replace(' ', '_', $moduleName))] = [
                'paid' => $paid,
                'amount' => $total,
                'percentage' => $percentage,
            ];
        }

        $totalPaid = PatientInvoice::query()->selectRaw('SUM(paidAmount) as paid, SUM(amount) as total')
            ->where('patient_id', $patient->id)
            ->first()?->paid ?? 0;

        $recent_medications = PrescriptionMedicine::with([
                'medicine',
                'prescription.doctor.user',
                'dose',
                'dose_interval',
                'dose_duration'
            ])
            ->whereHas('prescription', function ($q) use ($patient) {
                $q->where('patient_id', $patient->id);
            })
            ->latest()
            ->take(5)
            ->get();

        $medications = PatientMedication::with('doctor.user')
            ->where('patient_id', $patient->id)
            ->get();

        $medicationHistory = MedicationHistory::with('medication.doctor.user')
            ->whereHas('medication', function ($q) use ($patient) {
                $q->where('patient_id', $patient->id);
            })
            ->latest('taken_at')
            ->get();

        $activeMedications = $medications->where('status', 'active')->count();
        $completedToday = $medicationHistory->where('status', 'taken')
            ->where('taken_at', '>=', now()->startOfDay())
            ->where('taken_at', '<=', now()->endOfDay())
            ->count();
        $pendingToday = $medicationHistory->where('status', 'pending')
            ->where('taken_at', '>=', now()->startOfDay())
            ->where('taken_at', '<=', now()->endOfDay())
            ->count();

        $recent_operations = Operation::where('patient_id', $patient->id)
            ->orderByDesc('operation_date')
            ->take(5)
            ->get();

        $operations = Operation::where('patient_id', $patient->id)
            ->orderByDesc('operation_date')
            ->get();

        $preOpChecklists = PreOperativeChecklist::where('patient_id', $patient->id)
            ->orderByDesc('date_completed')
            ->get();

        $operationStats = [
            'total'       => $operations->count(),
            'completed'   => $operations->where('status', 'completed')->count(),
            'scheduled'   => $operations->where('status', 'scheduled')->count(),
            'success_rate'=> $operations->count() > 0
                ? round(($operations->where('status', 'completed')->count() / $operations->count()) * 100, 2)
                : 0,
        ];

        $labInvestigations = LabInvestigation::with('doctor.user', 'results')
            ->where('patient_id', $patient->id)
            ->orderByDesc('test_date')
            ->get();

        $labResults = LabInvestigationResult::whereIn('lab_investigation_id', $labInvestigations->pluck('id'))
            ->orderByDesc('date')
            ->get();

        $labStats = [
            'total' => $labInvestigations->count(),
            'pending' => $labInvestigations->where('status', 'processing')->count(),
            'completed' => $labInvestigations->where('status', 'completed')->count(),
            'abnormal' => $labResults->where('status', '!=', 'normal')->count(),
        ];

        $treatmentPlans = TreatmentPlan::with('doctor.user')
            ->where('patient_id', $patient->id)
            ->orderByDesc('start_date')
            ->get();

        $currentTreatments = $treatmentPlans->where('status', 'active');
        $pastTreatments = $treatmentPlans->where('status', '!=', 'active');

        $treatmentStats = [
            'total' => $treatmentPlans->count(),
            'active' => $currentTreatments->count(),
            'completed' => $treatmentPlans->where('status', 'completed')->count(),
            'success_rate' => $treatmentPlans->count() > 0
                ? round(($treatmentPlans->where('status', 'completed')->count() / $treatmentPlans->count()) * 100, 2)
                : 0,
        ];

        $visitHistory = Appointment::with(['doctor.user', 'charge', 'consultation'])
            ->where('patient_id', $patient->id)
            ->orderByDesc('appointment_date')
            ->get();

        $pastVisits = $visitHistory->filter(fn ($v) => $v->appointment_date->lt(now()->startOfDay()));
        $todayVisits = $visitHistory->filter(fn ($v) => $v->appointment_date->isSameDay(now()));
        $upcomingVisits = $visitHistory->filter(fn ($v) => $v->appointment_date->gt(now()->endOfDay()));

        $visitStats = [
            'total_visits'    => $visitHistory->count(),
            'this_month'      => $visitHistory->whereBetween('appointment_date', [now()->startOfMonth(), now()->endOfMonth()])->count(),
            'last_visit'      => optional($visitHistory->where('appointment_date', '<=', now())->sortByDesc('appointment_date')->first())->appointment_date?->format('d/m/Y'),
            'next_appointment'=> optional($visitHistory->where('appointment_date', '>', now())->sortBy('appointment_date')->first())->appointment_date?->format('d/m/Y'),
        ];

        $doctors = Schema::hasTable('doctors') ? Doctor::with('user')->get() : collect();
        $visitTypes = Schema::hasTable('visit_types') ? VisitType::all() : collect();
        $departments = Schema::hasTable('departments') ? Department::all() : collect();

        $appointmentsWithCharges = Appointment::with([
            'chargeItems.charge.tax',
            'chargeItems.charge.chargeType',
            'chargeItems.charge.chargeCategory',
            'consultationServiceItems.charge.tax',
            'consultationServiceItems.charge.chargeType',
            'consultationServiceItems.charge.chargeCategory',
        ])->where('patient_id', $patient->id)->get();

        $patientCharges = collect();
        foreach ($appointmentsWithCharges as $ap) {
            $patientCharges = $patientCharges->merge($ap->chargeItems)->merge($ap->consultationServiceItems);
        }

        $totalChargeAmount = $patientCharges->sum('amount');
        $totalChargePaid = $patientCharges->where('is_paid', true)->sum('amount');

        $chargeCategoriesSummary = $patientCharges->groupBy(function ($item) {
            return optional($item->charge->chargeCategory)->name ?? 'Other';
        })->map(function ($items) {
            $subtotal = $items->sum('applied_charge');
            $tax = $items->sum(function ($i) {
                $discountAmount = $i->applied_charge * ($i->discount / 100);
                $sub = $i->applied_charge - $discountAmount;
                return $sub * ($i->tax / 100);
            });
            $total = $items->sum('amount');

            return [
                'count' => $items->count(),
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
            ];
        });

        $latestAppointment = $patient->appointments()
            ->with(['doctor.user', 'patientInvoice'])
            ->latest('appointment_date')
            ->first();

        $svg = QrCode::format('svg')->size(50)->generate(route('patients.show.for.qr.code', $patient->id));
        $base64 = base64_encode($svg);

        $barcode = new DNS1D();
        $barcode->setStorPath(public_path('barcodes'));
        $barcode_png = $barcode->getBarcodePNG($patient->patient_code, 'C39', 2, 25);
        $barcodeDataUri = 'data:image/png;base64,' . $barcode_png;

        $qr_code = 'data:image/svg+xml;base64,' . $base64;
        $barcode = $barcodeDataUri;

        // Live Consultation Data
        $liveConsultations = \App\Models\LiveConsultation::with(['doctor.user'])
            ->where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $consultationStats = [
            'total' => $liveConsultations->where('status', 'completed')->count(),
            'this_month' => $liveConsultations->where('status', 'completed')
                ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->count(),
            'average_duration' => $liveConsultations->where('status', 'completed')
                ->whereNotNull('started_at')
                ->whereNotNull('ended_at')
                ->avg(function($consultation) {
                    return $consultation->started_at->diffInMinutes($consultation->ended_at);
                }) ?? 0,
            'next_session' => $liveConsultations->where('status', 'scheduled')
                ->where('scheduled_at', '>', now())
                ->sortBy('scheduled_at')
                ->first()?->scheduled_at?->format('d/m/Y h:i A'),
        ];

        $activeConsultation = $liveConsultations->where('status', 'active')->first();
        $upcomingConsultations = $liveConsultations->where('status', 'scheduled')
            ->where('scheduled_at', '>', now())
            ->take(3);

        return view('patient.show.index', compact(
            'patient',
            'qr_code',
            'totalPaid',
            'barcode',
            'billing',
            'liveConsultations',
            'consultationStats',
            'activeConsultation',
            'upcomingConsultations',
            'recent_medications',
            'recent_operations',
            'operations',
            'operationStats',
            'latestAppointment',
            'visitStats',
            'pastVisits',
            'todayVisits',
            'upcomingVisits',
            'doctors',
            'visitTypes',
            'departments',
            'medications',
            'medicationHistory',
            'activeMedications',
            'completedToday',
            'pendingToday',
            'labInvestigations',
            'labResults',
            'labStats',
            'preOpChecklists',
            'treatmentPlans',
            'currentTreatments',
            'pastTreatments',
            'treatmentStats',
            'specializations',
            'patientCharges',
            'totalChargeAmount',
            'totalChargePaid',
            'chargeCategoriesSummary',
        ));
    }

    public function storeMedication(StoreMedicationRequest $request, Patient $patient)
    {
        $doctorId = Auth::user()->doctor->id ?? null;

        PatientMedication::create([
            'patient_id'    => $patient->id,
            'doctor_id'     => $doctorId,
            'medicine_name' => $request->medicine_name,
            'dosage'        => $request->dosage,
            'frequency'     => $request->frequency,
            'start_date'    => now(),
            'end_date'      => now()->addDays((int) $request->duration),
            'status'        => 'active',
        ]);

        return back()->with('success', 'Medication added successfully.');
    }

    public function storeOperation(StoreOperationRequest $request, Patient $patient)
    {
        $patient->operations()->create($request->validated());

        return back()->with('success', 'Operation scheduled successfully.');
    }

    public function storePreOpChecklist(StorePreOperativeChecklistRequest $request, Patient $patient)
    {
        $patient->preOperativeChecklists()->create($request->validated());

        return back()->with('success', 'Checklist item added successfully.');
    }

    public function storeTreatmentPlan(Request $request, Patient $patient)
    {
        $doctorId = Auth::user()->doctor->id ?? null;

        $request->validate([
            'name' => 'required|string|max:255',
            'condition' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'duration' => 'required|integer|min:1',
            'doctor_id' => 'nullable|exists:doctors,id',
            'priority' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $expectedEnd = \Carbon\Carbon::parse($request->start_date)->addDays((int)$request->duration);

        TreatmentPlan::create([
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id ?? $doctorId,
            'name' => $request->name,
            'condition' => $request->condition,
            'start_date' => $request->start_date,
            'expected_end_date' => $expectedEnd,
            'priority' => $request->priority ?? 'normal',
            'description' => $request->description,
            'status' => 'active',
        ]);

        return back()->with('success', 'Treatment plan created successfully.');
    }
}
