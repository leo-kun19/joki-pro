<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DiskusiDosen;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DiskusiDosenResource\Pages;
use App\Filament\Resources\DiskusiDosenResource\RelationManagers;
use Filament\Forms\Get;

class DiskusiDosenResource extends Resource
{
    protected static ?string $model = DiskusiDosen::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Chat';
    protected static ?string $navigationLabel = 'Ruang diskusi dengan dosen';
    protected static ?int $navigationSort = 1;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('master_soal_id')
                    ->required(),
                Forms\Components\Textarea::make('catatan')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('mahasiswa_id')
                    ->required(),
                Forms\Components\TextInput::make('dosen_id')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mahasiswa.nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dosen.nama')
                    ->searchable(),
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
                Action::make('lihat')
                    ->url(fn(DiskusiDosen $record): string => route('chat-dosen', [$record->master_soal_id, $record->mahasiswa_id]))
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
            'index' => Pages\ListDiskusiDosens::route('/'),
            'create' => Pages\CreateDiskusiDosen::route('/create'),
            'edit' => Pages\EditDiskusiDosen::route('/{record}/edit'),
        ];
    }
}
