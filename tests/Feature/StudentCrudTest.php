<?php

namespace Tests\Feature;

use App\Models\School;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StudentCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_index_page_shows_management_actions(): void
    {
        $user = User::factory()->create([
            'role' => 'superadmin',
        ]);

        $class = StudentClass::create(['name' => 'Class 1']);
        $section = Section::create([
            'class_id' => $class->id,
            'name' => 'A',
        ]);

        Student::create([
            'admission_no' => 'ADM-001',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'address' => 'Test Address',
            'gender' => 'Male',
            'class_id' => $class->id,
            'section_id' => $section->id,
        ]);

        $response = $this->actingAs($user)->get(route('students.index'));

        $response->assertOk();
        $response->assertSee('Add Student');
        $response->assertSee('Edit');
        $response->assertSee('Delete');
    }

    public function test_class_students_page_shows_manage_actions_for_selected_class(): void
    {
        $user = User::factory()->create([
            'role' => 'superadmin',
        ]);

        $school = School::create([
            'school_name' => 'Demo School',
            'school_code' => 'DS1',
            'email' => 'demo@example.com',
            'phone' => '1234567890',
            'address' => 'Test Address',
            'city' => 'Test City',
            'state' => 'Test State',
            'pincode' => '123456',
            'status' => true,
        ]);

        $class = StudentClass::create([
            'name' => 'Class 2',
            'school_id' => $school->id,
        ]);

        $section = Section::create([
            'class_id' => $class->id,
            'school_id' => $school->id,
            'name' => 'B',
        ]);

        Student::create([
            'admission_no' => 'ADM-002',
            'school_id' => $school->id,
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'address' => 'Test Address',
            'gender' => 'Female',
            'class_id' => $class->id,
            'section_id' => $section->id,
        ]);

        $response = $this->actingAs($user)->get(route('schools.classes.students', ['school' => $school->id, 'class' => $class->id, 'section' => $section->id, 'photo_filter' => 'with_photo']));

        $response->assertOk();
        $response->assertSee('Filter');
        $response->assertSee('Add Student');
        $response->assertSee('Student List');
    }

    public function test_student_update_can_store_captured_photo(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'superadmin',
        ]);

        $class = StudentClass::create(['name' => 'Class 5']);
        $section = Section::create([
            'class_id' => $class->id,
            'name' => 'E',
        ]);

        $student = Student::create([
            'admission_no' => 'ADM-005',
            'first_name' => 'Sam',
            'last_name' => 'Green',
            'address' => 'Test Address',
            'gender' => 'Male',
            'class_id' => $class->id,
            'section_id' => $section->id,
        ]);

        $base64Image = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAACklEQVR4nGMAAQABAA0ABQAB3gAAAABJRU5ErkJggg==';

        $this->withoutMiddleware();

        $response = $this->actingAs($user)->put(route('students.update', $student->id), [
            'admission_no' => 'ADM-005',
            'first_name' => 'Sam',
            'father_name' => 'Alex',
            'address' => 'Test Address',
            'date_of_birth' => '2000-01-01',
            'gender' => 'Male',
            'class_id' => $class->id,
            'section_id' => $section->id,
            'photo_data' => 'data:image/png;base64,' . $base64Image,
            'capture_background' => 'Mint Green',
        ]);

        $response->assertRedirect(route('students.edit', $student->id));
        $student->refresh();

        $this->assertNotNull($student->capturephoto);
        $this->assertTrue($student->captured_by_camera);
        $this->assertNull($student->photo);
        $this->assertSame('Mint Green', $student->capture_background);
    }

    public function test_student_update_prefers_uploaded_photo_over_stale_capture_data(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'superadmin',
        ]);

        $class = StudentClass::create(['name' => 'Class 6']);
        $section = Section::create([
            'class_id' => $class->id,
            'name' => 'F',
        ]);

        $student = Student::create([
            'admission_no' => 'ADM-006',
            'first_name' => 'Taylor',
            'last_name' => 'Swift',
            'address' => 'Test Address',
            'gender' => 'Female',
            'class_id' => $class->id,
            'section_id' => $section->id,
        ]);

        $photo = UploadedFile::fake()->image('avatar.png', 200, 200);

        $this->withoutMiddleware();

        $response = $this->actingAs($user)->put(route('students.update', $student->id), [
            'admission_no' => 'ADM-006',
            'first_name' => 'Taylor',
            'father_name' => 'James',
            'address' => 'Updated Address',
            'date_of_birth' => '2000-01-01',
            'gender' => 'Female',
            'class_id' => $class->id,
            'section_id' => $section->id,
            'photo' => $photo,
            'photo_data' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAACklEQVR4nGMAAQABAA0ABQAB3gAAAABJRU5ErkJggg==',
        ]);

        $response->assertRedirect(route('students.edit', $student->id));
        $student->refresh();

        $this->assertNotNull($student->photo);
        $this->assertNull($student->capturephoto);
        $this->assertFalse($student->captured_by_camera);
        $this->assertSame('Updated Address', $student->address);
    }

    public function test_id_card_search_returns_matching_students(): void
    {
        $school = School::create([
            'school_name' => 'Search School',
            'school_code' => 'SS1',
            'email' => 'search@example.com',
            'phone' => '1234567890',
            'address' => 'Test Address',
            'city' => 'Test City',
            'state' => 'Test State',
            'pincode' => '123456',
            'status' => true,
        ]);

        $user = User::factory()->create([
            'role' => 'superadmin',
            'school_id' => $school->id,
        ]);

        $class = StudentClass::create([
            'name' => 'Class 3',
            'school_id' => $school->id,
        ]);

        $section = Section::create([
            'class_id' => $class->id,
            'school_id' => $school->id,
            'name' => 'C',
        ]);

        Student::create([
            'admission_no' => 'ADM-100',
            'school_id' => $school->id,
            'first_name' => 'Jane',
            'last_name' => 'Roe',
            'address' => 'Test Address',
            'gender' => 'Female',
            'class_id' => $class->id,
            'section_id' => $section->id,
        ]);

        Student::create([
            'admission_no' => 'ADM-200',
            'school_id' => $school->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'address' => 'Test Address',
            'gender' => 'Male',
            'class_id' => $class->id,
            'section_id' => $section->id,
        ]);

        $response = $this->actingAs($user)->get(route('idcard.search.students', ['search' => 'Jane']));

        $response->assertOk();
        $response->assertSee('Jane');
        $response->assertDontSee('John');
    }

    public function test_id_card_printed_filter_returns_only_printed_students(): void
    {
        $school = School::create([
            'school_name' => 'Printed School',
            'school_code' => 'PS1',
            'email' => 'printed@example.com',
            'phone' => '1234567890',
            'address' => 'Test Address',
            'city' => 'Test City',
            'state' => 'Test State',
            'pincode' => '123456',
            'status' => true,
        ]);

        $user = User::factory()->create([
            'role' => 'superadmin',
            'school_id' => $school->id,
        ]);

        $class = StudentClass::create([
            'name' => 'Class 4',
            'school_id' => $school->id,
        ]);

        $section = Section::create([
            'class_id' => $class->id,
            'school_id' => $school->id,
            'name' => 'D',
        ]);

        Student::create([
            'admission_no' => 'ADM-300',
            'school_id' => $school->id,
            'first_name' => 'Alice',
            'last_name' => 'Brown',
            'address' => 'Test Address',
            'gender' => 'Female',
            'class_id' => $class->id,
            'section_id' => $section->id,
            'idcardprinted' => 'yes',
        ]);

        Student::create([
            'admission_no' => 'ADM-400',
            'school_id' => $school->id,
            'first_name' => 'Bob',
            'last_name' => 'White',
            'address' => 'Test Address',
            'gender' => 'Male',
            'class_id' => $class->id,
            'section_id' => $section->id,
            'idcardprinted' => 'no',
        ]);

        $response = $this->actingAs($user)->get(route('idcard.search.students', ['printed' => 'yes']));

        $response->assertOk();
        $response->assertSee('Alice');
        $response->assertDontSee('Bob');
    }
}
