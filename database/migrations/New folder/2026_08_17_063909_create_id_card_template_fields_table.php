<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('id_card_template_fields', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Template
            |--------------------------------------------------------------------------
            */

            $table->foreignId('template_id')
                ->constrained('id_card_templates')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Field Type
            |--------------------------------------------------------------------------
            |
            | Examples:
            | logo
            | school_name
            | student_photo
            | student_name
            | father_name
            | admission_no
            | class
            | section
            | dob
            | gender
            | blood_group
            | phone
            | address
            |
            */

            $table->string('field_type');


            /*
            |--------------------------------------------------------------------------
            | Position
            |--------------------------------------------------------------------------
            |
            | Store percentages instead of pixels.
            |
            | Example:
            | x = 25.50
            | y = 60.20
            |
            */

            $table->decimal('x', 8, 3)->default(0);
            $table->decimal('y', 8, 3)->default(0);


            /*
            |--------------------------------------------------------------------------
            | Size
            |--------------------------------------------------------------------------
            */

            $table->decimal('width', 8, 3)->nullable();
            $table->decimal('height', 8, 3)->nullable();


            /*
            |--------------------------------------------------------------------------
            | Text Styling
            |--------------------------------------------------------------------------
            */

            $table->decimal('font_size', 8, 2)->nullable();

            $table->string('font_family')
                ->nullable();

            $table->string('font_color')
                ->default('#000000');

            $table->string('font_weight')
                ->default('normal');

            $table->string('text_align')
                ->default('left');


            /*
            |--------------------------------------------------------------------------
            | Extra Options
            |--------------------------------------------------------------------------
            */

            $table->boolean('visible')
                ->default(true);

            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Index
            |--------------------------------------------------------------------------
            */

            $table->index(['template_id', 'field_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('id_card_template_fields');
    }
};