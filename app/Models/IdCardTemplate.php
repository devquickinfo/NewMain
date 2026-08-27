<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdCardTemplate extends Model
{
    protected $fillable = [
        'school_id',
        'name',
        'image_path',
        'image_width',
        'image_height',
        'is_active',
    ];

    public function fields()
    {
        return $this->hasMany(IdCardTemplateField::class, 'template_id')
                    ->orderBy('sort_order');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}