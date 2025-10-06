<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SymptomType extends Model
{
    protected $fillable = [
        'name',
    ];
  

    public function symptomCategories()
    {
        return $this->hasMany(SymptomCategory::class);
    }

   
}

