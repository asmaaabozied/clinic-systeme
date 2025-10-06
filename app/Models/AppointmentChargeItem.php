<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentChargeItem extends Model
{
    protected $fillable = [
        'appointment_id',
        'charge_id',
        'standard_charge',
        'applied_charge',
        'discount',
        'tax',
        'amount',
        'is_paid',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function charge()
    {
        return $this->belongsTo(Charge::class);
    }
}
