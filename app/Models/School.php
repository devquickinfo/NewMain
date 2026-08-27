<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Mainidcard;

class School extends Model
{
    protected $fillable = [

        'school_name',
        'school_code',
        'email',
        'principal_name',
        'phone',
        'address',
        'city',
        'state',
        'pincode',
        'logo',
        'status',
        'principal_signature',

    ];
    public function mainidcards()
    {
        return $this->hasMany(Mainidcard::class);
    }
}
