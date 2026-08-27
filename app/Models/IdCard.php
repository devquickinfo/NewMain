<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class IdCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'id_card_template_id',
        'photo_path',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function template()
    {
        return $this->belongsTo(IdCardTemplate::class, 'id_card_template_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class); // adjust to your actual Student model
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo_path ? Storage::disk('public')->url($this->photo_path) : null;
    }
}
