<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatDiskusiDosen extends Model
{
    use HasFactory;

    public function diskusi_dosen(): BelongsTo
    {
        return $this->belongsTo(DiskusiDosen::class);
    }

    public function pengirim(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengirim_id', 'id');
    }
}
