<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penalty_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penalty_type_id')->constrained('penalty_types')->cascadeOnDelete();
            $table->foreignId('institution_id')->constrained()->cascadeOnDelete();
            $table->decimal('rate', 8, 2);
            $table->unsignedInteger('grace_period_days')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penalty_rules');
    }
};
