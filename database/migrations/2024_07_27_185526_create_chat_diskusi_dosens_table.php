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
        Schema::create('chat_diskusi_dosens', function (Blueprint $table) {
            $table->id();
            $table->longText('isi_pesan');
            $table->boolean('is_pinned')->default(false);
            $table->foreignid('pengirim_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('diskusi_dosen_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_diskusi_dosens');
    }
};
