<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DiskusiKelompok;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DiskusiKelompokResource\Pages;
use App\Filament\Resources\DiskusiKelompokResource\RelationManagers;

class DiskusiKelompokResource extends Resource
{
    protected static ?string $model = DiskusiKelompok::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Chat';
    protected static ?string $navigationLabel = 'Ruang diskusi dengan kelompok';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('soal_id')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('catatan')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('jawaban')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('kelompok_id')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('soal_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kelompok.nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('Kelas')
                    ->relationship('kelompok.kelas', 'nama')
                    ->columnSpan(2)
                    ->searchable('nama'),
                Tables\Filters\SelectFilter::make('Kelompok')
                    ->relationship('kelompok', 'nama')
                    ->columnSpan(2)
                    ->searchable('nama'),

            ], layout: FiltersLayout::AboveContent)

            ->actions([
                Action::make('lihat')
                    ->url(fn(DiskusiKelompok $record): string => route('chat-diskusi', [$record->soal->main_soal->master_soal->id, $record->soal_id, $record->kelompok_id]))
                    ->openUrlInNewTab()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDiskusiKelompoks::route('/'),
            'create' => Pages\CreateDiskusiKelompok::route('/create'),
            'edit' => Pages\EditDiskusiKelompok::route('/{record}/edit'),
        ];
    }
}
