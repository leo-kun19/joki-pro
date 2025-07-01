<?php

namespace App\Filament\Resources\NavbarResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Guava\FilamentIconPicker\Forms\IconPicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class MenuNavbarsRelationManager extends RelationManager
{
    protected static string $relationship = 'menu_navbars';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                IconPicker::make('icon'),
                Forms\Components\TextInput::make('nama')
                    ->required(),
                Forms\Components\TextInput::make('code')
                    ->required(),
                // Forms\Components\Select::make('parent_id')
                //     ->relationship(
                //         'parent',
                //         modifyQueryUsing: fn(Builder $query) => $query->where('parent_id', null)
                //     )
                //     ->getOptionLabelFromRecordUsing(fn(Model $record) => "( {$record->code} ) {$record->nama}")
                //     ->searchable(['nama', 'code'])
                //     ->preload(),
            ])->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns([
                Tables\Columns\TextColumn::make('code'),
                Tables\Columns\TextColumn::make('nama')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
