<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\Section;
use App\Models\StudentClass;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     $classes = StudentClass::all();

    //     foreach ($classes as $class) {
    //         foreach (['A', 'B', 'C'] as $sectionName) {
    //             Section::firstOrCreate([
    //                 'class_id' => $class->id,
    //                 'name' => $sectionName,
    //             ]);
    //         }
    //     }
    // }
    public function run(): void
    {
        foreach (['A', 'B', 'C', 'D'] as $sectionName) {
            Section::firstOrCreate([
                'name' => $sectionName,
            ]);
        }
    }
}
