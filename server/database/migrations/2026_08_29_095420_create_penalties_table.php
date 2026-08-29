<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penalties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained('loans')->cascadeOnDelete();
            $table->foreignId('penalty_type_id')->constrained('penalty_types')->restrictOnDelete();
            $table->decimal('amount', 8, 2);
            $table->timestamp('computed_at')->nullable();
            $table->timestamp('settled_at')->nullable();
            $table->string('payment_status')->default('unpaid');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penalties');
    }
};
