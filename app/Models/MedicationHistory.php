<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicationHistory extends Model
{
    protected $fillable = [
        'patient_medication_id',
        'taken_at',
        'status',
    ];

    protected $dates = [
        'taken_at',
    ];

    public function medication()
    {
        return $this->belongsTo(PatientMedication::class, 'patient_medication_id');
    }
}
