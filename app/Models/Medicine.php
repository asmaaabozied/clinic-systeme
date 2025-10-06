<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = ['medicine_category_id', 'name', 'description'];
    
    public function category()
    {
        return $this->belongsTo(MedicineCategory::class);
    }
}
