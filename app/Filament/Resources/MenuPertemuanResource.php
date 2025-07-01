<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Tables\Table;
use App\Models\MenuPertemuan;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Builder;
use Guava\FilamentIconPicker\Forms\IconPicker;
use App\Filament\Resources\MenuPertemuanResource\Pages;

class MenuPertemuanResource extends Resource
{
    protected static ?string $model = MenuPertemuan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Master';
    protected static ?string $navigationLabel = 'Menu Pertemuan';
    protected static ?string $navigationParentItem = 'Pertemuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                IconPicker::make('icon')
                ->preload(),
                Forms\Components\TextInput::make('code')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('parent_id')
                    ->relationship(
                        'parent',
                        modifyQueryUsing: fn(Builder $query) => $query->where('parent_id', null)
                    )
                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "( {$record->code} ) {$record->nama}")
                    ->searchable(['nama', 'code'])
                    ->required()
                    ->preload()
                    ->hidden(fn (?Model $record , Page $livewire) => $record?->parent_id == null && $livewire instanceof EditRecord),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pertemuan.nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent.nama'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenuPertemuans::route('/'),
            'create' => Pages\CreateMenuPertemuan::route('/create'),
            'edit' => Pages\EditMenuPertemuan::route('/{record}/edit'),
        ];
    }
}