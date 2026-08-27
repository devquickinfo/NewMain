<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('id_card_templates', function (Blueprint $table) {
            $table->id();

            // School that owns this ID card template
            $table->foreignId('school_id')
                ->constrained('schools')
                ->cascadeOnDelete();

            // Template name
            $table->string('name');

            // Uploaded ID card background image
            $table->string('image_path');

            // Original image dimensions
            $table->unsignedInteger('image_width')->nullable();
            $table->unsignedInteger('image_height')->nullable();

            // Whether this template is currently active
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('id_card_templates');
    }

};
