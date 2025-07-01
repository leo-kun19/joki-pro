<?php

namespace App\Models;

use App\Models\Soal;
use App\Models\Kelompok;
use App\Models\Mahasiswa;
use App\Models\MasterFix;
use App\Models\JawabanDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jawaban extends Model
{
    use HasFactory;


    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function kelompok(): BelongsTo
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id');
    }

    public function soal(): BelongsTo
    {
        return $this->belongsTo(Soal::class,'soal_id');
    }

    public function master_fix(): BelongsTo
    {
        return $this->belongsTo(MasterFix::class, 'master_fix_id');
    }
}
