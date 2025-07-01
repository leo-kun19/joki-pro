<?php

namespace App\Filament\Resources\MenuPertemuanResource\Pages;

use App\Filament\Resources\MenuPertemuanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMenuPertemuans extends ListRecords
{
    protected static string $resource = MenuPertemuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
