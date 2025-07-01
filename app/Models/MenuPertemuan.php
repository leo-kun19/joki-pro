<?php

namespace App\Models;

use App\Models\MasterSoal;
use App\Models\Pertemuan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MenuPertemuan extends Model
{
    use HasFactory;

    public function pertemuan(): BelongsTo
    {
        return $this->belongsTo(Pertemuan::class, 'pertemuan_id', 'id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function sub_menus(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function master_soal(): HasOne
    {
        return $this->hasOne(MasterSoal::class);
    }
}
