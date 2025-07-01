<?php

namespace App\Filament\Resources\MainSoalResource\Pages;

use App\Filament\Resources\MainSoalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMainSoal extends EditRecord
{
    protected static string $resource = MainSoalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
