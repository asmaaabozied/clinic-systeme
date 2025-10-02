<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    protected $fillable = [
        'patient_id',
        'reference_no',
        'operation_name',
        'operation_date',
        'status',
        'details',
    ];

    protected $casts = [
        'operation_date' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
