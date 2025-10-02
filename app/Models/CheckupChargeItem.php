<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckupChargeItem extends Model
{
    protected $fillable = [
        'checkup_id',
        'charge_id',
        'standard_charge',
        'applied_charge',
        'discount',
        'tax',
        'amount',
    ];

    public function checkup()
    {
        return $this->belongsTo(Checkup::class);
    }

    public function charge()
    {
        return $this->belongsTo(Charge::class);
    }
}

