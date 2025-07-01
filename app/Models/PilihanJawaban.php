<?php

namespace App\Models;

use App\Models\Soal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PilihanJawaban extends Model
{
    use HasFactory;

    protected $casts = [
        'is_true' => 'boolean',
    ];

    public function soal() :BelongsTo 
    {
        return $this->belongsTo(Soal::class);
    }
}
