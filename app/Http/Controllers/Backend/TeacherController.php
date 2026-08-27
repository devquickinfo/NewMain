<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::latest()->paginate(10);

        return view('frontend.addteacher', compact('teachers'));
    }

    public function create()
    {
        $teachers = Teacher::latest()->paginate(10);
        return view('frontend.addteacher', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'date_of_birth' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $photo = null;
        $capturePhoto = null;
        $capturedByCamera = false;

        if ($request->filled('photo_data')) {
            $image = preg_replace('/^data:image\/\w+;base64,/', '', $request->photo_data);
            $image = str_replace(' ', '+', $image);
            $imageName = time() . '.png';
            Storage::disk('public')->put('capture-photo/' . $imageName, base64_decode($image));
            $capturePhoto = 'capture-photo/' . $imageName;
            $capturedByCamera = true;
        }

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('teacher-photo', 'public');
        }

        Teacher::create([
            'school_id' => Auth::user()->school_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'phone' => $request->phone,
            'photo' => $photo,
            'capturephoto' => $capturePhoto,
            'capture_background' => $request->capture_background ?? 'Sky Blue',
            'captured_by_camera' => $capturedByCamera,
        ]);

        return redirect()->route('teachers.index')->with('success', 'Teacher created successfully.');
    }

    public function edit(string $id)
    {
        $teacher = Teacher::findOrFail($id);
        $teachers = Teacher::latest()->paginate(10);
        return view('frontend.addteacher', compact('teacher', 'teachers'));
    }

    public function update(Request $request, string $id)
    {
        $teacher = Teacher::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'date_of_birth' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $photo = $teacher->photo;
        $capturePhoto = $teacher->capturephoto;
        $capturedByCamera = $teacher->captured_by_camera;

        if ($request->filled('photo_data')) {
            if ($capturePhoto && Storage::disk('public')->exists($capturePhoto)) {
                Storage::disk('public')->delete($capturePhoto);
            }

            $image = preg_replace('/^data:image\/\w+;base64,/', '', $request->photo_data);
            $image = str_replace(' ', '+', $image);
            $imageName = time() . '.png';
            Storage::disk('public')->put('capture-photo/' . $imageName, base64_decode($image));
            $capturePhoto = 'capture-photo/' . $imageName;
            $capturedByCamera = true;
        } elseif ($request->hasFile('photo')) {
            if ($photo && Storage::disk('public')->exists($photo)) {
                Storage::disk('public')->delete($photo);
            }
            $photo = $request->file('photo')->store('teacher-photo', 'public');
            $capturedByCamera = false;
        }

        $teacher->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'phone' => $request->phone,
            'photo' => $photo,
            'capturephoto' => $capturePhoto,
            'capture_background' => $request->capture_background ?? 'Sky Blue',
            'captured_by_camera' => $capturedByCamera,
        ]);

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy(string $id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}
