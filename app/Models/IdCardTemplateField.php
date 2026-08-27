<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdCardTemplateField extends Model
{
    protected $fillable = [
        'template_id',
        'field_type',
        'x',
        'y',
        'width',
        'height',
        'font_size',
        'font_family',
        'font_color',
        'font_weight',
        'text_align',
        'visible',
        'sort_order',
    ];

    public function template()
    {
        return $this->belongsTo(IdCardTemplate::class, 'template_id');
    }
}