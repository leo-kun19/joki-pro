<?php

namespace App\Filament\Resources\MasterSoalResource\Pages;

use App\Filament\Resources\MasterSoalResource;
use App\Models\MenuPertemuan;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateMasterSoal extends CreateRecord
{
    protected static string $resource = MasterSoalResource::class;
    protected function handleRecordCreation(array $data): Model
    {
        $menu = MenuPertemuan::find($data['menu_pertemuan_id']);
        $menu->has_soal = true;
        $menu->save();
        return static::getModel()::create($data);
    }
}
