<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppearanceSetting extends Model
{
    //
    protected $fillable = [
        'font_family',
        'font_size',
        'font_color',
        'background_color',
        'menu_background_color',
        'submenu_background_color',
        'menu_hover_color',
        'menu_active_color',
        'sidebar_position',
        'icon_path',
    ];
}
