<?php

namespace App\Filament\Resources\MainSoalResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use PhpParser\Node\Expr\Cast\Bool_;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use DragonCode\Support\Facades\Helpers\Boolean;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class SoalsRelationManager extends RelationManager
{
    protected static string $relationship = 'soals';

    public function form(Form $form): Form
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
                                Grid::make(5)
                                    ->schema([
                                        TextInput::make('index')
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
                                        Select::make('type_penyelesaian')
                                            ->options([
                                                'mandiri' => 'Mandiri',
                                                'kelompok' => 'Kelompok'
                                            ]),
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
                                            ->inputMode('decimal')
                                            ->step(100)
                                            ->numeric()
                                    ]),
                                Section::make()
                                    ->schema([
                                        Repeater::make('pilihan_jawabans')
                                            ->relationship()
                                            ->schema([
                                                TextInput::make('index')
                                                    ->required(),
                                                Textarea::make('jawaban'),
                                                Checkbox::make('is_true')
                                            ])->columns(3)
                                            ->required()
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
                    ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('pertanyaan')
            ->columns([
                Tables\Columns\TextColumn::make('pertanyaan')
                    ->markdown()
                    ->limit(20),
                Tables\Columns\TextColumn::make('type_soal'),
                Tables\Columns\TextColumn::make('type_jawaban'),
                Tables\Columns\TextColumn::make('type_penyelesaian'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Ubah data')
                    ->modalAlignment('center')
                    ->form([
                        Tabs::make('Tabs')
                            ->tabs([
                                Tabs\Tab::make('Pertanyaan')
                                    ->schema([
                                        TinyEditor::make('pertanyaan')
                                            ->showMenuBar()
                                            ->required()
                                            ->columnSpanFull(),
                                    ]),
                                Tabs\Tab::make('Pengaturan')
                                    ->schema([
                                        Grid::make(5)
                                            ->schema([
                                                TextInput::make('index')
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
                                                    ->visible(function (\Filament\Forms\Get $get) {
                                                        return $get('type_jawaban') == 'multi';
                                                    }),
                                                Select::make('type_penyelesaian')
                                                    ->options([
                                                        'mandiri' => 'Mandiri',
                                                        'kelompok' => 'Kelompok'
                                                    ])
                                            ])


                                    ]),
                                Tabs\Tab::make('Pengaturan Soal Ganda')
                                    ->schema([
                                        Section::make()
                                            ->schema([
                                                TextInput::make('bobot_nilai')
                                                    ->required()
                                                    ->inputMode('decimal')
                                                    ->step(100)
                                                    ->numeric()
                                            ]),
                                        Section::make()
                                            ->schema([
                                                Repeater::make('pilihan_jawabans')
                                                    ->relationship()
                                                    ->schema([
                                                        TextInput::make('index')
                                                            ->required(),
                                                        Textarea::make('jawaban'),
                                                        Checkbox::make('is_true')
                                                    ])->columns(3)
                                                    ->required()
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
                            ])
                    ])
                    ->mutateFormDataUsing(function (array $data): array {
                        return $data;
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
