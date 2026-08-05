<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('regulations', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // e.g., Perda, Perbup, Keputusan Bupati
            $table->string('number'); // e.g., 12, 1
            $table->integer('year'); // e.g., 2026
            $table->text('title'); // Full title of the regulation
            $table->date('stipulation_date'); // Date stipulated
            $table->enum('status', ['active', 'revoked', 'amended'])->default('active');
            $table->text('description')->nullable(); // Abstract or short summary
            $table->string('file_path')->nullable(); // PDF storage path
            $table->string('teu')->nullable(); // Tajuk Entri Utama (TEU)
            $table->string('law_field')->nullable(); // Bidang Hukum
            $table->text('subject')->nullable(); // Subjek / Kata Kunci
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regulations');
    }
};
