<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('admissions', 'reference_number')) {
            Schema::table('admissions', function ($table) {
                $table->string('reference_number')->nullable();
            });
        }

        // SQLite ignores ENUM constraints; the column is already TEXT.
        // Just ensure no migration issues.
    }

    public function down(): void
    {
        if (Schema::hasColumn('admissions', 'reference_number')) {
            Schema::table('admissions', function ($table) {
                $table->dropColumn('reference_number');
            });
        }
    }
};
