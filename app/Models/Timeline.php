<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    protected $fillable = [
        'title',
        'date',
        'description',
        'document',
        'patient_id',
        'visible_to_patient',
    ];
}
