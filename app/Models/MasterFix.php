<?php

namespace App\Models;

use App\Models\Jawaban;
use App\Models\Kelompok;
use App\Models\MainSoal;
use App\Models\Mahasiswa;
use App\Models\MasterSoal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterFix extends Model
{
    use HasFactory;

    public function master_soal() : BelongsTo 
    {
        return $this->belongsTo(MasterSoal::class,'master_soal_id');
    }
    public function main_soal() : BelongsTo 
    {
        return $this->belongsTo(MainSoal::class,'main_soal_id');
    }

    public function mahasiswa() : BelongsTo 
    {
        return $this->belongsTo(Mahasiswa::class,'mahasiswa_id');
    }
    public function kelompok() : BelongsTo 
    {
        return $this->belongsTo(Kelompok::class,'kelompok_id');
    }
    public function jawabans() : HasMany 
    {
        return $this->hasMany(Jawaban::class);
    }
}
