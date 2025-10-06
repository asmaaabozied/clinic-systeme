<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LabInvestigation extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'test_name',
        'test_date',
        'lab',
        'sample_collected_at',
        'expected_date',
        'status',
        'result',
        'abnormal',
    ];

    protected $casts = [
        'test_date' => 'date',
        'sample_collected_at' => 'datetime',
        'expected_date' => 'date',
        'abnormal' => 'boolean',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(LabInvestigationResult::class);
    }
}
