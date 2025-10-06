<?php
namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Charge;
use App\Models\MedicalConsultation;
use App\Models\MedicalConsultationServiceItem;
use App\Models\PatientInvoice;
use App\Models\PatientInvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicalConsultationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'required|exists:appointments,id',
            'chief_complaint' => 'nullable|string',
            'history_of_present_illness' => 'nullable|string',
            'provisional_diagnosis' => 'nullable|string',
            'final_diagnosis' => 'nullable|string',
            'post_consultation_advice' => 'nullable|string',
            'next_appointment' => 'nullable|date',
            'follow_up_type' => 'nullable|string',
            'services' => 'array',
            'services.*.charge_id' => 'required|exists:charges,id',
            'services.*.applied_charge' => 'required|numeric',
            'services.*.discount' => 'nullable|numeric',
            'services.*.tax' => 'nullable|numeric',
        ]);

        DB::beginTransaction();
        try {
            $consultation = MedicalConsultation::create($validated);

            $totalStandard = $totalApplied = $totalDiscount = $totalTax = $totalAmount = 0;

            foreach ($validated['services'] ?? [] as $item) {
                $charge = Charge::find($item['charge_id']);
                $standard = $charge->standard_charge;
                $applied = $item['applied_charge'];
                $discount = $item['discount'] ?? 0;
                $tax = $item['tax'] ?? 0;
                $discountAmount = $applied * ($discount / 100);
                $subTotal = $applied - $discountAmount;
                $taxAmount = $subTotal * ($tax / 100);
                $amount = $subTotal + $taxAmount;

                MedicalConsultationServiceItem::create([
                    'medical_consultation_id' => $consultation->id,
                    'charge_id' => $item['charge_id'],
                    'standard_charge' => $standard,
                    'applied_charge' => $applied,
                    'discount' => $discount,
                    'tax' => $tax,
                    'amount' => $amount,
                    'is_paid' => false,
                ]);

                $totalStandard += $standard;
                $totalApplied += $applied;
                $totalDiscount += $discountAmount;
                $totalTax += $taxAmount;
                $totalAmount += $amount;
            }

            $invoice = PatientInvoice::create([
                'appointment_id' => $validated['appointment_id'],
                'patient_id' => $validated['patient_id'],
                'charge_category_id' => 0,
                'charge_id' => $validated['services'][0]['charge_id'] ?? 0,
                'standardCharge' => $totalStandard,
                'appliedCharge' => $totalApplied,
                'discount' => $totalDiscount,
                'tax' => $totalTax,
                'amount' => $totalAmount,
                'payment_method' => 'Cash',
                'paidAmount' => 0,
                'live_consultation' => false,
                'is_paid' => false,
            ]);
            $invoice->invoice_no = 'INV-' . str_pad($invoice->id, 5, '0', STR_PAD_LEFT);
            $invoice->save();

            foreach ($consultation->services as $service) {
                PatientInvoiceItem::create([
                    'patient_invoice_id' => $invoice->id,
                    'charge_id' => $service->charge_id,
                    'standard_charge' => $service->standard_charge,
                    'applied_charge' => $service->applied_charge,
                    'discount' => $service->discount,
                    'tax' => $service->tax,
                    'amount' => $service->amount,
                ]);
            }

            DB::commit();
            return response()->json([
                'message' => 'Consultation saved',
                'invoice_id' => $invoice->id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $consultation = MedicalConsultation::with(['services.charge','appointment.doctor.user','appointment.patient'])
            ->findOrFail($id);
        return response()->json($consultation);
    }

    public function update(Request $request, $id)
    {
        $consultation = MedicalConsultation::findOrFail($id);
        if ($consultation->created_at->diffInHours(now()) > 24) {
            return response()->json(['message' => 'Editing period expired'], 403);
        }
        $validated = $request->validate([
            'chief_complaint' => 'nullable|string',
            'history_of_present_illness' => 'nullable|string',
            'provisional_diagnosis' => 'nullable|string',
            'final_diagnosis' => 'nullable|string',
            'post_consultation_advice' => 'nullable|string',
            'next_appointment' => 'nullable|date',
            'follow_up_type' => 'nullable|string',
        ]);
        $consultation->update($validated);
        return response()->json(['message' => 'Consultation updated']);
    }
}
