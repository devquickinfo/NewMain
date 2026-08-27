<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\StudentClass;
use Illuminate\Database\Seeder;

class StudentClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            'Nursery',
            'L KG',
            'U KG',
            'Class I',
            'Class II',
            'Class III',
            'Class IV',
            'Class V',
            'Class VI',
            'Class VII',
            'Class VIII',
            'Class IX',
            'Class X',
            'Class XI',
            'Class XII',
        ];

        $schools = School::all();

        foreach ($schools as $school) {

            foreach ($classes as $class) {

                StudentClass::firstOrCreate([
                    'school_id' => $school->id,
                    'name' => $class,
                ]);

            }
        }
    }
}