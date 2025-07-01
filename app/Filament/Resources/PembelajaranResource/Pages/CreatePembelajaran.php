<?php

namespace App\Filament\Resources\PembelajaranResource\Pages;

use App\Filament\Resources\PembelajaranResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;


class CreatePembelajaran extends CreateRecord
{
    protected static string $resource = PembelajaranResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return static::getModel()::create($data);
    }
}
