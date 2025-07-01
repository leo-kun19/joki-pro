<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Livewire\after;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('master_materis', function (Blueprint $table) {
            $table->dropForeign(['menu_navbar_id']);
            $table->dropColumn('menu_navbar_id');
            $table->foreignId('navbar_id')->nullable()->constrained()->cascadeOnDelete()->after('konten');
            $table->foreignId('menu_navbar_id')->nullable()->constrained()->cascadeOnDelete()->after('konten');
           
        });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_materis', function (Blueprint $table) {
            //
        });
    }
};
