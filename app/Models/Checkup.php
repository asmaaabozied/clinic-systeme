<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Patient;
use App\Models\CheckupChargeItem;

class Checkup extends Model
{
    use HasFactory;

    protected $fillable = [
        'checkup_number',
        'appointment_id',
        'patient_id',
        'consultant_doctor_id',
        'charge_category_id',
        'charge_id',
        'note',
        'symptoms_type',
        'symptoms_title',
        'symptoms_description',
        'known_allergies',
        'previous_medical_issues',
        'checkup_date',
        'case',
        'casualty',
        'old_patient',
        'old_patient_id',
        'reference',
        'apply_tpa',
        'live_consultation',
        'symptoms',
    ];

    protected $casts = [
        'checkup_date' => 'date',
        'checkup_time' => 'datetime',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'consultant_doctor_id');
    }

    public function chargeItems()
    {
        return $this->hasMany(CheckupChargeItem::class);
    }
}
