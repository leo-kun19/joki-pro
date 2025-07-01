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
        Schema::create('menu_navbars', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('code')->unique();
            $table->boolean('has_materi')->default(false);
            $table->unsignedBigInteger('navbar_id')->nullable();
            $table->foreign('navbar_id')->references('id')->on('navbars')->onDelete('cascade');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('menu_navbars')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_navbars');
    }
};
