<?php

namespace App\Filament\Resources\SoalResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Jawaban;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class JawabansRelationManager extends RelationManager
{
    protected static string $relationship = 'jawabans';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TinyEditor::make('jawaban_detail.jawaban')
                    ->columnSpanFull()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('jawaban')
            ->columns([
                Tables\Columns\TextColumn::make('mahasiswa.nama'),
                Tables\Columns\TextColumn::make('mahasiswa.nim')
                    ->markdown()
                    ->limit(30),
                Tables\Columns\TextColumn::make('bobot_nilai')
                    ->markdown()
                    ->limit(30),
                Tables\Columns\IconColumn::make('is_true')->boolean(),
                Tables\Columns\TextColumn::make('index_jawaban'),
                Tables\Columns\ToggleColumn::make('is_correct'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('Mahasiswa')
                    ->relationship('mahasiswa', 'nama')
                    ->searchable('nama', 'nim'),
                Tables\Filters\SelectFilter::make('Kelompok')
                    ->relationship('kelompok', 'nama')
                    ->searchable('nama'),
                Tables\Filters\SelectFilter::make('type_soal')
                    ->options([
                        'esai' => 'Soal Esai',
                        'ganda' => 'Pilihan Ganda',
                    ]),
                Tables\Filters\SelectFilter::make('type_jawaban')
                    ->options([
                        'single' => 'Jawaban Single',
                        'multi' => 'Jawaban Multi',
                    ]),
                Tables\Filters\SelectFilter::make('type_penyelesaian')
                    ->options([
                        'mandiri' => 'Mandiri',
                        'kelompok' => 'Kelompok',
                    ]),
            ], layout: FiltersLayout::AboveContent)
            ->headerActions([])
            ->actions([
                Tables\Actions\EditAction::make('feedback_dosen')
                    ->form([
                        TinyEditor::make('feedback_dosen')->columnSpanFull(),
                        TextInput::make('bobot_nilai')
                            ->numeric()
                            ->maxValue(100),
                    ])
                    ->label('Koreksi')
                    ->recordTitle('Feedback Dosen'),
                Tables\Actions\ViewAction::make()
                    ->label('Lihat Jawaban')
                    ->form([
                        TinyEditor::make('jawaban'),
                    ])->recordTitle('Jawaban')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
