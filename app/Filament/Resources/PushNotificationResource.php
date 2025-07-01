<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Kelas;
use Filament\Forms\Get;
use App\Models\Kelompok;
use Filament\Forms\Form;
use App\Models\Mahasiswa;
use Filament\Tables\Table;
use App\Models\PushNotification;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PushNotificationResource\Pages;
use App\Filament\Resources\PushNotificationResource\RelationManagers;
use App\Filament\Resources\PushNotificationResource\RelationManagers\UsersRelationManager;

class PushNotificationResource extends Resource
{
    protected static ?string $model = PushNotification::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Fieldset::make('Send To')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Select::make('kelas')
                            ->multiple()
                            ->placeholder('All')
                            ->disabled(fn(Get $get)=>$get('kelompok')!= null || $get('mahasiswa')!= null)
                            ->live()
                            ->preload()
                            ->getSearchResultsUsing(fn (string $search): array => Kelas::where('nama', 'like', "%{$search}%")->limit(50)->pluck('nama', 'id')->toArray())
                            ->getOptionLabelsUsing(fn (array $values): array => Kelas::whereIn('id', $values)->pluck('nama', 'id')->toArray()),
                        Forms\Components\Select::make('kelompok')
                            ->multiple()
                            ->placeholder('All')
                            ->disabled(fn(Get $get)=>$get('kelas')!= null || $get('mahasiswa')!= null)
                            ->live()
                            ->preload()
                            ->getSearchResultsUsing(fn (string $search): array => Kelompok::where('nama', 'like', "%{$search}%")->limit(50)->pluck('nama', 'id')->toArray())
                            ->getOptionLabelsUsing(fn (array $values): array => Kelompok::whereIn('id', $values)->pluck('nama', 'id')->toArray()),
                        Forms\Components\Select::make('mahasiswa')
                            ->multiple()
                            ->placeholder('All')
                            ->disabled(fn(Get $get)=>$get('kelas')!= null || $get('kelompok')!= null)
                            ->live()
                            ->preload()
                            ->getSearchResultsUsing(fn (string $search): array => Mahasiswa::where('nama', 'like', "%{$search}%")->limit(50)->pluck('nama', 'id')->toArray())
                            ->getOptionLabelsUsing(fn (array $values): array => Mahasiswa::whereIn('id', $values)->pluck('nama', 'id')->toArray()),
                    
                    ]),
                Forms\Components\Textarea::make('body')
                    ->required(),
                Forms\Components\FileUpload::make('image')
                    ->image(),
               
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('body')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
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
            UsersRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPushNotifications::route('/'),
            'create' => Pages\CreatePushNotification::route('/create'),
            'edit' => Pages\EditPushNotification::route('/{record}/edit'),
        ];
    }
}
