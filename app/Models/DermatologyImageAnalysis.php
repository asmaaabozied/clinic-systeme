<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DermatologyImageAnalysis extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'consultation_id',
        'image_type',
        'analysis_results',
        'confidence_score',
        'notes',
        'before_image',
        'after_image',
    ];

    protected $casts = [
        'confidence_score' => 'float',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function consultation()
    {
        return $this->belongsTo(DermatologyConsultation::class, 'consultation_id');
    }
} 