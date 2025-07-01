<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\MainSoal;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\MainSoalResource\Pages;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use App\Filament\Resources\MainSoalResource\RelationManagers\SoalsRelationManager;

class MainSoalResource extends Resource
{
    protected static ?string $model = MainSoal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Soal';
    protected static ?string $navigationLabel = 'Main Soal';
    protected static ?int $navigationSort = 2;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->unique(ignoreRecord:true)
                            ->validationMessages([
                                'unique' => ':attribute sudah ada.',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('index'),
                        Forms\Components\TextInput::make('judul'),
                        Forms\Components\Select::make('type_penyelesaian')
                        ->required()
                        ->options([
                            'mandiri'=>'Mandiri',
                            'kelompok'=>'Kelompok']),
                        Forms\Components\Select::make('master_soal_id')
                            ->relationship('master_soal')
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "( {$record->menu_pertemuan->code} ) {$record->menu_pertemuan->nama}")
                            ->searchable(['nama', 'code'])
                            ->preload()
                            ->searchable()
                            ->required(),
                    ])->columns(3),

                TinyEditor::make('konten')
                    ->fileAttachmentsDisk('local')->fileAttachmentsVisibility('public')->fileAttachmentsDirectory('uploads')
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->sortable(),
                Tables\Columns\TextColumn::make('index')
                    ->sortable(),
                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('master_soal.id')
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
            SoalsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMainSoals::route('/'),
            'create' => Pages\CreateMainSoal::route('/create'),
            'edit' => Pages\EditMainSoal::route('/{record}/edit'),
        ];
    }
}
