<?php

namespace App\Models;

use App\Models\Navbar;
use App\Models\MenuNavbar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterMateri extends Model
{
    use HasFactory, HasUuids;

    public function menu_navbar(): BelongsTo
    {
        return $this->belongsTo(MenuNavbar::class);
    }
    public function navbar(): BelongsTo
    {
        return $this->belongsTo(Navbar::class);
    }
}
