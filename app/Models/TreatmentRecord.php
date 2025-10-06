<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentRecord extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'date',
        'procedure',
        'tooth_numbers',
        'notes',
        'cost',
        'status',
    ];

    protected $casts = [
        'tooth_numbers' => 'array',
        'cost' => 'decimal:2',
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
