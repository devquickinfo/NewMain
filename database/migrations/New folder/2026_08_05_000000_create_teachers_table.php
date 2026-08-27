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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();

            $table->string('first_name');
            $table->string('last_name')->nullable();

            $table->string('address', 255)->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('phone', 20)->nullable();

            $table->string('photo')->nullable();
            $table->string('capture_background')->default('Sky Blue');
            $table->boolean('captured_by_camera')->default(false);
            $table->string('capturephoto')->nullable();
            $table->enum('idcardprinted', ['yes', 'no'])->default('no');

            $table->foreignId('school_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
