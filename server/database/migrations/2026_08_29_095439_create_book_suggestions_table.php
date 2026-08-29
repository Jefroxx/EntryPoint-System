<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_suggestions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students', 'user_id')->cascadeOnDelete();
            $table->foreignId('review_by_librarian_id')->nullable()
                ->constrained('librarians', 'user_id')->nullOnDelete();
            $table->string('title');
            $table->string('author')->nullable();
            $table->text('reason')->nullable();
            $table->string('status')->default('submitted');
            $table->string('progress_step')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_suggestions');
    }
};
