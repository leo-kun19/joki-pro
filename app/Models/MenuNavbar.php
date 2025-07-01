<?php

namespace App\Models;

use App\Models\Navbar;
use App\Models\MasterMateri;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuNavbar extends Model
{
    use HasFactory;

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function navbar(): BelongsTo
    {
        return $this->belongsTo(Navbar::class, 'navbar_id','id');
    }

    public function sub_menus(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function master_materi(): HasOne
    {
        return $this->hasOne(MasterMateri::class);
    }
}
