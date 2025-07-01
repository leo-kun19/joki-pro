<?php

namespace App\Filament\Resources\MasterFixResource\Widgets;

use Filament\Tables;
use App\Models\MasterFix;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\DeleteAction;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestMasterFixes extends BaseWidget
{
   
    protected int | string | array $columnSpan = 'full';
   
   
    public function table(Table $table): Table
    {
        return $table
            ->query(
                MasterFix::orderBy('created_at','desc')->take(10)
            )
            ->columns([
                TextColumn::make('master_soal.menu_pertemuan.nama'),
                TextColumn::make('main_soal_judul'),
                TextColumn::make('mahasiswa.nama'),
                TextColumn::make('kelompok.nama'),
                TextColumn::make('jawabans_count')
                    ->counts('jawabans')
                    ->label('Total Jawaban'),
            ])->actions([
                DeleteAction::make(),
                Action::make('view')
                ->label('Lihat Jawaban')
                ->url(fn(Model $record):string => route('filament.admin.resources.jawabans.index',[
                   'tableFilters[menu_pertemuan][value]'=>$record->master_soal->menu_pertemuan->id,
                   'tableFilters[main_soal][value]'=>$record->main_soal->id,
                   'tableFilters[mahasiswa][value]'=>$record->mahasiswa->id ??null,
                   'tableFilters[kelompok][value]'=>$record->kelompok->id ??null,
                   'tableFilters[is_correct][value]'=> 0
                ]))
            ]);
    }
}
