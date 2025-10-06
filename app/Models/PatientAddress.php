<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientAddress extends Model
{
    use HasFactory;
    protected $fillable = ['patient_id', 'street', 'city', 'postal_code'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
