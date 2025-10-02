<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    use HasFactory;

    protected $fillable = [
        'charge_type_id',
        'charge_category_id',
        'unit_type_id',
        'charge_name',
        'tax_id',
        'tax_percentage',
        'standard_charge',
        'description',
    ];

    public function chargeType()
    {
        return $this->belongsTo(ChargeType::class);
    }
    public function chargeCategory()
    {
        return $this->belongsTo(ChargeCategory::class);
    }
    public function unitType()
    {
        return $this->belongsTo(UnitType::class);
    }
    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }
}
