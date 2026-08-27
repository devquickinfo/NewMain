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
        Schema::create('students', function (Blueprint $table) {

            $table->id();

            $table->string('admission_no')->unique();

            $table->string('first_name');
            $table->string('last_name')->nullable();

            $table->string('father_name')->nullable();
            $table->string('address', 255);
            $table->enum('gender', [
                'Male',
                'Female',
                'Other'
            ]);

            $table->date('date_of_birth')->nullable();

            $table->string('blood_group')->nullable();

            $table->string('phone',20)->nullable();

            $table->foreignId('class_id')
                ->constrained('student_classes')
                ->cascadeOnDelete();

            $table->foreignId('section_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('photo')->nullable();

            $table->string('capture_background')->default('Sky Blue');

            $table->boolean('captured_by_camera')->default(false);
            $table->string('capturephoto')->nullable();
            $table->enum('idcardprinted', ['yes', 'no'])->default('no');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
