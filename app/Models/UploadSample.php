<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadSample extends Model
{
     protected $fillable = [
        'name',
        'file_path',
        'caption', 'orientation','school_id',
    ];
}
