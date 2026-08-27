<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherListController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = Auth::user()->school_id;

        $teachersQuery = Teacher::where('school_id', $schoolId);

        if ($request->filled('idcardprinted')) {
            $teachersQuery->where('idcardprinted', $request->idcardprinted);
        }

        if ($request->teacher_photo === 'with_photo') {
            $teachersQuery->where(function ($query) {
                $query->where(function ($q) {
                    $q->whereNotNull('photo')->where('photo', '!=', '');
                })->orWhere(function ($q) {
                    $q->whereNotNull('capturephoto')->where('capturephoto', '!=', '');
                });
            });
        }

        if ($request->teacher_photo === 'without_photo') {
            $teachersQuery->where(function ($query) {
                $query->where(function ($q) {
                    $q->whereNull('photo')->orWhere('photo', '');
                })->where(function ($q) {
                    $q->whereNull('capturephoto')->orWhere('capturephoto', '');
                });
            });
        }

        $teachers = $teachersQuery->orderBy('first_name')
            ->paginate(20)
            ->withQueryString();

        return view('frontend.teacherlist', compact('teachers'));
    }
}
