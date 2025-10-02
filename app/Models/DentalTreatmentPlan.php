<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DentalTreatmentPlan extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'title',
        'stage',
        'procedures',
        'estimated_cost',
        'start_date',
        'estimated_completion',
    ];

    protected $casts = [
        'procedures' => 'array',
        'estimated_cost' => 'decimal:2',
        'start_date' => 'date',
        'estimated_completion' => 'date',
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
