<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            if (! Schema::hasColumn('sections', 'class_id')) {
                $table->foreignId('class_id')->nullable()->after('id')
                    ->constrained('student_classes')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            if (Schema::hasColumn('sections', 'class_id')) {
                $table->dropConstrainedForeignId('class_id');
            }
        });
    }
};
