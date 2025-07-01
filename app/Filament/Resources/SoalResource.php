<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Soal;
use Filament\Tables;
use App\Models\Jawaban;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PilihanJawaban;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SoalResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SoalResource\RelationManagers;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use App\Filament\Resources\SoalResource\RelationManagers\JawabansRelationManager;
use App\Filament\Resources\SoalResource\RelationManagers\PilihanJawabansRelationManager;
use Filament\Forms\Components\Toggle;

class SoalResource extends Resource
{
    protected static ?string $model = Soal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Soal';
    protected static ?string $navigationLabel = 'Soal';
    protected static ?int $navigationSort = 3;
    protected static bool $shouldRegisterNavigation = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Pertanyaan')
                            ->schema([
                                TinyEditor::make('pertanyaan')
                                    ->showMenuBar()
                                    ->fileAttachmentsDisk('local')->fileAttachmentsVisibility('public')->fileAttachmentsDirectory('uploads')
                                    ->required()
                                    ->columnSpanFull(),
                            ]),
                        Tabs\Tab::make('Pengaturan')
                            ->schema([
                                Grid::make(4)
                                    ->schema([
                                        TextInput::make('index')
                                            ->required(),
                                        Select::make('main_soal_id')
                                            ->relationship('main_soal')
                                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "( {$record->code} ) {$record->index}.{$record->judul}")
                                            ->searchable(['code', 'judul'])
                                            ->preload()
                                            ->searchable()
                                            ->required(),
                                        Select::make('type_soal')
                                            ->options([
                                                'esai' => ' Soal Esai',
                                                'ganda' => ' Soal Ganda'
                                            ])->live(),
                                        Select::make('type_jawaban')
                                            ->options([
                                                'single' => ' Single',
                                                'multi' => ' Multi'
                                            ])->visible(function (\Filament\Forms\Get $get) {
                                                return $get('type_soal') == 'esai';
                                            })->live(),
                                        
                                        TextInput::make('qty_jawaban')
                                            ->numeric()
                                            ->visible(function (\Filament\Forms\Get $get) {
                                                return $get('type_jawaban') == 'multi';
                                            }),
                                    ])


                            ]),
                        Tabs\Tab::make('Pengaturan Soal Ganda')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextInput::make('bobot_nilai')
                                            ->required()
                                            ->default(null)
                                            ->inputMode('decimal')
                                            ->step(100)
                                            ->numeric()
                                    ]),
                            ])->visible(function (\Filament\Forms\Get $get) {
                                return $get('type_soal') == 'ganda';
                            }),
                        Tabs\Tab::make('Kunci Jawaban')
                            ->schema([
                                TinyEditor::make('kunci_jawaban')
                                    ->showMenuBar()
                            ])->visible(function (\Filament\Forms\Get $get) {
                                return $get('type_soal') == 'esai';
                            }),
                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('main_soal.master_soal.menu_pertemuan.nama')
                    ->searchable()
                    ->limit(30)
                    ->sortable(),
                Tables\Columns\TextColumn::make('main_soal.judul')
                    ->searchable()
                    ->limit(30)
                    ->sortable(),
                Tables\Columns\TextColumn::make('pertanyaan')
                    ->markdown()
                    ->limit(50)
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
                Tables\Filters\SelectFilter::make('menu')
                    ->relationship('main_soal.master_soal.menu_pertemuan', 'nama'),
                Tables\Filters\SelectFilter::make('type_soal')
                    ->options([
                        'esai' => 'Soal Esai',
                        'ganda' => 'Pilihan Ganda',
                    ]),
                Tables\Filters\SelectFilter::make('type_jawaban')
                    ->options([
                        'single' => 'Jawaban Single',
                        'multi' => 'Jawaban Multi',
                    ]),
                Tables\Filters\SelectFilter::make('type_penyelesaian')
                    ->options([
                        'mandiri' => 'Mandiri',
                        'kelompok' => 'Kelompok',
                    ]),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make()
                ->successRedirectUrl(fn (): string => route('filament.admin.resources.soals.index')),
                Tables\Actions\ReplicateAction::make()
                ->successRedirectUrl(fn (Model $replica): string => route('filament.admin.resources.soals.edit',$replica)),
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

            PilihanJawabansRelationManager::class,
            JawabansRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSoals::route('/'),
            'create' => Pages\CreateSoal::route('/create'),
            'edit' => Pages\EditSoal::route('/{record}/edit'),
        ];
    }
}
