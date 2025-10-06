<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DermatologyConsultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'chief_complaint',
        'medical_history',
        'physical_exam',
        'procedures_discussed',
    ];

    public function assessments()
    {
        return $this->hasMany(DermatologyAssessment::class, 'consultation_id');
    }
    public function recommendations()
    {
        return $this->hasMany(DermatologyRecommendation::class, 'consultation_id');
    }
    public function imageAnalyses()
    {
        return $this->hasMany(DermatologyImageAnalysis::class, 'consultation_id');
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