<?php

namespace App\Filament\Resources\MahasiswaResource\Pages;

use App\Filament\Resources\MahasiswaResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListMahasiswas extends ListRecords
{
    protected static string $resource = MahasiswaResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'active' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('is_active', true)),
            'inactive' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('is_active', false)),
        ];
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Mahasiswa'),
        ];
    }
}
