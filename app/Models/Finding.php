<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finding extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(FindingCategory::class, 'finding_category_id');
    }
    
}
