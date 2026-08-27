<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'address',
        'gender',
        'date_of_birth',
        'photo',
        'capturephoto',
        'captured_by_camera',
        'capture_background',
        'idcardprinted',
        'school_id',
    ];
}
