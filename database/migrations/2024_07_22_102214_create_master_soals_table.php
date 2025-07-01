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
        Schema::create('master_soals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->integer('durasi_jam')->nullable();
            $table->integer('durasi_menit')->nullable();
            $table->integer('durasi_detik')->nullable();
            $table->boolean('show_kunci_jawaban')->default(false);
            $table->boolean('show_bobot_nilai')->default(false);
            $table->unsignedBigInteger('menu_pertemuan_id')->unsigned();
            $table->foreign('menu_pertemuan_id')->references('id')->on('menu_pertemuans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_soals');
    }
};
