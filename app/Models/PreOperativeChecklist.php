<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreOperativeChecklist extends Model
{
    protected $fillable = [
        'patient_id',
        'item',
        'status',
        'date_completed',
        'completed_by',
        'notes',
    ];

    protected $casts = [
        'date_completed' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
