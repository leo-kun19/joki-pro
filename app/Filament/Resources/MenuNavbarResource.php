<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Pages\Page;
use App\Models\MenuNavbar;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Builder;
use Guava\FilamentIconPicker\Forms\IconPicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MenuNavbarResource\Pages;
use App\Filament\Resources\MenuNavbarResource\RelationManagers;

class MenuNavbarResource extends Resource
{
    protected static ?string $model = MenuNavbar::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Materi';
    protected static ?string $navigationLabel = 'Menu Navbar';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationParentItem = 'Navbar';


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
                Forms\Components\Select::make('navbar_id')
                    ->live()
                    ->relationship(
                        'navbar',
                        modifyQueryUsing: fn(Builder $query) => $query->where('is_show', true)
                    )
                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "( {$record->code} ) {$record->nama}")
                    ->searchable(['nama', 'code'])
                    ->preload()
                    ->hidden(function(Get $get, Set $set){
                        if($get('parent_id') != null){
                            $set('navbar_id', null);
                            return true;
                        }
                    }),
                Forms\Components\Select::make('parent_id')
                    ->live()
                    ->relationship(
                        'parent',
                        modifyQueryUsing: fn(Builder $query) => $query->where('parent_id', null)
                    )
                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "( {$record->code} ) {$record->nama}")
                    ->searchable(['nama', 'code'])
                    ->preload()
                    ->hidden(function(Get $get, Set $set){
                        if($get('navbar_id') != null){
                            $set('parent_id', null);
                            return true;
                        }
                    }
                    ),
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
                Tables\Columns\TextColumn::make('parent.nama')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenuNavbars::route('/'),
            'create' => Pages\CreateMenuNavbar::route('/create'),
            'edit' => Pages\EditMenuNavbar::route('/{record}/edit'),
        ];
    }
}
