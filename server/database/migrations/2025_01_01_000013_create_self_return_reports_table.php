<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('self_return_reports', function (Blueprint $table) {
            $table->id();
            // 1:1 (optional) with loans — a loan has at most one self-return report
            $table->foreignId('loan_id')->unique()->constrained('loans')->cascadeOnDelete();
            $table->foreignId('verified_by_librarian_id')->nullable()
                ->constrained('librarians')->nullOnDelete();
            $table->timestamp('reported_at')->useCurrent();
            $table->string('verification_status')->default('Pending'); // Pending, Verified, Disputed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('self_return_reports');
    }
};
