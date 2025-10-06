<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DentalTreatmentPlan;
use App\Models\Patient;
use App\Models\Doctor;

class DentalTreatmentPlanSeeder extends Seeder
{
    public function run(): void
    {
        if (!class_exists(Patient::class)) return;

        $patient = Patient::first();
        $doctor = Doctor::first();
        if ($patient && $doctor) {
            DentalTreatmentPlan::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'title' => 'Comprehensive Restoration',
                'stage' => 'procedure',
                'procedures' => json_encode(['Tooth #19 Filling', 'Cleaning']),
                'estimated_cost' => 850,
                'start_date' => now()->toDateString(),
                'estimated_completion' => now()->addMonth()->toDateString(),
            ]);
        }
    }
}
