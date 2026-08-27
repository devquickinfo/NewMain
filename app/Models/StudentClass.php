<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\Section;

class StudentClass extends Model
{
    protected $fillable = [
        'name',
        'school_id'
    ];

    protected $table = 'student_classes';


    public function students()
    {
        return $this->hasMany(Student::class,'class_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class,'class_id');
    }
}
