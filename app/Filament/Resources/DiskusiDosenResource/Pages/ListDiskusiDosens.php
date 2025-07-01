<?php

namespace App\Filament\Resources\DiskusiDosenResource\Pages;

use App\Filament\Resources\DiskusiDosenResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDiskusiDosens extends ListRecords
{
    protected static string $resource = DiskusiDosenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
