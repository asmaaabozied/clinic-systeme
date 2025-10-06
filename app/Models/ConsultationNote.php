<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'live_consultation_id',
        'notes',
        'diagnosis',
        'prescription',
        'created_by',
    ];

    public function consultation()
    {
        return $this->belongsTo(LiveConsultation::class, 'live_consultation_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
} 