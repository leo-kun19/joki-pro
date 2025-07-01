<?php

namespace App\Filament\Resources\MenuPertemuanResource\Pages;

use App\Filament\Resources\MenuPertemuanResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateMenuPertemuan extends CreateRecord
{
    protected static string $resource = MenuPertemuanResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return static::getModel()::create($data);
    }
}
