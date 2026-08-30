<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('book_categories')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('title');
            $table->string('call_number');
            $table->string('accession_number')->unique();
            $table->string('cover_image_url')->nullable();
            $table->string('shelf_location')->nullable();
            $table->unsignedInteger('total_copies')->default(1);
            // Derived/cached value — kept in sync via loan activity (app logic or trigger)
            $table->unsignedInteger('available_copies')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
