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
        Schema::create('jawabans', function (Blueprint $table) {
            $table->id();
            $table->string('type_soal');
            $table->string('type_jawaban');
            $table->string('type_penyelesaian');
            $table->string('jawaban')->nullable();
            $table->float('bobot_nilai')->nullable()->default(0);
            $table->longText('feedback_dosen')->nullable();
            $table->boolean('is_true')->nullable();
            $table->boolean('is_fix')->default(false);
            $table->boolean('is_correct')->default(false);
            $table->integer('index_jawaban')->default(1);
            $table->foreignId('soal_id')->constrained()->onDelete('cascade');
            $table->uuid('mahasiswa_id')->nullable();
            $table->unsignedBigInteger('kelompok_id')->nullable();
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswas')->onDelete('cascade');
            $table->foreign('kelompok_id')->references('id')->on('kelompoks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawabans');
    }
};
