<?php

namespace Database\Seeders;

use App\Models\VisitType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisitTypeSeeder extends Seeder
{
    public function run(): void
    {
        VisitType::firstOrCreate(['name' => 'Follow-up']);
        VisitType::firstOrCreate(['name' => 'Initial Consultation']);
        VisitType::firstOrCreate(['name' => 'Emergency']);
    }
}
