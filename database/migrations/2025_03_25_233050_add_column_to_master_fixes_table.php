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
        Schema::table('master_fixes', function (Blueprint $table) {
            $table->string('main_soal_judul')->default('')->after('master_soal_id');
            $table->foreignId('main_soal_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_fixes', function (Blueprint $table) {
            $table->dropColumn('main_soal_judul');
            $table->dropForeign('main_soal_id');
        });
    }
};
