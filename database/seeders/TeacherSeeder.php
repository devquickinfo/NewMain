<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $sample = [
            ['first_name' => 'Aisha', 'last_name' => 'Khan', 'phone' => '9876500001'],
            ['first_name' => 'Rohit', 'last_name' => 'Sharma', 'phone' => '9876500002'],
            ['first_name' => 'Maya', 'last_name' => 'Patel', 'phone' => '9876500003'],
        ];

        foreach ($sample as $t) {
            Teacher::updateOrCreate(
                ['first_name' => $t['first_name'], 'last_name' => $t['last_name']],
                array_merge($t, ['school_id' => null])
            );
        }
    }
}
