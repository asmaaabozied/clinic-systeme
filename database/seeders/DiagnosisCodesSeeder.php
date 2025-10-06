<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiagnosisCodesSeeder extends Seeder
{
    public function run()
    {
        $jsonPath = database_path('seeders/json/full_diagnosis_codes.json'); // place the file here
        $diagnoses = json_decode(file_get_contents($jsonPath), true);

        foreach (array_chunk($diagnoses, 500) as $chunk) {
            DB::table('diagnosis_codes')->insert($chunk);
        }
    }
}
