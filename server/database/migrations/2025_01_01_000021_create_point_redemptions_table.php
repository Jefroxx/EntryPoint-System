<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('point_redemptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('market_items')->restrictOnDelete();
            $table->unsignedInteger('points_spent');
            $table->string('fulfillment_status')->default('Pending'); // Pending, Fulfilled, Cancelled
            $table->timestamp('redeemed_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('point_redemptions');
    }
};
