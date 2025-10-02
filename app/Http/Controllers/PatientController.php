<?php

namespace App\Http\Controllers;

use App\Models\Tpa;
use App\Models\Patient;
use App\Models\TpaUser;
use Milon\Barcode\DNS1D;
use App\Models\TpaPatient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients =  Patient::all();
        return view('patient.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patient.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['sometimes', 'email:rfc,dns', 'unique:patients,email'],
            'phone' => ['required', 'digits_between:10,15', 'unique:patients,phone'],
            'alternate_phone' => ['nullable', 'digits_between:10,15', 'unique:patients,phone'],
            'document_id' => ['nullable', 'string'],
            'guardian_name' => ['sometimes', 'nullable', 'string'],
            'gender' => ['required', 'string', 'in:male,female'],
            'date_of_birth' => ['required', 'date'],
            'blood_group' => ['sometimes', 'string', 'in:A+,A-,B+,B-,O+,O-,AB+,AB-'],
            'marital_status' => ['sometimes', 'string', 'in:single,married,divorced,widowed'],
            'address' => ['sometimes', 'nullable', 'string'],
            'remarks' => ['sometimes', 'nullable', 'string'],

            'photo' => ['sometimes', 'nullable', 'file', 'image', 'max:2048'],
            'allergies' => ['sometimes', 'string', 'nullable', 'max:255'],
            'tpa' => ['sometimes', 'nullable', 'exists:tpas,id'],

            'tpaId' => [
                Rule::requiredIf(fn() =>  $request->filled('tpa') && $request->tpa !== 'Select'),
                'nullable',
                'string'
            ],
            'tpaValidity' => [
                Rule::requiredIf(fn() =>  $request->filled('tpa') && $request->tpa !== 'Select'),
                'nullable',
                'date'
            ],

        ]);
        DB::beginTransaction();

        try {

            $patient =   Patient::create($validated);
            $patient->patient_code = 8000 + $patient->id;
            $patient->save();

            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('patients', 'public');
                $patient->update(['photo' => $photoPath]);
            }
            if ($request->filled('tpa')) {
                TpaPatient::create([
                    'patient_id' => $patient->id,
                    'tpa_id' => $request->input('tpa'),
                    'number' => $request->input('tpaId'),
                    'validity_date' => $request->input('tpaValidity'),
                ]);
            }



            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
        $qrImage = QrCode::format('svg')->size(40)->generate(route('patients.show', [$patient->id]));
        Session::put('patient', $patient);
        return response()->json([
            'status'  => 'success',
            'message' => 'Patient created successfully.',
            'qrImage' => 'qrImage',
            'new_patient_id' => $patient->id,
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient = Patient::findOrFail($id);
        return view('patient.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $patient = Patient::findOrFail($id);
        return view('patient.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'gender' => 'nullable',
            'birth_date' => 'nullable|date',
            'address' => 'nullable',
            'blood_type' => 'nullable',
            'note' => 'nullable',
        ]);
        $patient = Patient::findOrFail($id);
        $patient->update($validated);
        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }

    /**
     * AJAX live search for patients (returns JSON)
     */
    public function livesearch(Request $request)
    {
        $query = $request->input('q');
        $patients = Patient::query()
            ->when($query, function ($q) use ($query) {
                $q->where('first_name', 'like', "%$query%")
                    ->orWhere('last_name', 'like', "%$query%")
                    ->orWhere('email', 'like', "%$query%")
                    ->orWhere('phone', 'like', "%$query%");
            })
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
        return response()->json(['patients' => $patients]);
    }

    public function getPatients()
    {
        $patients = Patient::all();
        return response()->json($patients);
    }

    public function patientDetails(Patient $patient)
    {
        $patient->load('tpaPatient.tpa');

        $svg = QrCode::format('svg')->size(50)->generate(route('patients.show.for.qr.code', $patient->id));
        $base64 = base64_encode($svg);

        $barcode = new DNS1D();
        $barcode->setStorPath(public_path('barcodes'));
        $barcode_png = $barcode->getBarcodePNG($patient->id, 'C39', 1.5, 25);
        $barcodeDataUri = 'data:image/png;base64,' . $barcode_png;

        $patientData = $patient->toArray();
        $patientData['tpa'] = optional($patient->tpaPatient?->tpa)->name;
        $patientData['tpa_id'] = $patient->tpaPatient->number ?? null;
        $patientData['tpa_validity'] = $patient->tpaPatient->validity_date ?? null;

        return response()->json([
            'patient' => $patientData,
            'qr_code' => 'data:image/svg+xml;base64,' . $base64,
            'barcode' => $barcodeDataUri,
        ]);
    }
}
