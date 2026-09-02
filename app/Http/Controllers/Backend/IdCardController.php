<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\Section;
use App\Models\School;
use App\Models\SelectedSample;
use App\Models\UploadSample;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Mainidcard;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class IdCardController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = Auth::user()->school_id ?? session('viewing_school');
        $classes = StudentClass::
            orderBy('id', 'ASC')
            ->get();
        $sections = Section::selectRaw('MIN(id) as id, name')
            ->groupBy('name')
            ->orderBy('id', 'ASC')
            ->get();
        if($request->has('per_page') && is_numeric($request->input('per_page'))){
            $perPage = (int)$request->input('per_page');
        } else {
            $perPage = 20; 
        }
        $students = $this->buildStudentQuery($request, $schoolId)
            ->paginate($perPage);

        return view('schools.createidcard', compact(
            'classes',
            'sections',
            'students',
            'perPage',
        ));
    }

    public function searchStudents(Request $request)
    {
        $schoolId = Auth::user()->school_id;

        $students = $this->buildStudentQuery($request, $schoolId)
            ->get();

        return view('schools.partials.student_rows', compact('students'))->render();
    }

    
    public function generate(Request $request)
    {
        $schoolId = Auth::user()->school_id;

        $studentIds = $request->input('student_ids', []);

        if (empty($studentIds)) {
            return redirect()->back()->with('error', 'Please select at least one student.');
        }

        $students = Student::with(['studentClass', 'section'])
            ->where('school_id', $schoolId)
            ->whereIn('id', $studentIds)
            ->orderBy('first_name')
            ->get();

        $school = School::find($schoolId);

        // Whitelist so an unexpected value never produces a broken/blank card
        $allowedTemplates = ['sky_blue', 'blue', 'green', 'red', 'custom'];
        $template = $request->input('background_template', 'sky_blue');
        $template = in_array($template, $allowedTemplates) ? $template : 'sky_blue';

        $orientation = $request->input('orientation', 'horizontal');
        $orientation = in_array($orientation, ['horizontal', 'vertical']) ? $orientation : 'horizontal';

        // Cards per A4 page — tuned to each card shape so the grid fills exactly
        $cardsPerPage = $orientation === 'vertical' ? 12 : 10;

        $students->each(function ($student) {
            $student->idcardprinted = 'yes';
            $student->save();
        });

        return response()
        ->view('schools.generated_id_cards', [
            'students' => $students,
            'school' => $school,
            'template' => $template,
            'orientation' => $orientation,
            'cardsPerPage' => $cardsPerPage,
        ])
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache')
        ->header('Expires', '0');
    }
    // public function editIDCard(Request $request)
    // {
    //      $schoolId = Auth::user()->school_id ?? session('viewing_school');
    //      $selectid =SelectedSample::where('school_id',$schoolId)->pluck('sample_id')->toArray();
    //      $selectedSample = UploadSample::whereIn('id', $selectid)->first();
    //      $school = School::find($schoolId);
    //      $idCardData=Mainidcard::where('school_id',$schoolId)->first();
    //      if($idCardData){
    //         $designcard=$idCardData;
    //      } else {
    //         $designcard = null;
    //      }
    //      return response()
    //     ->view('IDCards.inlteeditor', compact('schoolId','selectedSample','designcard','school'))
    //     ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
    //     ->header('Pragma', 'no-cache')
    //     ->header('Expires', '0');
    // }
    public function editIDCard(Request $request)
    {
        //echo '<pre>';print_r($request->all()); die;
        $schoolId = Auth::user()->school_id ?? session('viewing_school');
        $orientation = $request->query('orientation', 'vertical');
        if (!in_array($orientation, ['vertical', 'horizontal'])) {
            $orientation = 'vertical';
        }
        $selectedSampleId = SelectedSample::where('school_id', $schoolId)
            ->where('orientation', $orientation)
            ->value('sample_id');
        $selectedSample = null;
        if ($selectedSampleId) {
            $selectedSample = UploadSample::find($selectedSampleId);
        }
        $school = School::find($schoolId);
        $idCardData = Mainidcard::where('school_id', $schoolId)->where('orientation',$request->orientation)->first();
        $designcard = $idCardData ?: null;
        return response()
            ->view(
                'IDCards.inlteeditor',
                compact(
                    'schoolId',
                    'selectedSample',
                    'designcard',
                    'school',
                    'orientation'
                )
            )
            ->header(
                'Cache-Control',
                'no-store, no-cache, must-revalidate, max-age=0'
            )
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
   

    protected function buildStudentQuery(Request $request, $schoolId)
    {
        $search = trim($request->input('search', $request->input('student_search', '')));
        return Student::with(['studentClass', 'section'])
            ->where('school_id', $schoolId)
            ->when($request->filled('class_id'), function ($query) use ($request) {
                $query->where('class_id', $request->class_id);
            })
            ->when($request->filled('section_id'), function ($query) use ($request) {
                $query->where('section_id', $request->section_id);
            })
            ->when($request->filled('photo'), function ($query) use ($request) {
                if ($request->photo === 'available') {
                    $query->where(function ($query) {
                        $query->where(function ($q) {
                            $q->whereNotNull('photo')
                                ->where('photo', '!=', '');
                        })
                            ->orWhere(function ($q) {
                                $q->whereNotNull('capturephoto')
                                    ->where('capturephoto', '!=', '');
                            });
                    });
                }

                if ($request->photo === 'not_available') {
                    $query->where(function ($query) {
                        $query->where(function ($q) {
                            $q->whereNull('photo')
                                ->orWhere('photo', '');
                        })
                            ->where(function ($q) {
                                $q->whereNull('capturephoto')
                                    ->orWhere('capturephoto', '');
                            });
                    });
                }
            })
            ->when($request->filled('printed'), function ($query) use ($request) {
                if ($request->printed === 'yes') {
                    $query->where('idcardprinted', 'yes');
                } elseif ($request->printed === 'no') {
                    $query->where('idcardprinted', 'no');
                }
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('admission_no', 'LIKE', '%' . $search . '%');
                });
            })
            ->orderBy('first_name');
    }
     public function uploadDesign(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Get School ID
        |--------------------------------------------------------------------------
        */

        $schoolId = Auth::user()?->school_id
            ?? session('viewing_school');

        if (!$schoolId) {

            return response()->json([
                'success' => false,
                'message' => 'School not found.'
            ], 400);
        }


        /*
        |--------------------------------------------------------------------------
        | Validate request
        |--------------------------------------------------------------------------
        |
        | Do NOT use max:1024 here.
        | We will compress the image to 1 MB ourselves.
        |
        */

        $request->validate([
            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:20480'
            ],

            'orientation' => [
                'required',
                'in:horizontal,vertical'
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Get uploaded image
        |--------------------------------------------------------------------------
        */

        $uploadedFile = $request->file('image');

        $orientation = $request->input('orientation');

        $originalName = $uploadedFile->getClientOriginalName();


        /*
        |--------------------------------------------------------------------------
        | Card dimensions
        |--------------------------------------------------------------------------
        */

        if ($orientation === 'horizontal') {

            $width = 317;
            $height = 204;

        } else {

            $width = 204;
            $height = 317;
        }


        /*
        |--------------------------------------------------------------------------
        | Create Image Manager
        |--------------------------------------------------------------------------
        */

        $manager = new ImageManager(
            new Driver()
        );


        /*
        |--------------------------------------------------------------------------
        | Read Image
        |--------------------------------------------------------------------------
        */

        try {

            $image = $manager->read(
                $uploadedFile->getPathname()
            );

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Unable to read uploaded image.'
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | Resize image exactly
        |--------------------------------------------------------------------------
        */

        $image->resize(
            width: $width,
            height: $height
        );


        /*
        |--------------------------------------------------------------------------
        | Compress image to <= 1 MB
        |--------------------------------------------------------------------------
        */

        $maxSize = 1024 * 1024; // 1 MB

        $quality = 90;

        do {

            $encoded = $image->toJpeg($quality);

            $size = strlen($encoded);

            $quality -= 5;

        } while (
            $size > $maxSize &&
            $quality >= 20
        );


        /*
        |--------------------------------------------------------------------------
        | Check final size
        |--------------------------------------------------------------------------
        */

        if ($size > $maxSize) {

            return response()->json([
                'success' => false,
                'message' => 'Unable to reduce image below 1 MB.'
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | Generate filename
        |--------------------------------------------------------------------------
        */

        $filename = uniqid('sample_') . '.jpg';


        /*
        |--------------------------------------------------------------------------
        | Storage path
        |--------------------------------------------------------------------------
        */

        $path = 'samples/' . $schoolId . '/' . $filename;


        /*
        |--------------------------------------------------------------------------
        | Save image
        |--------------------------------------------------------------------------
        */

        try {

            Storage::disk('public')->put(
                $path,
                (string) $encoded
            );

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Unable to save image.'
            ], 500);
        }


        /*
        |--------------------------------------------------------------------------
        | Insert into upload_samples
        |--------------------------------------------------------------------------
        */

        $sample = UploadSample::create([
            'school_id' => $schoolId,
            'name' => $originalName,
            'file_path' => $path,
            'orientation' => $orientation,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Set uploaded sample as selected sample
        |--------------------------------------------------------------------------
        */

        $selectedSample = SelectedSample::updateOrCreate(

            [
                'school_id' => $schoolId,
                'orientation' => $orientation,
            ],

            [
                'sample_id' => $sample->id,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Image URL
        |--------------------------------------------------------------------------
        */

        $imageUrl = Storage::disk('public')->url(
            $path
        );


        /*
        |--------------------------------------------------------------------------
        | Return JSON
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => true,

            'message' => 'Card design uploaded successfully.',

            'sample_id' => $sample->id,

            'name' => $sample->name,

            'path' => $sample->file_path,

            'url' => $imageUrl,

            'orientation' => $orientation,

            'width' => $width,

            'height' => $height,

            'size' => round($size / 1024, 2) . ' KB',

            'selected_sample_id' => $selectedSample->id,

        ]);
    }
}

