<?php

namespace Tests\Feature;

use App\Models\School;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RoleBasedDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_dashboard_shows_system_overview(): void
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'super@example.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200)
            ->assertSeeText('System Overview');
    }

    public function test_school_dashboard_shows_school_overview(): void
    {
        $school = School::create([
            'school_name' => 'Sunshine School',
            'school_code' => 'SUN001',
            'email' => 'sunshine@example.com',
            'phone' => '1234567890',
            'address' => 'Main Street',
            'city' => 'Delhi',
            'state' => 'Delhi',
            'pincode' => '110001',
            'status' => true,
        ]);

        StudentClass::create([
            'name' => 'Class A',
            'school_id' => $school->id,
        ]);

        Section::create([
            'class_id' => StudentClass::first()->id,
            'school_id' => $school->id,
            'name' => 'A',
        ]);

        Student::create([
            'admission_no' => 'ADM-100',
            'school_id' => $school->id,
            'first_name' => 'Asha',
            'last_name' => 'K',
            'gender' => 'Female',
            'class_id' => StudentClass::first()->id,
            'section_id' => Section::first()->id,
        ]);

        $otherSchool = School::create([
            'school_name' => 'Other School',
            'school_code' => 'OTHER001',
            'email' => 'other@example.com',
            'phone' => '9876543210',
            'address' => 'Other Street',
            'city' => 'Delhi',
            'state' => 'Delhi',
            'pincode' => '110002',
            'status' => true,
        ]);

        StudentClass::create([
            'name' => 'Class B',
            'school_id' => $otherSchool->id,
        ]);

        Section::create([
            'class_id' => StudentClass::orderByDesc('id')->first()->id,
            'school_id' => $otherSchool->id,
            'name' => 'B',
        ]);

        Student::create([
            'admission_no' => 'ADM-200',
            'school_id' => $otherSchool->id,
            'first_name' => 'Bharat',
            'last_name' => 'R',
            'gender' => 'Male',
            'class_id' => StudentClass::orderByDesc('id')->first()->id,
            'section_id' => Section::orderByDesc('id')->first()->id,
        ]);

        $user = User::create([
            'name' => 'School Admin',
            'email' => 'school@example.com',
            'password' => Hash::make('password'),
            'role' => 'school',
            'school_id' => $school->id,
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200)
            ->assertSeeText('School Overview')
            ->assertSeeText('1')
            ->assertSeeText('1')
            ->assertSeeText('1');
    }

    public function test_school_user_can_open_their_own_school_page(): void
    {
        $school = School::create([
            'school_name' => 'Bright Future School',
            'school_code' => 'BRIGHT001',
            'email' => 'bright@example.com',
            'phone' => '1234567890',
            'address' => 'Main Street',
            'city' => 'Delhi',
            'state' => 'Delhi',
            'pincode' => '110001',
            'status' => true,
        ]);

        $user = User::create([
            'name' => 'Bright School Admin',
            'email' => 'bright-school@example.com',
            'password' => Hash::make('password'),
            'role' => 'school',
            'school_id' => $school->id,
        ]);

        $response = $this->actingAs($user)->get(route('schools.show', $school));

        $response->assertStatus(200)
            ->assertSeeText('Bright Future School');
    }

    public function test_admin_can_create_school_with_logo(): void
    {
        Storage::fake('public');

        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
        ]);

        $file = UploadedFile::fake()->create('logo.png', 100, 'image/png');

        $response = $this->actingAs($user)->post(route('schools.store'), [
            'school_name' => 'New School',
            'school_code' => 'NEW001',
            'email' => 'new@example.com',
            'phone' => '9999999999',
            'address' => 'Some Address',
            'city' => 'Delhi',
            'state' => 'Delhi',
            'pincode' => '110001',
            'status' => true,
            'school_logo' => $file,
        ]);

        $response->assertRedirect(route('schools.index'));
        $this->assertDatabaseHas('schools', ['school_code' => 'NEW001']);
        $this->assertDatabaseHas('schools', ['school_name' => 'New School']);
    }

    public function test_school_user_can_view_students_for_a_selected_class(): void
    {
        $school = School::create([
            'school_name' => 'Class View School',
            'school_code' => 'CLASS001',
            'email' => 'classview@example.com',
            'phone' => '1234567890',
            'address' => 'Main Street',
            'city' => 'Delhi',
            'state' => 'Delhi',
            'pincode' => '110001',
            'status' => true,
        ]);

        $class = StudentClass::create([
            'name' => 'Grade 10',
            'school_id' => $school->id,
        ]);

        $section = Section::create([
            'class_id' => $class->id,
            'school_id' => $school->id,
            'name' => 'A',
        ]);

        $student = Student::create([
            'admission_no' => 'ADM1001',
            'school_id' => $school->id,
            'first_name' => 'Aarav',
            'last_name' => 'Singh',
            'gender' => 'Male',
            'class_id' => $class->id,
            'section_id' => $section->id,
            'phone' => '9999999999',
        ]);

        $user = User::create([
            'name' => 'Class School Admin',
            'email' => 'class-school@example.com',
            'password' => Hash::make('password'),
            'role' => 'school',
            'school_id' => $school->id,
        ]);

        $response = $this->actingAs($user)->get(route('schools.classes.students', ['school' => $school, 'class' => $class]));

        $response->assertStatus(200)
            ->assertSeeText('Grade 10')
            ->assertSeeText('Aarav Singh');
    }

    public function test_class_students_page_shows_students_without_school_id(): void
    {
        $school = School::create([
            'school_name' => 'Nursery School',
            'school_code' => 'NURS001',
            'email' => 'nursery@example.com',
            'phone' => '1234567890',
            'address' => 'Main Street',
            'city' => 'Delhi',
            'state' => 'Delhi',
            'pincode' => '110001',
            'status' => true,
        ]);

        $class = StudentClass::create([
            'name' => 'Nursery',
            'school_id' => $school->id,
        ]);

        $section = Section::create([
            'class_id' => $class->id,
            'school_id' => $school->id,
            'name' => 'A',
        ]);

        Student::create([
            'admission_no' => 'ADM2001',
            'school_id' => null,
            'first_name' => 'Maya',
            'last_name' => 'Kumar',
            'gender' => 'Female',
            'class_id' => $class->id,
            'section_id' => $section->id,
            'phone' => '8888888888',
        ]);

        $user = User::create([
            'name' => 'Nursery Admin',
            'email' => 'nursery-admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'school',
            'school_id' => $school->id,
        ]);

        $response = $this->actingAs($user)->get(route('schools.classes.students', ['school' => $school, 'class' => $class]));

        $response->assertStatus(200)
            ->assertSeeText('Nursery')
            ->assertSeeText('Maya Kumar');
    }

    public function test_school_can_be_updated(): void
    {
        $school = School::create([
            'school_name' => 'Old Name',
            'school_code' => 'OLD001',
            'email' => 'old@example.com',
            'phone' => '1111111111',
            'address' => 'Old Address',
            'city' => 'Delhi',
            'state' => 'Delhi',
            'pincode' => '110001',
            'status' => true,
        ]);

        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin-update@example.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
        ]);

        $response = $this->actingAs($user)->put(route('schools.update', $school), [
            'school_name' => 'Updated Name',
            'school_code' => 'NEWCODE001',
            'email' => 'updated@example.com',
            'phone' => '2222222222',
            'address' => 'Updated Address',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'pincode' => '400001',
            'status' => false,
        ]);

        $response->assertRedirect(route('schools.show', $school));
        $this->assertDatabaseHas('schools', [
            'id' => $school->id,
            'school_name' => 'Updated Name',
            'school_code' => 'NEWCODE001',
            'email' => 'updated@example.com',
            'phone' => '2222222222',
            'address' => 'Updated Address',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'pincode' => '400001',
            'status' => false,
        ]);
    }
}
