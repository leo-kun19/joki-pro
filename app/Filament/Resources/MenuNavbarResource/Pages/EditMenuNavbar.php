<?php

namespace App\Filament\Resources\MenuNavbarResource\Pages;

use App\Filament\Resources\MenuNavbarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMenuNavbar extends EditRecord
{
    protected static string $resource = MenuNavbarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
