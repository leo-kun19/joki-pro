<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('appearance_settings', function (Blueprint $table) {
            $table->string('font_color')->nullable();
            $table->string('menu_background_color')->nullable();
            $table->string('submenu_background_color')->nullable();
            $table->string('menu_hover_color')->nullable();
            $table->string('menu_active_color')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('appearance_settings', function (Blueprint $table) {
            $table->dropColumn([
                'font_color',
                'menu_background_color',
                'submenu_background_color',
                'menu_hover_color',
                'menu_active_color',
            ]);
        });
    }
};
