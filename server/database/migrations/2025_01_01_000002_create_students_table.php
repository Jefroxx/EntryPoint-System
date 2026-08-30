<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            // 1:1 with users — student's id IS the user's id (class-table inheritance)
            $table->foreignId('id')->primary()->constrained('users')->cascadeOnDelete();
            $table->string('student_id_number')->unique();
            $table->string('barcode_value')->unique();
            $table->string('academic_program', 50)->nullable(); // e.g. BSIT, BSTM, BSHM
            $table->unsignedInteger('knowledge_score')->default(0);
            $table->unsignedInteger('visit_streak')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
