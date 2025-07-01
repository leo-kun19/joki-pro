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
            $table->boolean('is_correct')->nullable()->default(false)->after('kelompok_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_fixes', function (Blueprint $table) {
            $table->dropColumn('is_correct');
        });
    }
};
