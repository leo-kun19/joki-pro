<?php

namespace App\Models;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Jawaban;
use App\Models\Kelompok;
use App\Models\MasterFix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory, HasUuids;
    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }
    public function kelompok(): BelongsTo
    {
        return $this->belongsTo(Kelompok::class);
    }

    public function jawabans() : HasMany 
    {
        return $this->hasMany(Jawaban::class);
    }
    public function master_fixes() : HasMany 
    {
        return $this->hasMany(MasterFix::class);
    }
}
