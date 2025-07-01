<?php

namespace App\Models;

use App\Models\MainSoal;
use App\Models\MenuPertemuan;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use LaravelLang\Lang\Plugins\UI\Master;

class MasterSoal extends Model
{
    use HasFactory, HasUuids;
    protected $guarded = ['id'];

    public function menu_pertemuan(): BelongsTo
    {
        return $this->belongsTo(MenuPertemuan::class);
    }

    public function main_soals(): HasMany
    {
        return $this->hasMany(MainSoal::class);
    }
    public function master_fixes(): HasMany
    {
        return $this->hasMany(MasterFix::class);
    }
    
    public function kelasPembahasan()
    {
        return $this->belongsToMany(Kelas::class, 'master_soal_kelas');
    }
}
