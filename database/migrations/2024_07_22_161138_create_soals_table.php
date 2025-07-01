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
        Schema::create('soals', function (Blueprint $table) {
            $table->id();
            $table->integer('index');
            $table->longText('pertanyaan');
            $table->string('type_soal');
            $table->string('type_jawaban')->default('single');
            $table->string('qty_jawaban')->default(1);
            $table->string('type_penyelesaian')->default('mandiri');
            $table->longText('kunci_jawaban')->nullable();
            $table->float('bobot_nilai')->nullable()->default(0);
            $table->foreignId('main_soal_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soals');
    }
};
