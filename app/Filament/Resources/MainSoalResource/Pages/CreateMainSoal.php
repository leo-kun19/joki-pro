<?php

namespace App\Filament\Resources\MainSoalResource\Pages;

use App\Filament\Resources\MainSoalResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateMainSoal extends CreateRecord
{
    protected static string $resource = MainSoalResource::class;

    protected function handleRecordCreation(array $data): Model
    {

        return static::getModel()::create($data);
    }
}
