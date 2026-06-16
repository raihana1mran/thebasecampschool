<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update subject names to include the new code suffixes
        DB::table('mock_tests')->where('subject', 'Physics')->update(['subject' => 'Physics (312)']);
        DB::table('mock_tests')->where('subject', 'Biology')->update(['subject' => 'Biology (314)']);
        DB::table('mock_tests')->where('subject', 'Science')->update(['subject' => 'Science & Technology (212)']);
        DB::table('mock_tests')->where('subject', 'Mathematics')->where('class_standard', '10th')->update(['subject' => 'Mathematics (211)']);
        DB::table('mock_tests')->where('subject', 'Mathematics')->where('class_standard', '12th')->update(['subject' => 'Mathematics (311)']);
        
        // Specifically fix the seeded "Complete Physics Test" which was created with subject "General"
        DB::table('mock_tests')->where('title', 'like', '%Physics%')->where('subject', 'General')->update(['subject' => 'Physics (312)']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert subject names
        DB::table('mock_tests')->where('subject', 'Physics (312)')->update(['subject' => 'Physics']);
        DB::table('mock_tests')->where('subject', 'Biology (314)')->update(['subject' => 'Biology']);
        DB::table('mock_tests')->where('subject', 'Science & Technology (212)')->update(['subject' => 'Science']);
        DB::table('mock_tests')->where('subject', 'Mathematics (211)')->update(['subject' => 'Mathematics']);
        DB::table('mock_tests')->where('subject', 'Mathematics (311)')->update(['subject' => 'Mathematics']);
    }
};
