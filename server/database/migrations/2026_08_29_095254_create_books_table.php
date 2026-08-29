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
            $table->foreignId('institution_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('book_categories')->restrictOnDelete();
            $table->string('title');
            $table->string('call_number')->nullable();
            $table->string('accession_number')->unique()->nullable();
            $table->string('cover_image_url')->nullable();
            $table->unsignedInteger('total_copies')->default(0);
            $table->unsignedInteger('available_copies')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
