<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('librarians', function (Blueprint $table) {
            // 1:1 with users — librarian's id IS the user's id (class-table inheritance)
            $table->foreignId('id')->primary()->constrained('users')->cascadeOnDelete();
            $table->string('role')->default('librarian');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('librarians');
    }
};
