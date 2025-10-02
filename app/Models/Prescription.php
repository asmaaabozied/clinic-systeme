<?php

// app/Models/Prescription.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'header_note',
        'finding_description',
        'finding_print',
        'footer_note',
        'attachment_path',
        'pathology_id',
        'radiology_id',
        'is_printed'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function medicines()
    {
        return $this->hasMany(PrescriptionMedicine::class);
    }

    public function pathology()
    {
        return $this->belongsTo(Pathology::class);
    }

    public function radiology()
    {
        return $this->belongsTo(Radiology::class);
    }
}