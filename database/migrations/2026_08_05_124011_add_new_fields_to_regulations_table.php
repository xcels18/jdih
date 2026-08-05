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
        Schema::table('regulations', function (Blueprint $table) {
            $table->string('document_type')->default('PERATURAN PERUNDANG-UNDANGAN')->after('type');
            $table->string('publishing_place')->default('KAB. PUNCAK JAYA')->after('number');
            $table->date('promulgation_date')->nullable()->after('stipulation_date');
            $table->string('gov_affairs')->nullable()->after('law_field');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('regulations', function (Blueprint $table) {
            $table->dropColumn(['document_type', 'publishing_place', 'promulgation_date', 'gov_affairs']);
        });
    }
};
