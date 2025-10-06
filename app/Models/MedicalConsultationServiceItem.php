<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalConsultationServiceItem extends Model
{
    protected $fillable = [
        'medical_consultation_id',
        'charge_id',
        'standard_charge',
        'applied_charge',
        'discount',
        'tax',
        'amount',
        'is_paid',
    ];

    public function consultation(): BelongsTo
    {
        return $this->belongsTo(MedicalConsultation::class, 'medical_consultation_id');
    }

    public function charge(): BelongsTo
    {
        return $this->belongsTo(Charge::class);
    }
}
