<?php

namespace App\Models;

use App\Models\Jawaban;
use App\Models\PilihanJawaban;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\MainSoal;

class Soal extends Model
{
    use HasFactory;

    public function pilihan_jawabans(): HasMany
    {
        return $this->hasMany(PilihanJawaban::class);
    }
    public function jawabans(): HasMany
    {
        return $this->hasMany(Jawaban::class);
    }
    public function main_soal(): BelongsTo
    {
        return $this->belongsTo(MainSoal::class, 'main_soal_id');
    }
}
