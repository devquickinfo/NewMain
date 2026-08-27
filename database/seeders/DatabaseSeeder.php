<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $school = School::updateOrCreate(
            ['school_code' => 'DEMO001'],
            [
                'school_name' => 'Demo School',
                'email' => 'demo@example.com',
                'phone' => '9876543210',
                'address' => 'Main Street',
                'city' => 'Delhi',
                'state' => 'Delhi',
                'pincode' => '110001',
                'status' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'superadmin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'school@example.com'],
            [
                'name' => 'School Admin',
                'password' => Hash::make('password'),
                'role' => 'school',
                'school_id' => $school->id,
            ]
        );

        $this->call([
            StudentClassSeeder::class,
            SectionSeeder::class,
            StudentSeeder::class,
            TeacherSeeder::class,
        ]);
    }
}
