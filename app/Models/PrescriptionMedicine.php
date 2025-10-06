<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionMedicine extends Model
{
    protected $fillable = [
        'prescription_id', 
        'medicine_id',
        'dose_id',
        'dose_interval_id',
        'dose_duration_id',
        'instruction'
    ];
    
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function dose()
    {
        return $this->belongsTo(Dose::class);
    }

    public function dose_interval()
    {
        return $this->belongsTo(DoseInterval::class);
    }
    public function dose_duration()
    {
        return $this->belongsTo(DoseDuration::class);
    }
}
