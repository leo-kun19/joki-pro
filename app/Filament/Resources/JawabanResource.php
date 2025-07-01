<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Jawaban;
use Filament\Forms\Get;
use Filament\Infolists;
use App\Models\Kelompok;
use Filament\Forms\Form;
use App\Models\Mahasiswa;
use App\Models\MasterFix;
use Filament\Tables\Table;
use Psy\Readline\Hoa\Console;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Fieldset;
use Filament\Infolists\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use App\Notifications\SendPushNotification;
use Filament\Notifications\Actions\Action ;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\JawabanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\JawabanResource\RelationManagers;
use Filament\Forms\Components\Fieldset as ComponentsFieldset;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class JawabanResource extends Resource
{
    protected static ?string $model = Jawaban::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Soal';
    protected static ?string $navigationLabel = 'Jawaban';
    protected static ?int $navigationSort = 4;
    protected static bool $shouldRegisterNavigation = true;


   


    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->where('is_fix', true);
            })
            ->columns([
                Tables\Columns\TextColumn::make('soal.main_soal.master_soal.menu_pertemuan.nama')
                ->limit(20)
                ->tooltip(function (TextColumn $column): ?string {
                    $state = $column->getState();
             
                    if (strlen($state) <= $column->getCharacterLimit()) {
                        return null;
                    }
                    return $state;
                }),
                Tables\Columns\TextColumn::make('soal.main_soal.judul')
                ->limit(20)
                ->tooltip(function (TextColumn $column): ?string {
                    $state = $column->getState();
             
                    if (strlen($state) <= $column->getCharacterLimit()) {
                        return null;
                    }
                    return $state;
                }),
                Tables\Columns\TextColumn::make('soal.pertanyaan')
                ->placeholder('tersedia')
                ->limit(20)
                ->markdown()
                ->tooltip(function (TextColumn $column): ?string {
                    $state = $column->getState();
             
                    if (strlen($state) <= $column->getCharacterLimit()) {
                        return null;
                    }
                    return str($state)->sanitizeHtml();
                }),
                Tables\Columns\TextColumn::make('mahasiswa.nama')->label('Nama'),
                Tables\Columns\TextColumn::make('mahasiswa.nim')->label('Nim'),
                Tables\Columns\TextColumn::make('kelompok.nama')->label('Nama Kelompok')->placeholder('tidak ada data'),
            

                // Tables\Columns\TextColumn::make('kelompok.nama'),
                // Tables\Columns\TextColumn::make('bobot_nilai'),
                // Tables\Columns\IconColumn::make('is_true')->boolean(),
                // Tables\Columns\ToggleColumn::make('is_correct'),
            ])
            ->filters([
               
                Tables\Filters\SelectFilter::make('menu_pertemuan')
                    ->relationship('soal.main_soal.master_soal.menu_pertemuan', 'nama', fn (Builder $query) => $query->where('parent_id','!=',null) )
                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "( {$record->code} ) {$record->nama}")
                    ->preload()
                    ->searchable('nama'),
                Tables\Filters\SelectFilter::make('main_soal')
                    ->relationship('soal.main_soal', 'judul')
                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "( {$record->code} ) {$record->judul}")
                    ->preload()
                    ->searchable('nama'),
                Tables\Filters\SelectFilter::make('kelas')
                    ->relationship('mahasiswa.kelas', 'nama')
                    ->preload()
                    ->searchable('nama'),
                Tables\Filters\SelectFilter::make('kelompok')
                    ->relationship('kelompok', 'nama')
                    ->preload()
                    ->searchable('nama'),
                Tables\Filters\SelectFilter::make('mahasiswa')
                    ->relationship('mahasiswa', 'nama')
                    ->preload()
                    ->searchable('nama', 'nim'),
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
                Tables\Filters\SelectFilter::make('type_penyelesaian')
                    ->options([
                        'mandiri' => 'Mandiri',
                        'kelompok' => 'Kelompok',
                    ]),
                Tables\Filters\TernaryFilter::make('is_correct')
                    ->label('Koreksi')
                    ->placeholder('All')
                    ->trueLabel('Sudah Dikoreksi')
                    ->falseLabel('Belum Dikoreksi')
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make('feedback_dosen')
                    ->form([
                        Fieldset::make('Soal')
                        ->columns(3)
                        ->schema([
                            TextInput::make('type_soal')->disabled(),
                            TextInput::make('type_jawaban')->disabled(),
                            TextInput::make('type_penyelesaian')->disabled(),
                        ]),
                        TinyEditor::make('pertanyaan')
                            ->formatStateUsing(fn(Model $record):string=> $record->soal->pertanyaan)
                            ->columnSpanFull()
                            ->disabled(),
                        TinyEditor::make('kunci_jawaban')
                            ->formatStateUsing(fn(Model $record):string=> $record->soal->kunci_jawaban??'Tidak ada kunci jawaban')
                            ->columnSpanFull()
                            ->disabled(),
                        TinyEditor::make('jawaban')
                            ->label('Jawaban Mahasiswa')
                            ->formatStateUsing(fn($state):string=>$state??'Mahasiswa belum menjawab')
                            ->columnSpanFull()
                            ->disabled(),
                        TinyEditor::make('feedback_dosen')
                            ->columnSpanFull(),
                        Toggle::make('is_true')
                            ->disabled(fn(Get $get):bool =>$get('type_soal') == 'ganda'),
                        TextInput::make('bobot_nilai')
                            ->disabled(fn(Get $get):bool =>$get('type_soal') == 'ganda')
                            ->numeric()
                            ->maxValue(100),
                    ])
                    ->afterFormValidated(function (Model $record) {
                        $mahasiswa = $record->mahasiswa->user;
                       $code_pembelajaran = $record->soal->main_soal->master_soal->menu_pertemuan->parent->pertemuan->pembelajaran->code;
                       $master_soal_id = $record->soal->main_soal->master_soal->id;

                        if($record->type_penyelesaian =="kelompok"){
                            $mahasiswas = Mahasiswa::where('kelompok_id',$record->kelompok_id)->get();
                            $soal_id = $record->soal_id;

                            foreach($mahasiswas as $mahasiswa){
                                $jawaban = Jawaban::where([['mahasiswa_id', $mahasiswa->id],['soal_id',$soal_id]])->get()->first();

                                $title = Auth::user()->name . ' Sudah mengoreksi jawaban anda';
                                $body = 'Silahkan periksa jawaban anda';
                                $image = null;
                          
                                          $mahasiswa->user->notify(new SendPushNotification($title,$body,$image,[]));
                                             Notification::make()
                                             ->title($title)
                                             ->actions([
                                                 Action::make('view')
                                                     ->button()
                                                     ->markAsRead()
                                                     ->url(route('pembelajaran.master_soal',[
                                                         $code_pembelajaran,
                                                         $master_soal_id
                                                     ]), shouldOpenInNewTab: true),
                                                     ])
                                             ->sendToDatabase($mahasiswa->user);
                                             
                                
         
                               
                               
                                 $jawaban->is_correct = true;
                                 $jawaban->save();
         
                                 $master_fix = MasterFix::find($jawaban->master_fix_id);
                                 $master_fix->is_correct = true;
                                 $master_fix->save();
         
                            }
                            
                        }

                       
                       $title = Auth::user()->name . ' Sudah mengoreksi jawaban anda';
                       $body = 'Silahkan periksa jawaban anda';
                       $image = null;
                 
                                 $mahasiswa->notify(new SendPushNotification($title,$body,$image,[]));
                                    Notification::make()
                                    ->title($title)
                                    ->actions([
                                        Action::make('view')
                                            ->button()
                                            ->markAsRead()
                                            ->url(route('pembelajaran.master_soal',[
                                                $code_pembelajaran,
                                                $master_soal_id
                                            ]), shouldOpenInNewTab: true),
                                            ])
                                    ->sendToDatabase($mahasiswa);
                                    
                       

                      
                      
                        $record->is_correct = true;
                        $record->save();

                        $master_fix = MasterFix::find($record->master_fix_id);
                        $master_fix->is_correct = true;
                        $master_fix->save();

                    })
                    ->label('Koreksi')
                    ->recordTitle('Feedback Dosen'),
               
                Tables\Actions\DeleteAction::make('delete')
                ->before(
                    function (Model $record){
                        $master_id = $record->soal->main_soal->master_soal->id;
                        $master_fix = MasterFix::where([['mahasiswa_id', $record->mahasiswa_id],['master_soal_id',$master_id]])->first();
                        if($master_fix){
                            $master_fix->delete();
                        }
                       
                    }
                ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                    ->action(function (Collection $records) {
                        foreach ($records as $key => $record) {
                            $master_id = $record->soal->main_soal->master_soal->id;
                            $master_fix = MasterFix::where([['mahasiswa_id', $record->mahasiswa_id],['master_soal_id',$master_id]])->first();
                            if($master_fix){
                                $master_fix->delete();
                            }
                            $record->delete();
                        }
                    })
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
            'index' => Pages\ListJawabans::route('/'),
            'create' => Pages\CreateJawaban::route('/create'),
        ];
    }
}
