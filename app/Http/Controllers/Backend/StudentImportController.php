<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentClass;
use App\Models\Section;
use App\Models\Student;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
class StudentImportController extends Controller
{
    public function index()
    {
       $classes = StudentClass::orderBy('id', 'ASC')->get();
       $sections = Section::get()
       ->unique('name')
       ->values();

        return view(
            'frontend.import',
            compact(
                'classes',
                'sections'
            )
        );

    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
            'class_id' => 'nullable|exists:student_classes,id',
            'section_id' => 'nullable|exists:sections,id',
        ]);

        $schoolId = Auth::user()->school_id;

        /*
        |--------------------------------------------------------------------------
        | Read Excel
        |--------------------------------------------------------------------------
        */

        $sheets = Excel::toArray([], $request->file('file'));

        if (empty($sheets) || empty($sheets[0])) {
            return back()->withErrors([
                'file' => 'The uploaded file is empty.'
            ]);
        }

        $rows = $sheets[0];

        /*
        |--------------------------------------------------------------------------
        | First row = Header
        |--------------------------------------------------------------------------
        */

        $headers = array_map(function ($header) {
            return strtolower(trim($header));
        }, $rows[0]);

        unset($rows[0]);

        /*
        |--------------------------------------------------------------------------
        | Required columns
        |--------------------------------------------------------------------------
        */

        $requiredColumns = [
            'first_name',
            'last_name',
            'father_name',
            'gender',
            'date_of_birth',
            'phone',
        ];

        foreach ($requiredColumns as $column) {

            if (!in_array($column, $headers)) {
                return back()->withErrors([
                    'file' => "Missing required column: {$column}"
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Check whether Excel contains class_id / section_id
        |--------------------------------------------------------------------------
        */

        $hasClassId = in_array('class_id', $headers);
        $hasSectionId = in_array('section_id', $headers);

        /*
        |--------------------------------------------------------------------------
        | If dropdown is empty, Dynamic Excel must contain IDs
        |--------------------------------------------------------------------------
        */

        if (!$request->class_id && !$hasClassId) {
            return back()->withErrors([
                'file' => 'Please select a class or upload a Dynamic Template containing class_id.'
            ]);
        }

        if (!$request->section_id && !$hasSectionId) {
            return back()->withErrors([
                'file' => 'Please select a section or upload a Dynamic Template containing section_id.'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Convert rows to associative arrays
        |--------------------------------------------------------------------------
        */

        $students = [];

        foreach ($rows as $rowNumber => $row) {

            // Ignore completely empty rows
            if (empty(array_filter($row))) {
                continue;
            }

            $data = [];

            foreach ($headers as $index => $header) {
                $data[$header] = isset($row[$index])
                    ? trim((string) $row[$index])
                    : null;
            }

            /*
            |--------------------------------------------------------------------------
            | Class ID
            |--------------------------------------------------------------------------
            |
            | Dropdown selected = dropdown wins
            | Otherwise = Excel value
            |
            */

            $classId = $request->class_id ?: ($data['class_id'] ?? null);

            /*
            |--------------------------------------------------------------------------
            | Section ID
            |--------------------------------------------------------------------------
            */

            $sectionId = $request->section_id ?: ($data['section_id'] ?? null);

            /*
            |--------------------------------------------------------------------------
            | Validate class
            |--------------------------------------------------------------------------
            */

            if (!$classId) {
                return back()->withErrors([
                    'file' => 'Class ID is missing on Excel row ' . ($rowNumber + 1)
                ]);
            }

            if (!StudentClass::where('id', $classId)->exists()) {
                return back()->withErrors([
                    'file' => 'Invalid class_id ' . $classId .
                        ' on Excel row ' . ($rowNumber + 1)
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Validate section
            |--------------------------------------------------------------------------
            */

            if (!$sectionId) {
                return back()->withErrors([
                    'file' => 'Section ID is missing on Excel row ' . ($rowNumber + 1)
                ]);
            }

            if (!Section::where('id', $sectionId)->exists()) {
                return back()->withErrors([
                    'file' => 'Invalid section_id ' . $sectionId .
                        ' on Excel row ' . ($rowNumber + 1)
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Gender validation
            |--------------------------------------------------------------------------
            */

            $gender = ucfirst(strtolower($data['gender'] ?? ''));

            if (!in_array($gender, ['Male', 'Female', 'Other'])) {
                return back()->withErrors([
                    'file' => 'Invalid gender on Excel row ' . ($rowNumber + 1) .
                        '. Allowed: Male, Female, Other.'
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Admission Number
            |--------------------------------------------------------------------------
            */

            $admissionNo = $data['admission_no'] ?? null;

            if (empty($admissionNo)) {

                // Generate admission number if not supplied
                $admissionNo = 'ADM' . time() . rand(100, 999);

                // Make sure it is unique
                while (Student::where('admission_no', $admissionNo)->exists()) {
                    $admissionNo = 'ADM' . time() . rand(100, 999);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Date of Birth
            |--------------------------------------------------------------------------
            */

            $dateOfBirth = null;

            if (!empty($data['date_of_birth'])) {

                $dob = trim($data['date_of_birth']);

                try {

                    if (is_numeric($dob)) {

                        // Excel numeric date
                        $dateOfBirth = Carbon::create(1899, 12, 30)
                            ->addDays((int) $dob)
                            ->format('Y-m-d');

                    } else {

                        $dateOfBirth = null;

                        foreach (['d/m/Y', 'd-m-Y'] as $format) {
                            try {
                                $dateOfBirth = Carbon::createFromFormat($format, $dob)
                                    ->format('Y-m-d');

                                break;
                            } catch (\Exception $e) {
                                // Try next format
                            }
                        }

                        if (!$dateOfBirth) {
                            throw new \Exception('Invalid date format');
                        }
                    }

                } catch (\Exception $e) {

                    return back()->withErrors([
                        'file' => 'Invalid date_of_birth on Excel row ' .
                            ($rowNumber + 1) .
                            '. Use dd/mm/yyyy or dd-mm-yyyy.'
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Prepare student
            |--------------------------------------------------------------------------
            */

            $students[] = [
                'school_id' => $schoolId,

                'admission_no' => $admissionNo,

                'first_name' => $data['first_name'] ?? null,

                'last_name' => $data['last_name'] ?? null,

                'father_name' => $data['father_name'] ?? null,

                // Your DB requires address
                'address' => $data['address'] ?? '',

                'gender' => $gender,

                'date_of_birth' => $dateOfBirth,

                'blood_group' => $data['blood_group'] ?? null,

                'phone' => $data['phone'] ?? null,

                'class_id' => $classId,

                'section_id' => $sectionId,

                'photo' => null,

                'capture_background' => 'Sky Blue',

                'captured_by_camera' => 0,

                'capturephoto' => null,

                'idcardprinted' => 'no',

                'created_at' => now(),

                'updated_at' => now(),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | No students found
        |--------------------------------------------------------------------------
        */

        if (empty($students)) {
            return back()->withErrors([
                'file' => 'No student records found in the Excel file.'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Insert
        |--------------------------------------------------------------------------
        */

        try {

            DB::transaction(function () use ($students) {

                foreach ($students as $student) {

                    // Avoid duplicate admission number
                    if (Student::where('admission_no', $student['admission_no'])->exists()) {
                        throw new \Exception(
                            'Admission number already exists: ' .
                            $student['admission_no']
                        );
                    }

                    Student::create($student);
                }
            });

        } catch (\Exception $e) {

            return back()->withErrors([
                'file' => $e->getMessage()
            ]);
        }

        return redirect()
            ->route('student.import')
            ->with('success', count($students) . ' students imported successfully.');
    }


    public function downloadSample()
    {

        $headers = [
        'first_name',
        'last_name',
        'father_name',
        'gender',
        'date_of_birth',
        'admission_no',
        'phone',
        ];

        $rows = [
            [
                'Rahul',
                'Sharma',
                'Rajesh Sharma',
                'Male',
                '2015-05-10',
                'ADM001',
                '9876543210',
            ],
            [
                'Priya',
                'Verma',
                'Amit Verma',
                'Female',
                '2016-08-15',
                'ADM002',
                '9876543211',
            ],
        ];

        return $this->downloadCsv(
            'student_static_template.csv',
            $headers,
            $rows
        );
    }


    

    public function downloadDynamicSample()
    {

        $headers = [
        'first_name',
        'last_name',
        'father_name',
        'gender',
        'date_of_birth',
        'admission_no',
        'phone',
        'class_id',
        'section_id',
        ];

        $rows = [
            [
                'Rahul',
                'Sharma',
                'Rajesh Sharma',
                'Male',
                '2015-05-10',
                'ADM001',
                '9876543210',
                1,
                1,
            ],
            [
                'Priya',
                'Verma',
                'Amit Verma',
                'Female',
                '2016-08-15',
                'ADM002',
                '9876543211',
                2,
                2,
            ],
        ];

        return $this->downloadCsv(
            'student_dynamic_template.csv',
            $headers,
            $rows
        );
    }

    private function downloadCsv($filename, $headers, $rows)
    {
        return response()->streamDownload(function () use ($headers, $rows) {

            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, $headers);

            // Data rows
            foreach ($rows as $row) {
                fputcsv($file, $row);
            }

            fclose($file);

        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

}
