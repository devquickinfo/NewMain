<?php

namespace App\Http\Controllers;

use App\Models\IdCardTemplate;
use App\Models\IdCardTemplateField;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class IdCardTemplateController extends Controller
{

    /**
     * Resolve the effective school id for the current action.
     * For superadmin, prefer session('viewing_school') set when viewing a school.
     */
    private function resolveSchoolId()
    {
        $user = Auth::user();

        if ($user && $user->role === 'superadmin') {
            $schoolId = session('viewing_school');
            if (! $schoolId) {
                abort(403, 'No school selected.');
            }
            return $schoolId;
        }

        if (! $user || ! $user->school_id) {
            abort(403);
        }

        return $user->school_id;
    }

    /**
     * Display all templates for logged-in school.
     */
    public function index()
    {
        $schoolId = $this->resolveSchoolId();

        $templates = IdCardTemplate::where('school_id', $schoolId)
            ->withCount('fields')
            ->latest()
            ->paginate(12);

        return view('id_card_templates.index', compact('templates'));
    }


    /**
     * Show upload/create template page.
     */
    public function create()
    {
        return view('id_card_templates.create');
    }


    /**
     * Upload and create ID card template.
     */
    public function store(Request $request)
    {
        $schoolId = $this->resolveSchoolId();

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Upload image
        |--------------------------------------------------------------------------
        */

        $image = $request->file('image');

        $imagePath = $image->store(
            'id-card-templates',
            'public'
        );


        /*
        |--------------------------------------------------------------------------
        | Get original image dimensions
        |--------------------------------------------------------------------------
        */

        $imageWidth = null;
        $imageHeight = null;

        $fullPath = Storage::disk('public')->path($imagePath);

        if (file_exists($fullPath)) {

            $imageInfo = getimagesize($fullPath);

            if ($imageInfo) {
                $imageWidth = $imageInfo[0];
                $imageHeight = $imageInfo[1];
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Create template
        |--------------------------------------------------------------------------
        */

        $template = IdCardTemplate::create([
            'school_id'     => $schoolId,
            'name'          => $request->name,
            'image_path'    => $imagePath,
            'image_width'   => $imageWidth,
            'image_height'  => $imageHeight,
            'is_active'     => true,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect to designer
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('id-card-templates.designer', $template->id)
            ->with('success', 'ID card template uploaded successfully. Now place the fields on the card.');
    }


    /**
     * Open template designer.
     */
    public function designer($id)
    {
        $schoolId = $this->resolveSchoolId();

        $template = IdCardTemplate::with('fields')
            ->where('school_id', $schoolId)
            ->findOrFail($id);

        return view(
            'id_card_templates.designer',
            compact('template')
        );
    }


    /**
     * Save template fields/positions.
     */
    public function saveFields(Request $request, $id)
    {
        $schoolId = $this->resolveSchoolId();

        $template = IdCardTemplate::where('school_id', $schoolId)
            ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Validate
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'fields' => [
                'required',
                'array',
            ],

            'fields.*.field_type' => [
                'required',
                'string',
                Rule::in([
                    'school_logo',
                    'school_name',
                    'student_photo',
                    'student_name',
                    'first_name',
                    'last_name',
                    'father_name',
                    'mother_name',
                    'admission_no',
                    'class',
                    'section',
                    'dob',
                    'gender',
                    'blood_group',
                    'phone',
                    'address',
                    'academic_year',
                    'principal_name',
                    'qr_code',
                    'barcode',
                    'signature',
                ]),
            ],

            'fields.*.x' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],

            'fields.*.y' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],

            'fields.*.width' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
            ],

            'fields.*.height' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
            ],

            'fields.*.font_size' => [
                'nullable',
                'numeric',
                'min:1',
                'max:200',
            ],

            'fields.*.font_family' => [
                'nullable',
                'string',
                'max:100',
            ],

            'fields.*.font_color' => [
                'nullable',
                'string',
                'max:20',
            ],

            'fields.*.font_weight' => [
                'nullable',
                'string',
                'max:50',
            ],

            'fields.*.text_align' => [
                'nullable',
                Rule::in([
                    'left',
                    'center',
                    'right',
                ]),
            ],

            'fields.*.visible' => [
                'nullable',
                'boolean',
            ],

            'fields.*.sort_order' => [
                'nullable',
                'integer',
            ],
        ]);


        DB::transaction(function () use ($request, $template) {

            /*
            |--------------------------------------------------------------------------
            | Remove old fields
            |--------------------------------------------------------------------------
            */

            $template->fields()->delete();


            /*
            |--------------------------------------------------------------------------
            | Save new fields
            |--------------------------------------------------------------------------
            */

            foreach ($request->fields as $index => $field) {

                IdCardTemplateField::create([

                    'template_id' => $template->id,

                    'field_type' => $field['field_type'],

                    /*
                    | Position
                    */
                    'x' => $field['x'],
                    'y' => $field['y'],

                    /*
                    | Size
                    */
                    'width' => $field['width'] ?? null,
                    'height' => $field['height'] ?? null,

                    /*
                    | Typography
                    */
                    'font_size' => $field['font_size'] ?? null,

                    'font_family' =>
                        $field['font_family'] ?? null,

                    'font_color' =>
                        $field['font_color'] ?? '#000000',

                    'font_weight' =>
                        $field['font_weight'] ?? 'normal',

                    'text_align' =>
                        $field['text_align'] ?? 'left',

                    /*
                    | Other
                    */
                    'visible' =>
                        isset($field['visible'])
                            ? (bool) $field['visible']
                            : true,

                    'sort_order' =>
                        $field['sort_order'] ?? $index,
                ]);
            }
        });


        return response()->json([
            'success' => true,
            'message' => 'ID card template saved successfully.',
        ]);
    }


    /**
     * Edit template information.
     */
    public function edit($id)
    {
        $schoolId = $this->resolveSchoolId();

        $template = IdCardTemplate::where('school_id', $schoolId)
            ->findOrFail($id);

        return view(
            'id_card_templates.edit',
            compact('template')
        );
    }


    /**
     * Update template.
     */
    public function update(Request $request, $id)
    {
        $schoolId = $this->resolveSchoolId();

        $template = IdCardTemplate::where('school_id', $schoolId)
            ->findOrFail($id);

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);


        $template->name = $request->name;


        /*
        |--------------------------------------------------------------------------
        | Replace image if uploaded
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            if (
                $template->image_path &&
                Storage::disk('public')->exists(
                    $template->image_path
                )
            ) {
                Storage::disk('public')->delete(
                    $template->image_path
                );
            }


            $image = $request->file('image');

            $imagePath = $image->store(
                'id-card-templates',
                'public'
            );


            $template->image_path = $imagePath;


            /*
            | Update dimensions
            */

            $fullPath =
                Storage::disk('public')->path($imagePath);

            $imageInfo = getimagesize($fullPath);

            if ($imageInfo) {

                $template->image_width =
                    $imageInfo[0];

                $template->image_height =
                    $imageInfo[1];
            }
        }


        $template->save();


        return redirect()
            ->route(
                'id-card-templates.designer',
                $template->id
            )
            ->with(
                'success',
                'Template updated successfully.'
            );
    }


    /**
     * Delete template.
     */
    public function destroy($id)
    {
        $schoolId = $this->resolveSchoolId();

        $template = IdCardTemplate::where('school_id', $schoolId)
            ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Delete image
        |--------------------------------------------------------------------------
        */

        if (
            $template->image_path &&
            Storage::disk('public')->exists(
                $template->image_path
            )
        ) {
            Storage::disk('public')->delete(
                $template->image_path
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Delete template
        |--------------------------------------------------------------------------
        |
        | Fields will automatically be deleted because
        | of cascadeOnDelete().
        |
        */

        $template->delete();


        return redirect()
            ->route('id-card-templates.index')
            ->with(
                'success',
                'ID card template deleted successfully.'
            );
    }


    /**
     * Activate template.
     */
    public function activate($id)
    {
        $schoolId = $this->resolveSchoolId();

        $template = IdCardTemplate::where('school_id', $schoolId)
            ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Deactivate all templates
        |--------------------------------------------------------------------------
        */

        IdCardTemplate::where('school_id', $schoolId)
            ->update([
                'is_active' => false,
            ]);


        /*
        |--------------------------------------------------------------------------
        | Activate selected template
        |--------------------------------------------------------------------------
        */

        $template->update([
            'is_active' => true,
        ]);


        return back()->with(
            'success',
            'ID card template activated successfully.'
        );
    }


    /**
     * Show student selection page to generate cards from this template.
     */
    public function selectStudents(Request $request, $id)
    {
        $schoolId = $this->resolveSchoolId();

        $template = IdCardTemplate::with('fields')
            ->where('school_id', $schoolId)
            ->findOrFail($id);

        $classes = StudentClass::where('school_id', $schoolId)
            ->orderBy('id', 'ASC')
            ->get();

        $sections = Section::selectRaw('MIN(id) as id, name')
            ->groupBy('name')
            ->orderBy('id', 'ASC')
            ->get();

        $students = Student::with(['studentClass', 'section'])
            ->where('school_id', $schoolId)
            ->when($request->filled('class_id'), function ($query) use ($request) {
                $query->where('class_id', $request->class_id);
            })
            ->when($request->filled('section_id'), function ($query) use ($request) {
                $query->where('section_id', $request->section_id);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('admission_no', 'like', "%{$search}%");
                });
            })
            ->orderBy('first_name')
            ->paginate(20)
            ->withQueryString();

        return view('id_card_templates.select-students', compact(
            'template',
            'classes',
            'sections',
            'students'
        ));
    }


    /**
     * Render printable ID cards for selected students using this template.
     */
    public function generate(Request $request, $id)
    {
        $schoolId = $this->resolveSchoolId();

        $template = IdCardTemplate::with('fields')
            ->where('school_id', $schoolId)
            ->findOrFail($id);

        $request->validate([
            'student_ids' => ['required', 'array', 'min:1'],
            'student_ids.*' => ['integer'],
        ]);

        $students = Student::with(['studentClass', 'section'])
            ->where('school_id', $schoolId)
            ->whereIn('id', $request->student_ids)
            ->orderBy('first_name')
            ->get();

        if ($students->isEmpty()) {
            return redirect()->back()->with('error', 'Please select at least one student.');
        }

        $school = School::find($schoolId);

        $students->each(function ($student) {
            $student->idcardprinted = 'yes';
            $student->save();
        });

        return response()->view('id_card_templates.generated', compact(
            'template',
            'students',
            'school'
        ))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}