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
        Schema::create('mainidcards', function (Blueprint $table) {
            $table->id();

            $table->foreignId('school_id')
                ->constrained('schools')
                ->cascadeOnDelete();

            $table->string('name')->default('Default ID Card');

            $table->enum('orientation', [
                'portrait',
                'landscape'
            ])->default('landscape');

            $table->integer('card_width')->default(700);
            $table->integer('card_height')->default(450);

            // Background/sample image path
            $table->string('background')->nullable();

            // All editor settings
            $table->json('layout')->nullable();

            $table->boolean('is_default')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mainidcards');
    }

};
