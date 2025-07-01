<?php

namespace App\Filament\Resources\DiskusiKelompokResource\Pages;

use App\Filament\Resources\DiskusiKelompokResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDiskusiKelompoks extends ListRecords
{
    protected static string $resource = DiskusiKelompokResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
