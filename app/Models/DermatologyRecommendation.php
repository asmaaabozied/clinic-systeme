<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DermatologyRecommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultation_id',
        'patient_id',
        'doctor_id',
        'treatment_recommendations',
        'alternative_options',
        'estimated_cost',
        'recovery_time',
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