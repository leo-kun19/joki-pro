<?php

namespace App\Filament\Resources\DiskusiDosenResource\Pages;

use App\Filament\Resources\DiskusiDosenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDiskusiDosen extends EditRecord
{
    protected static string $resource = DiskusiDosenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
