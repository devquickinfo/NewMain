<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\SelectedSample;
use App\Models\UploadSample;
use App\Models\Mainidcard;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with(['studentClass', 'section'])
                    ->latest()
                    ->paginate(10);
        $classes = StudentClass::all();
        $sections = Section::select('id', 'name', 'class_id')
            ->orderBy('id', 'ASC')
            ->get();
        return view('frontend.addstudent', compact('students', 'classes', 'sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = StudentClass::all();
        $sections = Section::select('id', 'name', 'class_id')
            ->orderBy('id', 'ASC')
            ->get();
        $students = Student::with(['studentClass', 'section'])->latest()->paginate(10);
        $school_id = Auth::user()->school_id ?? session('viewing_school');
        $school = School::where('id', $school_id)->first();
        $mainidcard = Mainidcard::where('school_id', $school_id)->first();
        $selectedSample = SelectedSample::where('school_id', $school_id)->first();
        $idcardsample = null;
        if ($selectedSample) {
            $idcardsample = UploadSample::where('id', $selectedSample->sample_id)->first();
        }

        return view('frontend.addstudent', compact('students', 'classes', 'sections', 'idcardsample', 'mainidcard', 'school'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admission_no'  => 'required|unique:students,admission_no',
            'first_name'    => 'required',
            'father_name'   => 'required',
            'date_of_birth' => 'required|date',
            'gender'        => 'required',
            'class_id'      => 'required',
            'section_id'    => 'required',
            'photo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $photo = null;
        $capturePhoto = null;
        $capturedByCamera = false;

        /*
        |--------------------------------------------------------------------------
        | Camera Image
        |--------------------------------------------------------------------------
        */
        if ($request->filled('photo_data')) {

            $image = $request->photo_data;

            // Remove base64 prefix
            $image = preg_replace(
                '/^data:image\/\w+;base64,/',
                '',
                $image
            );

            $image = str_replace(' ', '+', $image);

            $imageName = time() . '.png';

            Storage::disk('public')->put(
                'capture-photo/' . $imageName,
                base64_decode($image)
            );

            $capturePhoto = 'capture-photo/' . $imageName;
            $capturedByCamera = true;
        }

        /*
        |--------------------------------------------------------------------------
        | Uploaded Image
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('photo')) {

            $photo = $request->file('photo')->store(
                'student-photo',
                'public'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Create Student
        |--------------------------------------------------------------------------
        */
        Student::create([
            'school_id'          => Auth::user()->school_id,
            'admission_no'       => $request->admission_no,
            'first_name'         => $request->first_name,
            'last_name'          => $request->last_name,
            'father_name'        => $request->father_name,
            'address'            => $request->address,
            'gender'             => $request->gender,
            'date_of_birth'      => $request->date_of_birth,
            'blood_group'        => $request->blood_group,
            'phone'              => $request->phone,
            'class_id'           => $request->class_id,
            'section_id'         => $request->section_id,

            // Both can exist
            'photo'              => $photo,
            //'capturephoto'       => $capturePhoto,

            //'capture_background' => $request->capture_background ?? 'Sky Blue',
            //'captured_by_camera' => $capturedByCamera,
        ]);

        return redirect()
            ->route('schools.classes.students', [
                'school' => Auth::user()->school_id ?? session('viewing_school'),
                'class'  => $request->class_id,
            ])
            ->with('success', 'Student updated successfully.');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::with(['studentClass', 'section'])->findOrFail($id);
        return view('frontend.studentshow', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::findOrFail($id);
        $classes = StudentClass::all();
        $sections = Section::selectRaw('MIN(id) as id, name')
            ->groupBy('name')
            ->orderBy('id', 'ASC')
            ->get();
        $students = Student::with(['studentClass', 'section'])->latest()->paginate(10);
        $school_id = Auth::user()->school_id ?? session('viewing_school');
        $school = School::where('id', $school_id)->first();
        $idcardsample = null;
        $selectedSample = SelectedSample::where('school_id', $school_id)->first();
        if ($selectedSample) {
            $idcardsample = UploadSample::where('id', $selectedSample->sample_id)->first();
        }
        $mainidcard = Mainidcard::where('school_id', $school_id)->first();
       

        return view('frontend.addstudent', compact(
            'student',
            'students',
            'classes',
            'sections',
            'idcardsample',
            'mainidcard',
            'school'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'admission_no'  => 'required',
            'first_name'    => 'required',
            'father_name'   => 'required',
            'date_of_birth' => 'required|date',
            'gender'        => 'required',
            'class_id'      => 'required',
            'section_id'    => 'required',
            'photo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $photo = $student->photo;
        $capturePhoto = $student->capturephoto;
        $capturedByCamera = $student->captured_by_camera;
        if ($request->filled('photo_data')) {
            if (
                $capturePhoto &&
                Storage::disk('public')->exists($capturePhoto)
            ) {
                Storage::disk('public')->delete($capturePhoto);
            }
            $image = str_replace(
                'data:image/png;base64,',
                '',
                $request->photo_data
            );
            $image = str_replace(' ', '+', $image);
            $imageName = time() . '.png';
            Storage::disk('public')->put(
                'capture-photo/' . $imageName,
                base64_decode($image)
            );
            $capturePhoto = 'capture-photo/' . $imageName;
            $capturedByCamera = true;
        }
        elseif ($request->hasFile('photo')) {
            if (
                $photo &&
                Storage::disk('public')->exists($photo)
            ) {
                Storage::disk('public')->delete($photo);
            }
            $photo = $request->file('photo')->store(
                'student-photo',
                'public'
            );
            $capturedByCamera = false;
        }
        $student->update([
            'admission_no'       => $request->admission_no,
            'first_name'         => $request->first_name,
            'last_name'          => $request->last_name,
            'father_name'        => $request->father_name,
            'address'            => $request->address,
            'gender'             => $request->gender,
            'date_of_birth'      => $request->date_of_birth,
            'blood_group'        => $request->blood_group,
            'phone'              => $request->phone,
            'class_id'           => $request->class_id,
            'section_id'         => $request->section_id,
            'photo'              => $photo,
            'capturephoto'       => $capturePhoto,
            'capture_background' => $request->capture_background ?? 'Sky Blue',
            'captured_by_camera' => $capturedByCamera,
        ]);
        return redirect()
        ->route('schools.classes.students', [
            'school' => $student->school_id ?? Auth::user()->school_id ?? session('viewing_school'),
            'class'  => $student->class_id,
        ])
        ->with('success', 'Student updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
        //$student->delete();
        $student->IsDeleted = '1';
        $student->save();
        $referer = request()->header('referer');
        if ($referer && preg_match('#/students/\d+$#', parse_url($referer, PHP_URL_PATH))) {
            return redirect('/student/list')
                ->with('success', 'Student Deleted Successfully');
        }
        return redirect()->back()
            ->with('success', 'Student Deleted Successfully');
    }
    public function getSections($classId)
    {
        $sections = Section::orderBy('id', 'ASC')->get();
        return response()->json($sections);
    }

    public function schoolClasses()
    {
        $user = Auth::user();
        $classes = StudentClass::orderBy('id', 'ASC')->get();
        $sections = Section::orderBy('id', 'ASC')->get();
        return view('frontend.school_classes', compact('classes', 'sections'));
    }

    public function classSectionStudents($classId, $sectionId)
    {
        $class = StudentClass::findOrFail($classId);
        $section = Section::findOrFail($sectionId);
        $students = Student::where('class_id', $classId)
            ->where('section_id', $sectionId)
            ->orderBy('first_name')
            ->get();

        return view('frontend.class_section_students', compact('class', 'section', 'students'));
    }

    public function classStudents(Request $request, $schoolId, $classId)
    {
        $school = School::findOrFail($schoolId);
        $selectedClassId = $request->filled('class')
            ? $request->class
            : $classId;
        $class = StudentClass::where('school_id', $school->id)
            ->findOrFail($selectedClassId);

        $classes = StudentClass::all();
        $studentsQuery = Student::with([
                'studentClass',
                'section'
            ])
            ->where('school_id', $school->id)
            ->where('class_id', $class->id)
            ->where('IsDeleted', '0')
            ->orderBy('first_name');
        if ($request->filled('section')) {
            $studentsQuery->where(
                'section_id',
                $request->section
            );
        }
        if ($request->filled('photo_filter')) {
            if ($request->photo_filter === 'with_photo') {
                $studentsQuery->where(function ($query) {
                    $query->whereNotNull('capturephoto')
                        ->where('capturephoto', '!=', '');
                });
            } elseif ($request->photo_filter === 'without_photo') {
                $studentsQuery->where(function ($query) {
                    $query->whereNull('capturephoto')
                        ->orWhere('capturephoto', '');
                });
            }
        }
        if ($request->filled('student_photo')) {
            if ($request->student_photo === 'with_photo') {
                $studentsQuery->where(function ($query) {
                    $query->whereNotNull('photo')
                        ->where('photo', '!=', '');
                });
            } elseif ($request->student_photo === 'without_photo') {

                $studentsQuery->where(function ($query) {
                    $query->whereNull('photo')
                        ->orWhere('photo', '');
                });
            }
        }
        $sections = Section::orderBy('id','asc')->get();
        if($request->per_page){
            $perPage = $request->per_page;
        }else{
            $perPage = 10;
        }
        $students = $studentsQuery
            ->paginate($perPage)
            ->appends($request->query());
        return view(
            'frontend.class_students',
            compact(
                'school',
                'class',
                'students',
                'sections',
                'classes'
            )
        );
    }
    public function capturePhoto(Request $request, string $id)
    {
        $student = Student::findOrFail($id);
        $request->validate([
            'photo_data' => 'required|string',
            'capture_background' => 'nullable|string',
        ]);
        if (
            $student->capturephoto &&
            Storage::disk('public')->exists($student->capturephoto)
        ) {
            Storage::disk('public')->delete($student->capturephoto);
        }
        $image = $request->photo_data;
        $image = preg_replace(
            '/^data:image\/\w+;base64,/',
            '',
            $image
        );
        $image = str_replace(' ', '+', $image);
        $imageName = time() . '_' . $student->id . '.png';
        Storage::disk('public')->put(
            'capture-photo/' . $imageName,
            base64_decode($image)
        );
        $student->update([
            'capturephoto' => 'capture-photo/' . $imageName,
            'capture_background' => $request->capture_background ?? '#dbeafe',
            'captured_by_camera' => true,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Photo captured successfully.'
        ]);
    }
    public function cardStatus(string $id)
    {
        $student = Student::findOrFail($id);
        if ($student->idcardprinted === 'no') {
            $student->idcardprinted = 'yes';
        } else {
            $student->idcardprinted = 'no';
        }
        $student->save();
        return redirect()->back()
            ->with('success', 'Student ID card status updated successfully.');
    }


}
