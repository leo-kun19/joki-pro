<?php

namespace App\Filament\Resources\PembelajaranResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PertemuansRelationManager extends RelationManager
{
    protected static string $relationship = 'pertemuans';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
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
