<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembelajaranResource\Pages;
use App\Filament\Resources\PembelajaranResource\RelationManagers\PertemuansRelationManager;
use App\Models\Pembelajaran;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PembelajaranResource extends Resource
{
    protected static ?string $model = Pembelajaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Master';
    protected static ?string $navigationLabel = 'Pembelajaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('nama')
                            ->required(),
                        TextInput::make('code')
                            ->required(),
                        Select::make('dosen_id')
                            ->required()
                            ->relationship(name: 'dosen', titleAttribute: 'nama'),
                        Select::make('kelas_id')
                            ->required()
                            ->relationship(name: 'kelas', titleAttribute: 'nama'),
                    ]),

            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dosen.nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kelas.nama')
                    ->numeric()
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            PertemuansRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPembelajarans::route('/'),
            'create' => Pages\CreatePembelajaran::route('/create'),
            'edit' => Pages\EditPembelajaran::route('/{record}/edit'),
        ];
    }
}
