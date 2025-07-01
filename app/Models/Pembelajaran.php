<?php

namespace App\Models;

use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Pertemuan;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pembelajaran extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'id');
    }

    public function pertemuans(): HasMany
    {
        return $this->hasMany(Pertemuan::class);
    }
}
