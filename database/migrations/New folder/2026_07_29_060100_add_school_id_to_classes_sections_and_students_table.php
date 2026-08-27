<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_classes', function (Blueprint $table) {
            $table->foreignId('school_id')
                ->nullable()
                ->after('id')
                ->constrained()
                ->nullOnDelete();
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->foreignId('school_id')
                ->nullable()
                ->after('id')
                ->constrained()
                ->nullOnDelete();
        });

        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('school_id')
                ->nullable()
                ->after('id')
                ->constrained()
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropConstrainedForeignId('school_id');
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->dropConstrainedForeignId('school_id');
        });

        Schema::table('student_classes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('school_id');
        });
    }
};