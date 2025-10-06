<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OralHealthAssessment;
use App\Models\Patient;
use App\Models\Doctor;

class OralHealthAssessmentSeeder extends Seeder
{
    public function run(): void
    {
        if (!class_exists(Patient::class)) return;

        $patient = Patient::first();
        $doctor = Doctor::first();
        if ($patient && $doctor) {
            OralHealthAssessment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'gum_health' => 'good',
                'oral_hygiene' => 'fair',
                'issues' => json_encode(['Gum inflammation']),
                'risk_factors' => json_encode(['Coffee consumption']),
                'recommendations' => json_encode(['Increase flossing']),
                'assessment_date' => now()->toDateString(),
            ]);
        }
    }
}
