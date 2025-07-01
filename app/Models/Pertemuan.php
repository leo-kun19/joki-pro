<?php

namespace App\Models;

use App\Models\MenuPertemuan;
use App\Models\Pembelajaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pertemuan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function pembelajaran(): BelongsTo
    {
        return $this->belongsTo(Pembelajaran::class, 'pembelajaran_id', 'id');
    }
    public function menu_pertemuans(): HasMany
    {
        return $this->hasMany(MenuPertemuan::class);
    }
}
