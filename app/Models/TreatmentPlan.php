<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentPlan extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'name',
        'condition',
        'start_date',
        'expected_end_date',
        'end_date',
        'progress',
        'priority',
        'outcome',
        'status',
        'description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'expected_end_date' => 'date',
        'end_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
