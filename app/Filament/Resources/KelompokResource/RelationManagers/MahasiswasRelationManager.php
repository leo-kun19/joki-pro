<?php

namespace App\Filament\Resources\KelompokResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class MahasiswasRelationManager extends RelationManager
{
    protected static string $relationship = 'mahasiswas';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required(),
                Forms\Components\TextInput::make('nim')
                    ->required(),
                Forms\Components\TextInput::make('angkatan')
                    ->required(),
                Forms\Components\TextInput::make('program_studi')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrated(fn($state) => filled($state))
                    ->revealable()
                    ->required(fn(string $context): bool => $context === 'create'),
                Forms\Components\TextInput::make('no_wa')
                    ->required(),
                Forms\Components\FileUpload::make('pas_photo'),
                Forms\Components\Select::make('kelas_id')
                    ->relationship('kelas', 'nama'),
                Forms\Components\Select::make('kelompok_id')
                    ->relationship('kelompok', 'nama')
                    ->searchable(['nama', 'code']),
                Forms\Components\Toggle::make('is_active'),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns([
                Tables\Columns\TextColumn::make('nim')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('angkatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('program_studi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_wa')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('pas_photo')
                    ->circular(),
                Tables\Columns\TextColumn::make('kelas.nama'),

                Tables\Columns\TextColumn::make('kelompok.nama'),

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
            ->headerActions([
                // Tables\Actions\CreateAction::make(),

            ])

            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
