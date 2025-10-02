<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PreOperativeChecklist;
use Carbon\Carbon;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'patient_code',
        'email',
        'phone',
        'alternate_phone',
        'document_id',
        'guardian_name',
        'gender',
        'date_of_birth',
        'blood_group',
        'marital_status',
        'address',
        'remarks',
        'photo',
        'allergies',

    ];

    protected $appends = ['age_display'];


    public function tpa()
    {
        return $this->belongsTo(Tpa::class);
    }

    public function tpaPatient()
    {
        return $this->hasOne(TpaPatient::class);
    }

    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function totalVisits(): int
    {
        return \Schema::hasTable('visits') ? $this->visits()->count() : 0;
    }

    public function visitsThisMonth(): int
    {
        if (!\Schema::hasTable('visits')) {
            return 0;
        }

        return $this->visits()
            ->whereBetween('visit_date', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();
    }

    public function addresses()
    {
        return $this->hasMany(PatientAddress::class);
    }

    public function lastVisitDate()
    {
        if (!\Schema::hasTable('visits')) {
            return null;
        }

        return $this->visits()
            ->where('visit_date', '<=', now())
            ->latest('visit_date')
            ->value('visit_date');
    }

    public function nextAppointmentDate()
    {
        if (!\Schema::hasTable('visits')) {
            return null;
        }

        return $this->visits()
            ->where('visit_date', '>', now())
            ->orderBy('visit_date')
            ->value('visit_date');
    }

    public function operations()
    {
        return $this->hasMany(Operation::class);
    }

    public function preOperativeChecklists()
    {
        return $this->hasMany(PreOperativeChecklist::class);
    }

    public function assessment()
    {
        return $this->hasOne(PatientAssessment::class);
    }

    /**
     * Get all assessments for the patient.
     */
    public function assessments()
    {
        return $this->hasMany(PatientAssessment::class);
    }


    public function getAgeDisplayAttribute()
    {
        if (!$this->date_of_birth) {
            return null;
        }

        $dob = Carbon::parse($this->date_of_birth);
        $diff = $dob->diff(now());

        return sprintf('%d Year %d Month %d Days', $diff->y, $diff->m, $diff->d);
    }
}
