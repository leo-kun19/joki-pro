<?php

namespace App\Filament\Resources\SoalResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class PilihanJawabansRelationManager extends RelationManager
{
    protected static string $relationship = 'pilihan_jawabans';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('index')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_true'),
                TinyEditor::make('jawaban')
                    ->columnSpanFull(),
                
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('jawaban')
            ->columns([
                Tables\Columns\TextColumn::make('index'),
                Tables\Columns\TextColumn::make('jawaban')
                ->markdown(),
                Tables\Columns\ToggleColumn::make('is_true'),
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
