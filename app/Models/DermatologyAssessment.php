<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DermatologyAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultation_id',
        'patient_id',
        'doctor_id',
        'facial_symmetry',
        'skin_quality',
        'measurements',
    ];

    public function consultation()
    {
        return $this->belongsTo(DermatologyConsultation::class, 'consultation_id');
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
} 