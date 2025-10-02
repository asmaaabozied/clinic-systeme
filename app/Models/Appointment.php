<?php

namespace App\Models;

use App\Models\Charge;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\PatientInvoice;
use App\Models\AppointmentChargeItem;
use App\Models\MedicalConsultation;
use App\Models\MedicalConsultationServiceItem;
use App\Models\Checkup;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'opd_no',
        'consultant_doctor_id',
        'charge_category_id',
        'charge_id',
        'note',
        'symptoms_type',
        'symptoms_title',
        'symptoms_description',
        'known_allergies',
        'previous_medical_issues',
        'appointment_date',
        'case',
        'casualty',
        'old_patient',
        'old_patient_id',
        'reference',
        'apply_tpa',
        'live_consultation',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
    ];


    public function patient()
    {
        return $this->belongsTo(Patient::class , 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'consultant_doctor_id');
    }

    public function patientInvoice()
    {
        return $this->hasOne(PatientInvoice::class);
    }

    public function invoices()
    {
        return $this->hasMany(PatientInvoice::class);
    }

    public function charge()
    {
        return $this->belongsTo(Charge::class);
    }

    public function chargeItems()
    {
        return $this->hasMany(AppointmentChargeItem::class);
    }

    public function checkups()
    {
        return $this->hasMany(Checkup::class);
    }

    public function consultation(): HasOne
    {
        return $this->hasOne(MedicalConsultation::class);
    }

    public function consultationServiceItems()
    {
        return $this->hasManyThrough(
            MedicalConsultationServiceItem::class,
            MedicalConsultation::class,
            'appointment_id',
            'medical_consultation_id'
        );
    }
}
