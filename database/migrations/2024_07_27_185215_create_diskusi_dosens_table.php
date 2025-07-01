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
        Schema::create('diskusi_dosens', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuId('master_soal_id')->constrained()->cascadeOnDelete();
            $table->longText('catatan')->default('');
            $table->foreignUuid('mahasiswa_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('dosen_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diskusi_dosens');
    }
};
