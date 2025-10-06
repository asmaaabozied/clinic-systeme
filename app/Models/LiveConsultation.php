<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class LiveConsultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_id',
        'consultation_type',
        'status',
        'notes',
        'diagnosis',
        'prescription',
        'zoom_meeting_id',
        'zoom_start_url',
        'zoom_join_url',
        'zoom_password',
        'scheduled_at',
        'started_at',
        'ended_at',
        'duration_minutes',
        'recording_url',
        'recording_file_id',
        'recording_available_at',
        'symptoms',
        'vital_signs',
        'is_emergency',
        'created_by',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'recording_available_at' => 'datetime',
        'symptoms' => 'array',
        'vital_signs' => 'array',
        'is_emergency' => 'boolean',
    ];

    // Relationships
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function notes()
    {
        return $this->hasMany(ConsultationNote::class, 'live_consultation_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeForPatient($query, $patientId)
    {
        return $query->where('patient_id', $patientId);
    }

    public function scopeForDoctor($query, $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }

    // Helper methods
    public function getFormattedDuration(): string
    {
        if (!$this->started_at || !$this->ended_at) {
            return 'N/A';
        }

        $duration = $this->started_at->diffInMinutes($this->ended_at);
        if ($duration < 60) {
            return $duration . ' min';
        }

        $hours = floor($duration / 60);
        $minutes = $duration % 60;
        return $hours . 'h ' . $minutes . 'm';
    }

    public function getStatusText(): string
    {
        return match($this->status) {
            'scheduled' => 'Scheduled',
            'active' => 'Active',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            default => 'Unknown'
        };
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'scheduled' => 'status-scheduled',
            'active' => 'status-active',
            'completed' => 'status-completed',
            'cancelled' => 'status-cancelled',
            default => 'status-unknown'
        };
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isScheduled(): bool
    {
        return $this->status === 'scheduled';
    }

    public function canStart(): bool
    {
        return $this->status === 'scheduled' && $this->scheduled_at <= now();
    }

    public function canJoin(): bool
    {
        return $this->status === 'active' && $this->zoom_join_url;
    }

    public function getConsultationStats(): array
    {
        $consultations = static::where('patient_id', $this->patient_id)
            ->where('status', 'completed')
            ->get();

        $total = $consultations->count();
        $thisMonth = $consultations->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count();
        
        $averageDuration = $consultations->whereNotNull('started_at')
            ->whereNotNull('ended_at')
            ->avg(function($consultation) {
                return $consultation->started_at->diffInMinutes($consultation->ended_at);
            });

        $nextSession = static::where('patient_id', $this->patient_id)
            ->where('status', 'scheduled')
            ->where('scheduled_at', '>', now())
            ->orderBy('scheduled_at')
            ->first();

        return [
            'total' => $total,
            'this_month' => $thisMonth,
            'average_duration' => round($averageDuration ?? 0),
            'next_session' => $nextSession ? $nextSession->scheduled_at->format('d/m/Y h:i A') : null,
        ];
    }
} 