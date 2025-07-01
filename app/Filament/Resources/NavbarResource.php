<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Navbar;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Guava\FilamentIconPicker\Forms\IconPicker;
use App\Filament\Resources\NavbarResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\NavbarResource\RelationManagers;
use App\Filament\Resources\NavbarResource\RelationManagers\MenuNavbarsRelationManager;

class NavbarResource extends Resource
{
    protected static ?string $model = Navbar::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Materi';
    protected static ?string $navigationLabel = 'Navbar';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                IconPicker::make('icon')
                ->preload(),
                Forms\Components\TextInput::make('nama')
                    ->required(),
                Forms\Components\TextInput::make('code')
                    ->required(),
                Forms\Components\Toggle::make('is_show')
                    ->required(),
                Forms\Components\Select::make('pembelajaran_id')
                    ->relationship('pembelajaran', 'nama'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('menu_navbars_count')
                    ->counts('menu_navbars')
                    ->label('Total Menu'),
                Tables\Columns\ToggleColumn::make('is_show'),
                Tables\Columns\TextColumn::make('pembelajaran.nama')
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
            MenuNavbarsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNavbars::route('/'),
            'create' => Pages\CreateNavbar::route('/create'),
            'edit' => Pages\EditNavbar::route('/{record}/edit'),
        ];
    }
}
