<?php

namespace App\Filament\Resources\MenuPertemuanResource\Pages;

use App\Filament\Resources\MenuPertemuanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMenuPertemuan extends EditRecord
{
    protected static string $resource = MenuPertemuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
