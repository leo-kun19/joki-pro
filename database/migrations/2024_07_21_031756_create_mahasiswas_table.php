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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('nim')->unique();
            $table->string('angkatan');
            $table->string('program_studi');
            $table->string('email')->unique();
            $table->string('no_wa');
            $table->string('pas_photo')->nullable();
            $table->boolean('is_active')->default(false);
            $table->string('kode_verifikasi')->nullable();
            $table->unsignedBigInteger('kelas_id')->nullable();
            $table->unsignedBigInteger('kelompok_id')->nullable();
            $table->foreign('kelas_id')->references('id')->on('kelas')->nullOnDelete();
            $table->foreign('kelompok_id')->references('id')->on('kelompoks')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
