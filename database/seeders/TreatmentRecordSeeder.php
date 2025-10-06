<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TreatmentRecord;
use App\Models\Patient;
use App\Models\Doctor;

class TreatmentRecordSeeder extends Seeder
{
    public function run(): void
    {
        if (!class_exists(Patient::class)) return;

        $patient = Patient::first();
        $doctor = Doctor::first();
        if ($patient && $doctor) {
            TreatmentRecord::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'date' => now()->toDateString(),
                'procedure' => 'Comprehensive Exam',
                'tooth_numbers' => json_encode([19]),
                'notes' => 'Initial examination completed.',
                'cost' => 150,
                'status' => 'completed',
            ]);
        }
    }
}
