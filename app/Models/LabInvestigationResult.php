<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabInvestigationResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'lab_investigation_id',
        'parameter',
        'result',
        'normal_range',
        'unit',
        'status',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function investigation(): BelongsTo
    {
        return $this->belongsTo(LabInvestigation::class, 'lab_investigation_id');
    }
}
