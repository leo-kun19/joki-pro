<?php

namespace App\Models;

use App\Models\Kelompok;
use App\Models\Mahasiswa;
use App\Models\Pembelajaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function kelompoks(): HasMany
    {
        return $this->hasMany(Kelompok::class);
    }
    public function mahasiswas(): HasMany
    {
        return $this->hasMany(Mahasiswa::class);
    }
    public function pembelajaran(): HasMany
    {
        return $this->hasMany(Pembelajaran::class);
    }

}
