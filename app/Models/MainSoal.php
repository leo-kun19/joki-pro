<?php

namespace App\Models;

use App\Models\Soal;
use App\Models\MasterSoal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class MainSoal extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function master_soal(): BelongsTo
    {
        return $this->belongsTo(MasterSoal::class, 'master_soal_id');
    }

    public function master_fixes(): HasMany
    {
        return $this->hasMany(MasterFix::class);
    }

    public function soals() :HasMany 
    {
        return $this->hasMany(Soal::class);
    }
}
