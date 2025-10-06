<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientMedication extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'medicine_name',
        'dosage',
        'frequency',
        'start_date',
        'end_date',
        'status',
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function histories()
    {
        return $this->hasMany(MedicationHistory::class);
    }
}
