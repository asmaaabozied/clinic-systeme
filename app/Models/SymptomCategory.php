<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SymptomCategory extends Model
{
    protected $fillable = [
        'title',
        'symptom_type_id',
        'description',
    ];

    public function symptom()
    {
        return $this->belongsTo(SymptomType::class, 'symptom_type_id');
    }
}
