<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MedicalConsultation extends Model
{
    protected $fillable = [
        'patient_id',
        'appointment_id',
        'chief_complaint',
        'history_of_present_illness',
        'provisional_diagnosis',
        'final_diagnosis',
        'post_consultation_advice',
        'next_appointment',
        'follow_up_type',
    ];

    protected $casts = [
        'next_appointment' => 'date',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(MedicalConsultationServiceItem::class);
    }
}
