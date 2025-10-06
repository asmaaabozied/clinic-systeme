<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\ChargeCategory;
use App\Models\Utility;
use Illuminate\Http\Request;
use App\Models\PatientInvoice;
use App\Models\AppointmentChargeItem;
use App\Models\MedicalConsultationServiceItem;
use App\Models\PatientInvoiceItem;
use App\Models\Charge;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $symptomsArray = array_filter(
            explode(',', $request->symptoms_title_array),
            fn($val) => strtolower(trim($val)) !== 'select' && trim($val) !== ''
        );

        $symptomsArray = array_values($symptomsArray);

//        if (empty($symptomsArray)) {
//            return response()->json([
//                'errors' => ['symptoms_title_array' => ['You must select at least one valid symptom.']]
//            ], 422);
//        }

        if (!collect($symptomsArray)->every(fn($id) => is_numeric($id))) {
            return response()->json([
                'errors' => ['symptoms_title_array' => ['Invalid symptoms selected.']]
            ], 422);
        }

        $symptomsTypeArray = array_filter(
            explode(',', $request->symptoms_type_array),
            fn($val) => strtolower(trim($val)) !== 'select' && trim($val) !== ''
        );

        $symptomsTypeArray = array_values($symptomsTypeArray);

//        if (empty($symptomsTypeArray)) {
//            return response()->json([
//                'errors' => ['symptoms_type_array' => ['You must select at least one valid symptom type.']]
//            ], 422);
//        }

        if (!collect($symptomsTypeArray)->every(fn($id) => is_numeric($id))) {
            return response()->json([
                'errors' => ['symptoms_type_array' => ['Invalid symptom types selected.']]
            ], 422);
        }
        $validated = $request->validate([
            'symptoms_description' => 'nullable|string',
            'allergies' => 'nullable|string',
            'note' => 'nullable|string',
            'previous_medical_issues' => 'nullable|string',
            'consultant_doctor_id' => 'required|exists:doctors,id',
//            'charge_category_id' => 'required|exists:charge_categories,id',
            'patient_id' => 'required|exists:patients,id|not_in:Select',
            'payment_method' => 'required|in:Cash,Card,BankTransfer',
            'appointment_date' => 'required|date',
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

        try {

            $firstCharge = $validated['charges'][0];
            $chargeCategoryId = ChargeCategory::query()->latest()->first()->id;
            $appointment = Appointment::create([
                'patient_id' => $validated['patient_id'],
                'consultant_doctor_id' => $validated['consultant_doctor_id'],
                'charge_category_id' => $chargeCategoryId,
                'charge_id' => $firstCharge['charge_id'],
                'note' => $validated['note'],
                'symptoms_type' => json_encode($symptomsTypeArray, 1),
                'symptoms_title' => json_encode($symptomsArray, 1),
                'symptoms_description' => $validated['symptoms_description'],
                'known_allergies' => $validated['allergies'],
                'previous_medical_issues' => $validated['previous_medical_issues'],
                'appointment_date' => $validated['appointment_date'],
                'case' => $validated['case'],
                'casualty' => $validated['casualty'],
                'old_patient' => $validated['old_patient'],
                'old_patient_id' => $validated['old_patient_id'] ?? null,
                'reference' => $validated['reference'] ?? null,
                'apply_tpa' => $validated['apply_tpa'] ?? false,
                'live_consultation' => $validated['live_consultation'],
            ]);

            $appointment->opd_no = 'OPD' . str_pad($appointment->id, 6, '0', STR_PAD_LEFT);
            $appointment->save();

            $totalStandard = 0;
            $totalApplied = 0;
            $totalDiscount = 0;
            $totalTax = 0;
            $totalAmount = 0;

            foreach ($validated['charges'] as $item) {
                $charge = \App\Models\Charge::find($item['charge_id']);
                $standard = $charge->standard_charge;
                $applied = $item['appliedCharge'];
                $discount = $item['discount'] ?? 0;
                $taxAmount = $item['tax'] ?? 0;

                $discountAmount = $applied * ($discount / 100);
                $subTotal = $applied - $discountAmount;
//                $taxAmount = $subTotal * ($tax / 100);
                $amount = $subTotal + $taxAmount;

                \App\Models\AppointmentChargeItem::create([
                    'appointment_id' => $appointment->id,
                    'charge_id' => $item['charge_id'],
                    'standard_charge' => $standard,
                    'applied_charge' => $applied,
                    'discount' => $discount,
                    'tax' => $taxAmount,
                    'amount' => $amount,
                    'is_paid' => true,
                ]);

                $totalStandard += $standard;
                $totalApplied += $applied;
                $totalDiscount += $discountAmount;
                $totalTax += $taxAmount;
                $totalAmount += $amount;
            }

            $invoice = PatientInvoice::create([
                'appointment_id' => $appointment->id,
                'patient_id' => $validated['patient_id'],
                'charge_category_id' => $chargeCategoryId,
                'charge_id' => $firstCharge['charge_id'],
                'standardCharge' => $totalStandard,
                'appliedCharge' => $totalApplied,
                'discount' => $totalDiscount,
                'tax' => $totalTax,
                'amount' => $totalAmount,
                'payment_method' => $validated['payment_method'],
                'paidAmount' => $totalAmount,
                'live_consultation' => $validated['live_consultation'],
                'is_paid' => true,
            ]);
            $invoice->invoice_no = 'INV-' . str_pad($invoice->id, 5, '0', STR_PAD_LEFT);
            $invoice->save();

            foreach ($appointment->chargeItems as $item) {
                \App\Models\PatientInvoiceItem::create([
                    'patient_invoice_id' => $invoice->id,
                    'charge_id' => $item->charge_id,
                    'standard_charge' => $item->standard_charge,
                    'applied_charge' => $item->applied_charge,
                    'discount' => $item->discount,
                    'tax' => $item->tax,
                    'amount' => $item->amount,
                ]);
            }

            DB::commit();

            session()->forget('patient_id');

            return response()->json([
                'message' => 'Appointment created successfully.',
                'data' => $appointment,
                'invoice_id' => $invoice->id,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create appointment.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getInvoiceJson($id)
    {
        $appointment = Appointment::with(['patient', 'chargeItems.charge', 'patientInvoice'])->findOrFail($id);

        $invoice = $appointment->patientInvoice;
        $patient = $appointment->patient;

        if (!$invoice) {
            return response()->json([
                'status' => false,
                'message' => 'Invoice not found',
            ], 404);
        }

        $charges = $appointment->chargeItems->map(function ($item) {
            $discountAmount = $item->applied_charge * ($item->discount / 100);
            $taxAmount = ($item->applied_charge - $discountAmount) * ($item->tax / 100);
            return [
                'description' => $item->charge->charge_name,
                'tax_percent' => $item->tax,
                'tax' => number_format($taxAmount, 2),
                'amount' => number_format($item->applied_charge, 2),
                'discount_percent' => $item->discount,
                'discount' => number_format($discountAmount, 2),
                'total' => number_format($item->amount, 2),
            ];
        });

        return response()->json([
            'status' => true,
            'data' => [
                'charges' => $charges,
                'paidAmount' => number_format($invoice->paidAmount, 2),
                'total' => number_format($invoice->paidAmount, 2),
                'opd' => 'OPDN' . $invoice->id,
                'opdDate' =>  $appointment->appointment_date,
                'patient' => [
                    'name' => $patient->name ?? '',
                    'guardian' => $patient->guardian_name ?? '',
                    'gender' => $patient->gender ?? '',
                    'dob' => $patient->date_of_birth ?? '',
                    'age' => $patient->date_of_birth
                        ? Carbon::parse($patient->date_of_birth)->diff(Carbon::now())->format('%y years, %m months, %d days')
                        : '',
                    'blood_group' => $patient->blood_group ?? '',
                    'marital_status' => $patient->marital_status ?? '',
                    'phone' => $patient->phone ?? '',
                    'email' => $patient->email ?? '',
                    'address' => $patient->address ?? '',
                    'remarks' => $patient->remarks ?? '',
                    'allergies' => $patient->allergies ?? '',
                    'tpa' => $patient->tpa_name ?? '',
                    'tpa_id' => $patient->tpa_id ?? '',
                    'tpa_validity' => $patient->tpa_validity ?? '',
                    'document_id' => $patient->document_id ?? '',
                    'alt_phone' => $patient->alt_phone ?? '',
                ],
            ]
        ]);
    }

    public function printInvoice(PatientInvoice $invoice)
    {
        $invoice->load(['appointment.patient', 'items.charge.tax']);
        $items = [];
        foreach ($invoice->items as $item) {
            $items[] = [
                'itemCode' => $item->charge->id ?? '',
                'description' => $item->charge->charge_name ?? '',
                'quantity' => 1,
                'gross' => $item->applied_charge,
                'discount' => $item->discount,
                'net' => $item->applied_charge - ($item->applied_charge * ($item->discount / 100)),
                'vat' => $item->tax,
                'amount' => $item->amount,
            ];
        }
        $grossTotal = collect($items)->sum('gross');
        $discountTotal = collect($items)->sum('discount');
        $vatTotal = collect($items)->sum('vat');
        $netAmount = collect($items)->sum('amount');
        $settings = Utility::settings();
        $company_logo = $settings['company_logo_dark'] ?? $settings['company_logo_light'] ?? '';
        $currency = $settings['site_currency'] ?? 'SAR';

        $data = [
            'company' => [
                'currency' => $currency,
                'logo'  => display_file($company_logo),
                'name' => Arr::get($settings, 'company_name'),
                'address' => Arr::get($settings, 'company_address', ''),
                'vatNumber' => Arr::get($settings, 'vat_number', ''),
                'phone' => Arr::get($settings, 'company_telephone', ''),
            ],
            'invoiceDetails' => [
                'type' => 'Invoice',
                'invoiceNo' => $invoice->invoice_no,
                'issueDate' => $invoice->created_at?->format('d-m-Y'),
                'time' => $invoice->created_at?->format('h:i A'),
                'fileNo' => $invoice->appointment->opd_no,
                'patientName' => $invoice->appointment->patient->name,
                'nationality' => $invoice->appointment->patient->nationality ?? '',
                'gender' => $invoice->appointment->patient->gender,
                'date_of_birth' => $invoice->appointment->patient->date_of_birth,
                'roomNo' => '',
                'tokenNo' => '',
            ],
            'items' => $items,
            'totals' => [
                'grossTotal' => $grossTotal,
                'discount' => $discountTotal,
                'totalAfterDiscount' => $grossTotal - $discountTotal,
                'vatTotal' => $vatTotal,
                'netAmount' => $netAmount,
            ],
            'payment' => [
                'cash' => $netAmount,
                'creditCard' => 0,
                'span' => 0,
                'unpaid' => 0,
            ],
        ];

        return view('opd.v2.invoice', ['invoice' => $data]);
    }

    public function printChargeItemInvoice(AppointmentChargeItem $item)
    {
        $appointment = $item->appointment()->with(['patient', 'patientInvoice'])->firstOrFail();

        $entry = [
            'itemCode' => $item->charge->id ?? '',
            'description' => $item->charge->charge_name ?? '',
            'quantity' => 1,
            'gross' => $item->applied_charge,
            'discount' => $item->discount,
            'net' => $item->applied_charge - ($item->applied_charge * ($item->discount / 100)),
            'vat' => $item->tax,
            'amount' => $item->amount,
        ];
        $settings = Utility::settings();
        $company_logo = $settings['company_logo_dark'] ?? $settings['company_logo_light'] ?? '';
        $currency = $settings['site_currency'] ?? 'SAR';
        $invoice = [
            'company' => [
                'currency' => $currency,
                'logo'  => display_file($company_logo),
                'name' => Arr::get($settings, 'company_name'),
                'address' => Arr::get($settings, 'company_address', ''),
                'vatNumber' => Arr::get($settings, 'vat_number', ''),
                'phone' => Arr::get($settings, 'company_telephone', ''),
            ],
            'invoiceDetails' => [
                'type' => 'Invoice',
                'invoiceNo' => optional($appointment->patientInvoice)->invoice_no,
                'issueDate' => optional($appointment->patientInvoice)->created_at?->format('d-m-Y'),
                'time' => optional($appointment->patientInvoice)->created_at?->format('h:i A'),
                'fileNo' => $appointment->opd_no,
                'patientName' => $appointment->patient->name,
                'nationality' => $appointment->patient->nationality ?? '',
                'gender' => $appointment->patient->gender,
                'date_of_birth' => $appointment->patient->date_of_birth,
                'roomNo' => '',
                'tokenNo' => '',
            ],
            'items' => [$entry],
            'totals' => [
                'grossTotal' => $entry['gross'],
                'discount' => $entry['discount'],
                'totalAfterDiscount' => $entry['gross'] - $entry['discount'],
                'vatTotal' => $entry['vat'],
                'netAmount' => $entry['amount'],
            ],
            'payment' => [
                'cash' => $entry['amount'],
                'creditCard' => 0,
                'span' => 0,
                'unpaid' => 0,
            ],
        ];

        return view('opd.v2.invoice', compact('invoice'));
    }

    public function printServiceItemInvoice(MedicalConsultationServiceItem $item)
    {
        $consultation = $item->consultation()->with(['appointment.patient', 'appointment.patientInvoice'])->firstOrFail();
        $appointment = $consultation->appointment;

        $entry = [
            'itemCode' => $item->charge->id ?? '',
            'description' => $item->charge->charge_name ?? '',
            'quantity' => 1,
            'gross' => $item->applied_charge,
            'discount' => $item->discount,
            'net' => $item->applied_charge - ($item->applied_charge * ($item->discount / 100)),
            'vat' => $item->tax,
            'amount' => $item->amount,
        ];
        $settings = Utility::settings();
        $company_logo = $settings['company_logo_dark'] ?? $settings['company_logo_light'] ?? '';
        $currency = $settings['site_currency'] ?? 'SAR';

        $invoice = [
            'company' => [
                'currency' => $currency,
                'logo'  => display_file($company_logo),
                'name' => Arr::get($settings, 'company_name'),
                'address' => Arr::get($settings, 'company_address', ''),
                'vatNumber' => Arr::get($settings, 'vat_number', ''),
                'phone' => Arr::get($settings, 'company_telephone', ''),
            ],
            'invoiceDetails' => [
                'type' => 'Invoice',
                'invoiceNo' => optional($appointment->patientInvoice)->invoice_no,
                'issueDate' => optional($appointment->patientInvoice)->created_at?->format('d-m-Y'),
                'time' => optional($appointment->patientInvoice)->created_at?->format('h:i A'),
                'fileNo' => $appointment->opd_no,
                'patientName' => $appointment->patient->name,
                'nationality' => $appointment->patient->nationality ?? '',
                'gender' => $appointment->patient->gender,
                'date_of_birth' => $appointment->patient->date_of_birth,
                'roomNo' => '',
                'tokenNo' => '',
            ],
            'items' => [$entry],
            'totals' => [
                'grossTotal' => $entry['gross'],
                'discount' => $entry['discount'],
                'totalAfterDiscount' => $entry['gross'] - $entry['discount'],
                'vatTotal' => $entry['vat'],
                'netAmount' => $entry['amount'],
            ],
            'payment' => [
                'cash' => $entry['amount'],
                'creditCard' => 0,
                'span' => 0,
                'unpaid' => 0,
            ],
        ];

        return view('opd.v2.invoice', compact('invoice'));
    }

    public function markAsPaid(PatientInvoice $invoice)
    {
        $invoice->is_paid = true;
        $invoice->save();

        return redirect()->back()->with('success', 'Invoice marked as paid');
    }

    public function markChargeItemAsPaid(AppointmentChargeItem $item)
    {
        $item->is_paid = true;
        $item->save();

        return redirect()->back()->with('success', 'Item marked as paid');
    }

    public function markServiceItemAsPaid(MedicalConsultationServiceItem $item)
    {
        $item->is_paid = true;
        $item->save();

        return redirect()->back()->with('success', 'Item marked as paid');
    }
}
