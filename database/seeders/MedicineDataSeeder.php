<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pathology;
use App\Models\MedicineCategory;
use App\Models\Medicine;
use App\Models\Dose;  
use App\Models\DoseInterval; 
use App\Models\DoseDuration;
use App\Models\Radiology;  
use App\Models\FindingCategory; 
use App\Models\Finding;

class MedicineDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  
public function run()
{
    $categories = [
        ['name' => 'Antibiotics'],
        ['name' => 'Antihistamines'],
        ['name' => 'Pain Relievers'],
        ['name' => 'Antacids'],
    ];
    
    foreach ($categories as $category) {
        MedicineCategory::create($category);
    }
    
    $medicines = [
        ['medicine_category_id' => 1, 'name' => 'Amoxicillin'],
        ['medicine_category_id' => 1, 'name' => 'Azithromycin'],
        ['medicine_category_id' => 2, 'name' => 'Loratadine'],
    ];
    
    foreach ($medicines as $medicine) {
        Medicine::create($medicine);
    }
    
    $doses = [
        ['name' => '1 tablet'],
        ['name' => '2 tablets'],
        ['name' => '5ml'],
    ];
    
    foreach ($doses as $dose) {
        Dose::create($dose);
    }

    $Pathologies = [
        ['name'   => 'Pathology 1'],
        ['name'   => 'Pathology 2'],
        ['name'   => 'Pathology 3'],
    ];

    foreach ($Pathologies as $Patholog) {
        Pathology::create($Patholog);
    }

    $FindingCategorys = [
        ['name'   => 'FindingCategory 1'],
        ['name'   => 'FindingCategory 2'],
        ['name'   => 'FindingCategory 3'],
    ];

    foreach ($FindingCategorys as $FindingCategory) {
        FindingCategory::create($FindingCategory);
    }

    $findings = [
        ['finding_category_id' => 1, 'name' => 'Finding 1'],
        ['finding_category_id' => 1, 'name' => 'Finding 2'],
        ['finding_category_id' => 2, 'name' => 'Finding 3'],
    ];
    
    foreach ($findings as $finding) {
        Finding::create($finding);
    }

    $Radiologys = [
        ['name'   => 'Radiology 1'],
        ['name'   => 'Radiology 2'],
        ['name'   => 'Radiology 3'],
    ];

    foreach ($Radiologys as $Radiology) {
        Radiology::create($Patholog);
    }

    $DoseIntervals = [
        ['name'   => 'DoseInterval 1'],
        ['name'   => 'DoseInterval 2'],
        ['name'   => 'DoseInterval 3'],
    ];

    foreach ($DoseIntervals as $DoseInterval) {
        DoseInterval::create($DoseInterval);
    }

    $DoseDurations = [
        ['name'   => 'DoseDuration 1'],
        ['name'   => 'DoseDuration 2'],
        ['name'   => 'DoseDuration 3'],
    ];

    foreach ($DoseDurations as $DoseDuration) {
        DoseDuration::create($DoseDuration);
    }
    
}
}
