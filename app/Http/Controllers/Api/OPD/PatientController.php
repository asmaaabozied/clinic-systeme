<?php

namespace App\Http\Controllers\Api\OPD;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PatientController extends Controller
{
    /**
     * Get patients for DataTable
     */
    public function datatable(Request $request)
    {
        $patients = Patient::query();
        return DataTables::of($patients)
            ->addColumn('code', function ($patient) {
                return $patient->patient_code ?? 'N/A';
            })
            ->addColumn('name', function ($patient) {
                return $patient->name ?? 'N/A';
            })
            ->addColumn('guardian_name', function ($patient) {
                return $patient->guardian_name ?? 'N/A';
            })
            ->addColumn('gender', function ($patient) {
                return $patient->gender ?? 'N/A';
            })
            ->addColumn('phone', function ($patient) {
                return $patient->phone ?? 'N/A';
            })
            ->addColumn('last_visit', function ($patient) {
                return $patient->created_at ? $patient->created_at->format('d/m/Y') : 'N/A';
            })
            ->addColumn('action', function ($patient) {
                return view('api.opd.patients.actions', compact('patient'))->render();
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getNextCode()
    {
        $nextCode = 'P-' . str_pad(Patient::count() + 1, 6, '0', STR_PAD_LEFT);

        return response()->json([
            'success' => true,
            'next_code' => $nextCode
        ]);
    }

    /**
     * Store a new patient (API)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'second_name' => 'nullable|string|max:255',
            'third_name' => 'nullable|string|max:255',
            'family_name' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'dob_hijri' => 'required|string',
            'date_of_birth' => 'required|date',
            'nationality' => 'required|string|max:255',
            'document_type' => 'required|string',
            'document_id' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'marital_status' => 'nullable|string',
            'gender' => 'required|string',
            'blood_group' => 'nullable|string',
            'preferred_language' => 'nullable|string',
            'remarks' => 'nullable|string',
            'addresses' => 'required|array|min:1',
            'addresses.*.street' => 'required|string|max:255',
            'addresses.*.city' => 'required|string|max:255',
            'addresses.*.postal_code' => 'nullable|string|max:255',
        ]);

        \DB::beginTransaction();
        try {
            $nextCode = 'P-' . str_pad(Patient::count() + 1, 6, '0', STR_PAD_LEFT);

            $patient = new \App\Models\Patient();
            $patient->name = $validated['name'] ?? trim(
                $validated['first_name'] . ' ' .
                ($validated['second_name'] ?? '') . ' ' .
                ($validated['third_name'] ?? '') . ' ' .
                ($validated['family_name'] ?? '')
            );
            $patient->email = $validated['email'];
            $patient->date_of_birth = $validated['date_of_birth'];
            $patient->phone = $validated['phone'];
            $patient->guardian_name = $validated['family_name'] ?? null;
            $patient->gender = $validated['gender'];
            $patient->document_id = $validated['document_id'];
            $patient->blood_group = $validated['blood_group'] ?? null;
            $patient->marital_status = $validated['marital_status'] ?? null;
            $patient->remarks = $validated['remarks'] ?? null;
            $patient->patient_code = $nextCode;

            $patient->save();
            // Save addresses
            foreach ($validated['addresses'] as $address) {
                $patient->addresses()->create($address);
            }

            \DB::commit();
            return response()->json(['success' => true, 'patient' => $patient], 201);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
