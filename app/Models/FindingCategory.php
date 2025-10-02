<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FindingCategory extends Model
{
    protected $guarded = [];
    
    public function findings()
     {
        return $this->hasMany(Finding::class);
     }
}
