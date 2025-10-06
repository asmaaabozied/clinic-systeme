<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SymptomType;
use App\Models\SymptomCategory;
use Illuminate\Support\Facades\DB;

class SymptomTypesSeeder extends Seeder
{
    public function run()
    {
        $path = database_path('seeders/json/symptom_types_and_categories.json');
        $data = json_decode(file_get_contents($path), true);

        DB::transaction(function () use ($data) {
            foreach ($data as $typeData) {
                $type = SymptomType::create([
                    'name' => $typeData['symptom_type']
                ]);

                foreach ($typeData['categories'] as $category) {
                    $type->symptomCategories()->create([
                        'title' => $category['title'],
                        'description' => $category['description'],
                    ]);
                }
            }
        });
    }
}
