<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TpaPatient extends Model
{
    protected $fillable = [
        'tpa_id',
        'patient_id',
        'number',
        'validity_date',
    ];

    public function tpa()
    {
        return $this->belongsTo(Tpa::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
