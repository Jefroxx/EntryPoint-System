<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained()->cascadeOnDelete();
            $table->string('first_name');
            $table->string('middle_initial', 5)->nullable();
            $table->string('last_name');
            $table->string('phone_number')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('user_type', ['student', 'librarian']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
