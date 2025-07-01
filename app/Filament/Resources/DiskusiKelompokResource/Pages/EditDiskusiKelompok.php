<?php

namespace App\Filament\Resources\DiskusiKelompokResource\Pages;

use App\Filament\Resources\DiskusiKelompokResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDiskusiKelompok extends EditRecord
{
    protected static string $resource = DiskusiKelompokResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
