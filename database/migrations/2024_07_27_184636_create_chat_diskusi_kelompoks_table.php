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
        Schema::create('chat_diskusi_kelompoks', function (Blueprint $table) {
            $table->id();
            $table->longText('isi_pesan');
            $table->foreignId('pengirim_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('diskusi_kelompok_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('chat_diskusi_kelompoks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_diskusi_kelompoks');
    }
};
