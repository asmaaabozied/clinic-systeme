<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'doctor_code',
        'specialization_id',
        'phone',
        'clinic_address',
        'experience_years',
        'bio',
    ];

    public function specialization()
    {
        return $this->belongsTo(DoctorSpecialization::class, 'specialization_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
