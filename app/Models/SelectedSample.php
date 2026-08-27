<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SelectedSample extends Model
{
     protected $fillable = [
        'school_id',
        'sample_id',
        'orientation',
    ];
}
