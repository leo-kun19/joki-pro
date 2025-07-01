<?php

namespace App\Models;

use App\Models\Soal;
use App\Models\Kelompok;
use App\Models\ChatDiskusiKelompok;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiskusiKelompok extends Model
{
    use HasFactory, HasUuids;

    public function chat_diskusi_kelompoks(): HasMany
    {
        return $this->hasMany(ChatDiskusiKelompok::class);
    }
    public function soal(): BelongsTo
    {
        return $this->belongsTo(Soal::class);
    }
    public function kelompok(): BelongsTo
    {
        return $this->belongsTo(Kelompok::class);
    }
}
