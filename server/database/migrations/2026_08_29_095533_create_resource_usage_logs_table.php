<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resource_usage_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('res_id')->constrained('resources')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students', 'user_id')->cascadeOnDelete();
            $table->foreignId('staff_librarian_id')->nullable()
                ->constrained('librarians', 'user_id')->nullOnDelete();
            $table->timestamp('used_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resource_usage_logs');
    }
};
