<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToothCondition;
use App\Models\Patient;
use App\Models\Doctor;

class ToothConditionSeeder extends Seeder
{
    public function run(): void
    {
        if (!class_exists(Patient::class)) return;

        $patient = Patient::first();
        $doctor = Doctor::first();
        if ($patient && $doctor) {
            ToothCondition::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'tooth_number' => 19,
                'condition' => 'decay',
                'severity' => 'moderate',
                'notes' => 'Visible cavity',
                'date' => now()->toDateString(),
                'images' => json_encode([]),
            ]);
        }
    }
}
