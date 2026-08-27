<?php

namespace App\Http\Controllers;

use App\Models\UploadSample;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\SelectedSample;
use Illuminate\Support\Facades\Auth;

class UploadSampleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $selectedSample = null;
        $alls = collect();
        $defaultSamples = collect();
        $ownSamples = collect();
        if (session('role') === 'school') {
            $schoolId = Auth::user()->school_id;
            $selectedSample = SelectedSample::where(
                'school_id',
                $schoolId
            )->first();
            // Admin/default samples
            $defaultSamples = UploadSample::whereNull('school_id')
                ->get();
            // Samples uploaded by this school
            $ownSamples = UploadSample::where('school_id', $schoolId)
                ->get();
        } else {
            // Admin sees all samples
            $alls = UploadSample::all();
        }
        return view(
            'schools.uploadsample',
            compact(
                'alls',
                'defaultSamples',
                'ownSamples',
                'selectedSample'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('schools.createuploadsample');
    }

    /**
     * Store a newly created resource in storage.
     */
    
   
    public function store(Request $request)
    {
        $request->validate([
            'upload_samples' => 'required|image|max:40960',
            'image_name'     => 'required|string|max:255',
            'caption'        => 'nullable|string|max:255',
            'orientation'    => 'required|in:horizontal,vertical',
        ]);
        $file = $request->file('upload_samples');
        $path = $file->store('samples', 'public');

        $schoolId = session('role') === 'school'
            ? Auth::user()->school_id
            : null;

        UploadSample::create([
            'school_id'   => $schoolId,
            'name'        => $request->input('image_name'),
            'file_path'   => $path,
            'caption'     => $request->input('caption'),
            'orientation' => $request->input('orientation'),
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Sample uploaded successfully.',
            'redirect' => route('upload-samples.index'),
        ]);
    }



    /**
     * Display the specified resource.
     */
    public function show(UploadSample $uploadSample)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UploadSample $uploadSample)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UploadSample $uploadSample)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UploadSample $uploadSample)
    {
        
        Storage::disk('public')->delete($uploadSample->file_path);
        $uploadSample->delete();
        return redirect()->route('upload-samples.index')->with('success', 'Sample deleted successfully.');
    }
    public function destroyAll()
    {
        if(session('role') === 'school') {
            $samples = UploadSample::where('school_id', Auth::user()->school_id)->get();
        } else {
            $samples = UploadSample::whereNull('school_id')->get();
        }
        foreach ($samples as $sample) {
            Storage::disk('public')->delete($sample->file_path);
            $sample->delete();
        }
        return redirect()
            ->route('upload-samples.index')
            ->with('success', 'All samples deleted successfully.');
    }
}
