<?php

namespace App\Http\Controllers;

use App\Models\CheckupChargeItem;
use App\Models\DoctorSpecialization;
use Carbon\Carbon;
use App\Models\Tpa;
use App\Models\Charge;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Facades\Log;
use Milon\Barcode\DNS1D;
use App\Models\ChargeType;
use App\Models\Appointment;
use App\Models\SymptomType;
use Illuminate\Http\Request;
use App\Models\ChargeCategory;
use App\Models\PatientInvoice;
use App\Models\SymptomCategory;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\MedicineCategory;
use App\Models\Dose;
use App\Models\DoseInterval;
use App\Models\DoseDuration;
use App\Models\Pathology;
use App\Models\Radiology;
use Spatie\Permission\Models\Role;
use App\Models\FindingCategory;
use App\Models\Checkup;
use App\Http\Requests\StoreOpdPatientRequest;
use Illuminate\Support\Facades\DB;

class OPDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tpas = Tpa::all();
        $patients = Patient::with([
            'appointments'
        ])->paginate(10);
        $doctors = Doctor::all();
        $symptoms = SymptomType::all();
        $symptomCategories =  [];
        $chargeCategories = ChargeCategory::all();
        $charges = Charge::all();
        $appointments = Appointment::paginate(10);

        $medicineCategories = MedicineCategory::all();
        $doses = Dose::all();
        $doseIntervals = DoseInterval::all();
        $doseDurations = DoseDuration::all();
        $pathologies = Pathology::all();
        $radiologies = Radiology::all();
        $roles = Role::all();
        $findingCategories  = FindingCategory::all();

        $patientCode = 'P-' . str_pad(Patient::count() + 1, 6, '0', STR_PAD_LEFT);
        $countries = \App\Models\Country::all();

        return view('opd.v2.index', compact(
            'tpas',
            'patients',
            'doctors',
            'symptoms',
            'symptomCategories',
            'charges',
            'chargeCategories',
            'appointments',
            'medicineCategories',
            'doses',
            'doseIntervals',
            'doseDurations',
            'pathologies',
            'radiologies',
            'roles',
            'findingCategories',
            'patientCode',
            'countries'
        ));
    }

    public function register()
    {
        $patientCode = 'P-' . str_pad(Patient::count() + 1, 6, '0', STR_PAD_LEFT);
        $countries = \App\Models\Country::all();
        return view('opd.new.patient_registration',compact('patientCode','countries'));
    }

    public function store(StoreOpdPatientRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $patient = Patient::create([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'gender' => strtolower($validated['gender']),
                'date_of_birth' => $validated['date_of_birth'],
                'document_id' => $validated['document_id'] ?? null,
                'blood_group' => $validated['blood_group'] ?? null,
                'marital_status' => $validated['marital_status'] ?? null,
                'remarks' => $validated['remarks'] ?? null,
            ]);

            $patient->patient_code ='P-' . str_pad(Patient::count() + 1, 6, '0', STR_PAD_LEFT);
            $patient->save();

            if (!empty($validated['addresses'])) {
                foreach ($validated['addresses'] as $address) {
                    $patient->addresses()->create($address);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('SAVE_ERROR',[
                'error' => $e->getMessage(),
                'exception' => $e
            ]);
            return redirect()->back()->with('error', 'Something went wrong.')->withInput($request->all());
        }

        if ($request->boolean('redirect_to_profile')) {
            return redirect()->route('opd.patient-profile', [
                'id' => $patient->id,
                'open_opd_modal' => 1,
            ])->with('success', 'Patient created successfully.');
        }

        return redirect()->route('opd.index')->with('success', 'Patient created successfully.');
    }


   public function lab(Appointment $appointment)
   //public function lab()
   {
      $patient = Patient::find($appointment->patient_id);
     // dd($patient);
  //  dd("123");
    // return view('opd.lab');
      return view('opd.lab', compact('patient'));
   }

    public function show(Appointment $appointment)
    {
         $patient = Patient::find($appointment->patient_id);
        // dd($patient);
      // dd($patient->date_of_birth);
     //  $doctor = Doctor::find($appointment->consultant_doctor_id);
      // dd($doctor);

        // dd($patient->name);
       // dd("22");
       // return view('opd.shownew', compact('patient'));
        return view('opd.patient', compact('patient'));

    }

    public function patientProfile($id)
    {
        $patient = Patient::with(['tpaPatient.tpa'])->findOrFail($id);
        $appointments = Appointment::where('patient_id', $id)->with('checkups')->latest()->get();
        $specializations = DoctorSpecialization::query()->get();

        $tpas = Tpa::all();
        $patients = Patient::all();
        $doctors = Doctor::all();
        $symptoms = SymptomType::all();
        $symptomCategories = [];
        $chargeCategories = ChargeCategory::all();
        $charges = Charge::all();
        $medicineCategories = MedicineCategory::all();
        $doses = Dose::all();
        $doseIntervals = DoseInterval::all();
        $doseDurations = DoseDuration::all();
        $pathologies = Pathology::all();
        $radiologies = Radiology::all();
        $roles = Role::all();
        $findingCategories = FindingCategory::all();
        $svg = QrCode::format('svg')->size(50)->generate(route('patients.show.for.qr.code', $patient->id));
        $base64 = base64_encode($svg);

        $barcode = new DNS1D();
        $barcode->setStorPath(public_path('barcodes'));
        $barcode_png = $barcode->getBarcodePNG($patient->patient_code, 'C39', 2, 25);
        $barcodeDataUri = 'data:image/png;base64,' . $barcode_png;

        $qr_code = 'data:image/svg+xml;base64,' . $base64;
        $barcode = $barcodeDataUri;

        return view('opd.v2.patient-profile', compact(
            'patient',
            'qr_code',
            'barcode',
            'appointments',
            'tpas',
            'patients',
            'doctors',
            'symptoms',
            'symptomCategories',
            'charges',
            'chargeCategories',
            'medicineCategories',
            'doses',
            'doseIntervals',
            'doseDurations',
            'pathologies',
            'radiologies',
            'roles',
            'findingCategories',
            'specializations',
        ));
    }

    public function visitDetails($id)
    {
        $appointment = Appointment::with([
            'patient',
            'chargeItems.charge.tax',
            'consultationServiceItems.charge.tax',
        ])->findOrFail($id);
        $specializations = DoctorSpecialization::query()->get();
        $checkups = $appointment->checkups()->with('doctor')->get();
        $tpas = Tpa::all();
        $patients = Patient::all();
        $doctors = Doctor::all();
        $symptoms = SymptomType::all();
        $symptomCategories = [];
        $chargeCategories = ChargeCategory::all();
        $charges = Charge::all();
        $medicineCategories = MedicineCategory::all();
        $doses = Dose::all();
        $doseIntervals = DoseInterval::all();
        $doseDurations = DoseDuration::all();
        $pathologies = Pathology::all();
        $radiologies = Radiology::all();
        $roles = Role::all();
        $findingCategories = FindingCategory::all();
        return view('opd.v2.visit-details', compact(
            'appointment',
            'checkups',
            'tpas',
            'patients',
            'doctors',
            'symptoms',
            'symptomCategories',
            'charges',
            'chargeCategories',
            'medicineCategories',
            'doses',
            'doseIntervals',
            'doseDurations',
            'pathologies',
            'radiologies',
            'roles',
            'findingCategories',
            'specializations',
        ));
    }

    public function storeCheckup(Request $request)
    {
        $symptomsTypeArray = array_filter(
            explode(',', $request->input('symptoms_type_array', '')),
            fn($v) => $v !== ''
        );
        $symptomsTypeArray = array_values($symptomsTypeArray);

//        if (empty($symptomsTypeArray) || !collect($symptomsTypeArray)->every(fn($id) => is_numeric($id))) {
//            return response()->json([
//                'errors' => ['symptoms_type_array' => ['Invalid symptom types selected.']]
//            ], 422);
//        }

        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'symptoms_description' => 'nullable|string',
            'allergies' => 'nullable|string',
            'note' => 'nullable|string',
            'previous_medical_issues' => 'nullable|string',
            'consultant_doctor_id' => 'required|exists:doctors,id',
//            'patient_id' => 'required|exists:patients,id|not_in:Select',
            'payment_method' => 'required|in:Cash,Card,BankTransfer',
            'checkup_date' => 'required|date',
            'case' => 'required',
            'casualty' => 'boolean',
            'old_patient' => 'boolean',
            'old_patient_id' => 'required_if:old_patient,1|nullable|string|max:255',
            'reference' => 'nullable|string|max:255',
            'apply_tpa' => 'nullable|boolean',
            'live_consultation' => 'boolean',
            'charges' => 'required|array|min:1',
            'charges.*.charge_id' => 'required|exists:charges,id',
            'charges.*.appliedCharge' => 'required|numeric|min:0',
            'charges.*.discount' => 'nullable|numeric|min:0|max:100',
            'charges.*.tax' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        $appointment = Appointment::findOrFail($validated['appointment_id']);
        try {
            $firstCharge = $validated['charges'][0];
            $chargeCategoryId = ChargeCategory::query()->latest()->first()->id;
            $checkup = Checkup::create([
                'appointment_id' => $validated['appointment_id'],
                'consultant_doctor_id' => $validated['consultant_doctor_id'],
                'charge_category_id' => $chargeCategoryId,
                'charge_id' => $firstCharge['charge_id'],
                'note' => $validated['note'],
                'symptoms_type' => json_encode($symptomsTypeArray, 1),
                'symptoms_title' => json_encode(explode(',', $request->input('symptoms_title_array', '')), 1),
                'symptoms_description' => $validated['symptoms_description'],
                'known_allergies' => $validated['allergies'],
                'previous_medical_issues' => $validated['previous_medical_issues'],
                'checkup_date' => $validated['checkup_date'],
                'case' => $validated['case'],
                'casualty' => $validated['casualty'],
                'old_patient' => $validated['old_patient'],
                'old_patient_id' => $validated['old_patient_id'] ?? null,
                'reference' => $validated['reference'] ?? null,
                'apply_tpa' => $validated['apply_tpa'] ?? false,
                'live_consultation' => $validated['live_consultation'],
                'patient_id' => $appointment->patient_id,
            ]);

            $checkup->checkup_number = 'CHK' . str_pad($checkup->id, 6, '0', STR_PAD_LEFT);
            $checkup->save();

            foreach ($validated['charges'] as $item) {
                $charge = \App\Models\Charge::find($item['charge_id']);
                $standard = $charge->standard_charge;
                $applied = $item['appliedCharge'];
                $discount = $item['discount'] ?? 0;
                $tax = $item['tax'] ?? 0;

                $discountAmount = $applied * ($discount / 100);
                $subTotal = $applied - $discountAmount;
                $taxAmount = $subTotal * ($tax / 100);
                $amount = $subTotal + $taxAmount;

                CheckupChargeItem::create([
                    'checkup_id' => $checkup->id,
                    'charge_id' => $item['charge_id'],
                    'standard_charge' => $standard,
                    'applied_charge' => $applied,
                    'discount' => $discount,
                    'tax' => $tax,
                    'amount' => $amount,
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Checkup created successfully.',
                'data' => $checkup
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create checkup.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function checkupDetails($id)
    {
        $checkup = Checkup::with(['appointment.patient', 'doctor'])->findOrFail($id);
        return response()->json([
            'checkup_number' => $checkup->checkup_number,
            'checkup_date' => $checkup->checkup_date->format('m/d/Y') . ' ' . ($checkup->checkup_time?->format('h:i A') ?? ''),
            'reference' => $checkup->reference,
            'symptoms' => $checkup->symptoms,
            'doctor_name' => $checkup->doctor?->name,
            'appointment' => [
                'opd_no' => $checkup->appointment->opd_no,
                'case_id' => $checkup->appointment->case_id,
                'patient' => [
                    'name' => $checkup->appointment->patient->name,
                    'gender_id' => $checkup->appointment->patient->gender_id,
                    'phone_number' => $checkup->appointment->patient->phone_number,
                    'email' => $checkup->appointment->patient->email,
                ],
            ],
        ]);
    }

    // public function show(Appointment $appointment)
    // {
    //     $patient = Patient::find($appointment->patient_id);
    //     $doctor = Doctor::find($appointment->consultant_doctor_id);
    //     $symptoms = SymptomType::find($appointment->symptoms_type_id);
    //     $symptomCategories = SymptomCategory::whereIn('id', json_decode($appointment->symptoms_title, true))->get();
    //     $chargeCategory = ChargeCategory::find($appointment->charge_category_id);
    //     $charge = Charge::find($appointment->charge_id);
    //     $appointments = Appointment::where('patient_id', $appointment->patient_id)->paginate(10);

    //     $svg = QrCode::format('svg')->size(50)->generate(route('patients.show', [$patient->id]));
    //     $base64 = base64_encode($svg);
    //     $barcode = new DNS1D();
    //     $barcode->setStorPath(public_path('barcodes'));
    //     $barcode_png = $barcode->getBarcodePNG($patient->id, 'C39', 1.5, 25);
    //     $barcodeDataUri = 'data:image/png;base64,' . $barcode_png;
    //     $qr_code ='data:image/svg+xml;base64,' . $base64;
    //     $barcode = $barcodeDataUri;
    //     $startDate = Carbon::now()->subMonths(11)->startOfMonth();
    //     $endDate = Carbon::now()->endOfMonth();

    //     $invoices = PatientInvoice::whereBetween('created_at', [$startDate, $endDate])->get();

    //     $labels = [];
    //     for ($i = 11; $i >= 0; $i--) {
    //         $labels[] = Carbon::now()->subMonths($i)->format('Y-m');
    //     }

    //     $groupedData = [];

    //     foreach ($invoices as $invoice) {
    //         $month = Carbon::parse($invoice->created_at)->format('Y-m');
    //         $category = $invoice->charge_category_id;

    //         if (!isset($groupedData[$category])) {
    //             $groupedData[$category] = [];
    //         }

    //         if (!isset($groupedData[$category][$month])) {
    //             $groupedData[$category][$month] = 0;
    //         }

    //         $groupedData[$category][$month]++;
    //     }

    //     $datasets = [];

    //     foreach ($groupedData as $categoryId => $monthsData) {
    //         $data = [];
    //         foreach ($labels as $month) {
    //             $data[] = $monthsData[$month] ?? 0;
    //         }

    //         $categoryName = optional(ChargeCategory::find($categoryId))->name ?? 'Category ' . $categoryId;

    //         $datasets[] = [
    //             'label' => $categoryName,
    //             'data' => $data,
    //             'fill' => false,
    //             'borderColor' => '#' . substr(md5($categoryId), 0, 6),
    //         ];
    //     }

    //     return view('opd.show', compact(
    //         'appointment',
    //         'patient',
    //         'doctor',
    //         'symptoms',
    //         'symptomCategories',
    //         'chargeCategory',
    //         'charge',
    //         'appointments',
    //         'labels',
    //         'datasets',
    //         'barcode',
    //         'qr_code'
    //     ));
    // }
}
