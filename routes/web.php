<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\StudentListController;
use App\Http\Controllers\Backend\TeacherListController;
use App\Http\Controllers\Backend\TeacherController;
use App\Http\Controllers\Backend\IdCardController;
use App\Http\Controllers\Backend\LoginController;
use App\Http\Controllers\Backend\StudentController;
use App\Http\Controllers\Backend\SchoolController;
use App\Http\Controllers\Backend\StudentImportController;
use App\Http\Controllers\UploadSampleController;
use App\Http\Controllers\IdCardTemplateController;
use App\Http\Controllers\MainidcardController;

Route::get('/check', function () {
    return view('check');
});

Route::get('/', function () {
    return view('frontend.login');
})->name('login');
Route::middleware('guest')->group(function () {
Route::post('/', [LoginController::class, 'login'])->name('user.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('user.logout');
    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
    Route::resource('students', StudentController::class);
    Route::get('/school/classes', [StudentController::class, 'schoolClasses'])->name('school.classes');
    Route::get('/school/classes/{classId}/sections/{sectionId}/students', [StudentController::class, 'classSectionStudents'])->name('school.class.section.students');
    Route::get('/schools/{school}/classes/{class}/students', [StudentController::class, 'classStudents'])->name('schools.classes.students');
    Route::get('/sections/{class}', [StudentController::class, 'getSections'])
    ->name('sections.byClass');

    Route::get('/school/profile', [SchoolController::class, 'profile'])->name('school.profile');
    Route::post('/school/profile', [SchoolController::class, 'updateProfile'])->name('school.profile.update');
    Route::get('/admin/profile', [SchoolController::class, 'profileAdmin'])->name('admin.profile');
    Route::post('/admin/profile', [SchoolController::class, 'updateProfileAdmin'])->name('admin.profile.update');
    Route::resource('schools',SchoolController::class);

    Route::get('/student/import',
        [StudentImportController::class,'index'])
        ->name('student.import');

    Route::post('/student/import',
        [StudentImportController::class,'store'])
        ->name('student.import.store');

    Route::get('/student/sample',
        [StudentImportController::class,'downloadSample'])
        ->name('student.sample');

    Route::get('/student/dynamic-sample',
        [StudentImportController::class,'downloadDynamicSample'])
        ->name('student.dynamic.sample');
    Route::get('/id-card/create', [IdCardController::class, 'index'])
    ->name('idcard.create');
    Route::get('/idcard/search-students', [IdCardController::class, 'searchStudents']) 
    ->name('idcard.search.students');
    Route::post('/idcard/generate', [IdCardController::class, 'generate'])
    ->name('idcard.generate');
    Route::get('/student/list', [StudentListController::class, 'index'])
    ->name('student.list');
    Route::get('/teacher/list', [TeacherListController::class, 'index'])
    ->name('teacher.list');
    Route::resource('teachers', TeacherController::class);
    Route::resource('upload-samples', UploadSampleController::class);
    Route::delete('/upload-sample/all',[UploadSampleController::class, 'destroyAll'])->name('upload-sample.destroyAll');
    Route::post('/save-sample',[SchoolController::class, 'saveSample'])->name('selected-samples.store');
    Route::post('/student/{student}/capture-photo', [StudentController::class, 'capturePhoto'])
    ->name('student.capture-photo');
    Route::get('/student/{student}/cardstatus', [StudentController::class, 'cardStatus'])
    ->name('student.cardstatus');
    route::get('/student/deleted', [StudentListController::class, 'deletedStudents'])
    ->name('student.deleted');
    route::post('/student/{student}/restore', [StudentListController::class, 'restoreStudent'])
    ->name('student.restore');




    Route::get('/id-card-templates', 
        [IdCardTemplateController::class, 'index']
    )->name('id-card-templates.index');

    Route::get('/id-card-templates/create', 
        [IdCardTemplateController::class, 'create']
    )->name('id-card-templates.create');

    Route::post('/id-card-templates', 
        [IdCardTemplateController::class, 'store']
    )->name('id-card-templates.store');

    Route::get('/id-card-templates/{template}/designer', 
        [IdCardTemplateController::class, 'designer']
    )->name('id-card-templates.designer');

    Route::post('/id-card-templates/{template}/fields', 
        [IdCardTemplateController::class, 'saveFields']
    )->name('id-card-templates.save-fields');

    Route::get('/id-card-templates/{template}/edit', 
        [IdCardTemplateController::class, 'edit']
    )->name('id-card-templates.edit');

    Route::put('/id-card-templates/{template}', 
        [IdCardTemplateController::class, 'update']
    )->name('id-card-templates.update');

    Route::delete('/id-card-templates/{template}', 
        [IdCardTemplateController::class, 'destroy']
    )->name('id-card-templates.destroy');

    Route::post('/id-card-templates/{template}/activate', 
        [IdCardTemplateController::class, 'activate']
    )->name('id-card-templates.activate');

    Route::get('/id-card-templates/{template}/students', 
        [IdCardTemplateController::class, 'selectStudents']
    )->name('id-card-templates.students');

    Route::post('/id-card-templates/{template}/generate', 
        [IdCardTemplateController::class, 'generate']
    )->name('id-card-templates.generate');
    Route::get('idcard-editor', [IdCardController::class, 'editIDCard'])->name('idcard.editor');

    Route::post('/mainidcard/save',[MainidcardController::class, 'store'])->name('mainidcard.store');
     //user upload id card from editor
    Route::post('/id-card/upload-design', [IDCardController::class, 'uploadDesign'])
    ->name('id-card.upload-design');

});
