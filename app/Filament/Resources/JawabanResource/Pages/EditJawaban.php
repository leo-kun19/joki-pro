<?php

namespace App\Filament\Resources\JawabanResource\Pages;

use App\Filament\Resources\JawabanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJawaban extends EditRecord
{
    protected static string $resource = JawabanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
