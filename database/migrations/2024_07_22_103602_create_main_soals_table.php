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
        Schema::create('main_soals', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('index')->nullable();
            $table->string('judul')->nullable();
            $table->longText('konten')->nullable();
            $table->foreignUuid('master_soal_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_soals');
    }
};
