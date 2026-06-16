<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tma_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('file_path')->nullable();
            $table->string('original_filename')->nullable();
            $table->integer('tma_marks')->nullable();
            $table->integer('practical_marks')->nullable();
            $table->text('admin_remarks')->nullable();
            $table->enum('status', ['submitted', 'graded'])->default('submitted');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'product_id']); // one submission per TMA per student
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tma_submissions');
    }
};
