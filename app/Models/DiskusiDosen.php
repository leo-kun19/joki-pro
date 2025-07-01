<?php

namespace App\Models;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\ChatDiskusiDosen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiskusiDosen extends Model
{
    use HasFactory, HasUuids;

    public function chat_diskusi_dosens(): HasMany
    {
        return $this->hasMany(ChatDiskusiDosen::class);
    }


    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class);
    }
}
