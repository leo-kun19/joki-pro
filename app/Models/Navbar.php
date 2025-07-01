<?php

namespace App\Models;

use App\Models\MenuNavbar;
use App\Models\MasterMateri;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Navbar extends Model
{
    use HasFactory;

    public function menu_navbars(): HasMany
    {
        return $this->hasMany(MenuNavbar::class);
    }
    public function master_materi(): HasOne
    {
        return $this->hasOne(MasterMateri::class);
    }

    public function pembelajaran(): BelongsTo
    {
        return $this->belongsTo(Pembelajaran::class, 'pembelajaran_id', 'id');
    }
}
