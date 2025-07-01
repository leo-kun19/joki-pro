<?php

namespace App\Filament\Resources;

use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Pertemuan;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Guava\FilamentIconPicker\Forms\IconPicker;
use App\Filament\Resources\PertemuanResource\Pages;
use App\Filament\Resources\PertemuanResource\RelationManagers\MenuPertemuansRelationManager;

class PertemuanResource extends Resource
{
    protected static ?string $model = Pertemuan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Master';
    protected static ?string $navigationLabel = 'Pertemuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                IconPicker::make('icon'),
                TextInput::make('code')
                    ->required(),
                TextInput::make('nama')
                    ->required(),
                Select::make('pembelajaran_id')
                    ->relationship('pembelajaran', 'nama')
                    ->required(),
                Toggle::make('is_show')->label('Tampilkan')
                    ->required(),

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
                Tables\Columns\TextColumn::make('pembelajaran.nama')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_show')
                    ->label('Tampilkan')
                    ->afterStateUpdated(function ($record, $state) {
                        if ($state == 1) {
                            Notification::make()
                                ->title('Pertemuan di tampilkan')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Pertemuan di sembunyikan')
                                ->warning()
                                ->send();
                        }

                    }),
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
            MenuPertemuansRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPertemuans::route('/'),
            'create' => Pages\CreatePertemuan::route('/create'),
            'edit' => Pages\EditPertemuan::route('/{record}/edit'),
        ];
    }
}
