<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\MasterMateri;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MasterMateriResource\Pages;
use App\Filament\Resources\MasterMateriResource\RelationManagers;
use Filament\Forms\Get;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class MasterMateriResource extends Resource
{
    protected static ?string $model = MasterMateri::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Materi';
    protected static ?string $navigationLabel = 'Master Materi';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul')
                    ->required(),
                Forms\Components\Select::make('navbar_id')
                    ->relationship(
                        'navbar',
                        modifyQueryUsing: fn(Builder $query) => $query->where('has_materi', false)
                    )
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "( {$record->code} ) {$record->nama}")
                    ->label('Navbar')
                    ->searchable(['nama', 'code'])
                    ->preload()
                    ->live(),
                Forms\Components\Select::make('menu_navbar_id')
                    ->relationship(
                        'menu_navbar',
                        modifyQueryUsing: fn(Builder $query) => $query->where('has_materi', false)
                    )
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "( {$record->code} ) {$record->nama}")
                    ->label('Menu Navbar')
                    ->searchable(['nama', 'code'])
                    ->preload()
                    ->hidden(fn(Get $get)=>$get('navbar_id') != null),
                
                TinyEditor::make('konten')
                    ->showMenuBar()
                    ->required()
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('navbar.nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('menu_navbar.nama')
                    ->label('Menu')
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
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListMasterMateris::route('/'),
            'create' => Pages\CreateMasterMateri::route('/create'),
            'edit' => Pages\EditMasterMateri::route('/{record}/edit'),
        ];
    }
}
