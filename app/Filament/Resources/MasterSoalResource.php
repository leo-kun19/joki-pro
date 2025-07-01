<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\MasterSoal;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\MasterSoalResource\Pages;
use App\Filament\Resources\MasterSoalResource\RelationManagers\MainSoalsRelationManager;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;


class MasterSoalResource extends Resource
{
    protected static ?string $model = MasterSoal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Soal';
    protected static ?string $navigationLabel = 'Master Soal';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\DatePicker::make('tanggal_mulai'),
                        Forms\Components\DatePicker::make('tanggal_selesai'),
                        Forms\Components\Select::make('menu_pertemuan_id')
                            ->relationship(
                                'menu_pertemuan',
                                modifyQueryUsing: fn (Builder $query) => $query->where([['parent_id', '!=', null], ['has_soal', false]])
                            )
                            ->preload()
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "( {$record->code} ) {$record->nama}")
                            ->label('Menu Pertemuan')
                            ->searchable(['nama', 'code'])
                            ->preload()
                            ->searchDebounce(500)
                            ->required(),
                    ])->columns(3),
                Section::make('Timer')
                    ->description('Kosongkan jika tanpa timer')
                    ->schema([
                        Forms\Components\TextInput::make('durasi_jam')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(59),
                        Forms\Components\TextInput::make('durasi_menit')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(59),
                        Forms\Components\TextInput::make('durasi_detik')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(59),
                    ])->columns(3),
                Section::make()
                    ->schema([
                        Forms\Components\Toggle::make('show_kunci_jawaban'),
                        Forms\Components\Toggle::make('show_bobot_nilai'),
                    ])->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('menu_pertemuan.nama')
                ->numeric()
                ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_mulai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_selesai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('durasi_jam')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('durasi_menit')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('durasi_detik')
                    ->numeric()
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
                Tables\Actions\Action::make('sharing')
                    ->label('Sharing')
                    ->icon('heroicon-o-share')
                    ->color('primary')
                    ->form([
                        Repeater::make('jadwal_sharing')
                            ->label('Jadwal Sharing per Kelas')
                            ->schema([
                                Select::make('kelas_id')
                                    ->label('Kelas')
                                    ->options(Kelas::all()->pluck('nama', 'id'))
                                    ->searchable()
                                    ->required(),

                                DatePicker::make('tanggal_sharing')
                                    ->label('Tanggal Sharing')
                                    ->required(),
                            ])
                            ->columns(2)
                            ->reorderable(false)
                            ->addActionLabel('Tambah Kelas')
                    ])
                    ->action(function (array $data, Model $record) {
                        foreach ($data['jadwal_sharing'] as $item) {
                            DB::statement("
                                CREATE TABLE IF NOT EXISTS master_soal_kelas (
                                    master_soal_id TEXT NOT NULL,
                                    kelas_id INTEGER NOT NULL,
                                    tanggal_sharing DATE NOT NULL,
                                    created_at DATETIME,
                                    updated_at DATETIME,
                                    PRIMARY KEY (master_soal_id, kelas_id)
                                )
                            ");
                    
                            DB::table('master_soal_kelas')->insert([
                                'master_soal_id' => $record->id,
                                'kelas_id' => $item['kelas_id'],
                                'tanggal_sharing' => $item['tanggal_sharing'],
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                        \Filament\Notifications\Notification::make()
                            ->title('Berhasil')
                            ->body('Pembahasan Soal berhasil disharing ke kelas yang dipilih!')
                            ->success()
                            ->send();

                    })
                    ->modalHeading('Sharing Pembahasan Soal ke Kelas')
                    ->modalSubmitActionLabel('Bagikan')
                    ->modalWidth('xl')
                    ->requiresConfirmation(false)
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                    ->action(function (Collection $records) {
                        foreach ($records as $key => $record) {
                            $menu_pertemuan =  $record->menu_pertemuan;
                            $menu_pertemuan->has_soal = false;
                            $menu_pertemuan->save();
                            $record->delete();
                        }
                    }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            MainSoalsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMasterSoals::route('/'),
            'create' => Pages\CreateMasterSoal::route('/create'),
            'edit' => Pages\EditMasterSoal::route('/{record}/edit'),
        ];
    }
}
