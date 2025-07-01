<?php

namespace App\Filament\Resources\PembelajaranResource\Pages;

use App\Filament\Resources\PembelajaranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditPembelajaran extends EditRecord
{
    protected static string $resource = PembelajaranResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
