<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OralHealthAssessment extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'gum_health',
        'oral_hygiene',
        'issues',
        'risk_factors',
        'recommendations',
        'assessment_date',
    ];

    protected $casts = [
        'issues' => 'array',
        'risk_factors' => 'array',
        'recommendations' => 'array',
        'assessment_date' => 'date',
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
