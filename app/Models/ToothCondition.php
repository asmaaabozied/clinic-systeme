<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToothCondition extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'tooth_number',
        'condition',
        'severity',
        'notes',
        'date',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
        'date' => 'date',
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
