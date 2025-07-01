<?php

namespace App\Livewire\Pages\Widgets;

use Filament\Tables;
use App\Models\Jawaban;
use Livewire\Component;
use App\Models\Mahasiswa;
use App\Models\MasterFix;
use App\Models\Pertemuan;
use App\Models\MasterSoal;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Concerns\InteractsWithTable;

class PertemuanMahasiswaOverview extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public $code_pembelajaran;
    public $mahasiswa;

    public function mount()
    {
        $this->mahasiswa = Auth::user()->mahasiswa;

        $master = MasterSoal::all();

       
    }


    public function table(Table $table): Table
    {
        return $table
            ->heading('Tabel Progres Pembelajaran')
            ->query(MasterSoal::query()->whereHas('menu_pertemuan',function($mp){
                $mp->whereHas('parent',function ($par) {
                    $par->whereHas('pertemuan',function ($pert){
                        $pert->whereHas('pembelajaran',function($pem){
                            $pem->where('code',$this->code_pembelajaran);
                        });
                    });
                });
            }))
            ->columns([
                TextColumn::make('menu_pertemuan.parent.pertemuan.code')
                    ->label('Code'), 
                TextColumn::make('menu_pertemuan.parent.pertemuan.nama')
                    ->label('Pertemuan'), 
                TextColumn::make('menu_pertemuan.parent.nama')
                    ->label('Menu'), 
                TextColumn::make('menu_pertemuan.nama')
                    ->label('SubMenu'), 
                TextColumn::make('progres')
                    ->badge()
                    ->state(function (Model $record) : string {
                        $master_fix = MasterFix::query()->where([['master_soal_id',$record->id],['mahasiswa_id', $this->mahasiswa->id]])->get()->first();

                     
                    
                        if($master_fix){
                            return 'Selesai dikerjakan';
                        }else{
                            $jawaban_unfix = Jawaban::query()
                            ->where([['mahasiswa_id', $this->mahasiswa->id],['master_fix_id', null]])
                            ->whereHas('soal',function($soal) use ($record){
                                $soal->whereHas('main_soal', function($main_soal) use ($record){
                                    $main_soal->where('master_soal_id',$record->id);
                                });
                            })->get();
                            
                            if($jawaban_unfix->isNotEmpty()){
                                return 'Sedang dikerjakan';
                            }else{
                                return 'Belum dikerjakan';
                            }
                           
                        }
     
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Belum dikerjakan' => 'gray',
                        'Sedang dikerjakan' => 'warning',
                        'Selesai dikerjakan' => 'success',
                    }),
                TextColumn::make('bobot_nilai')
                ->label('Rata-rata bobot nilai')
                ->state(function (Model $record)  {

                    $master_fix = MasterFix::query()->where([['master_soal_id',$record->id],['mahasiswa_id', $this->mahasiswa->id]])->get()->first();
                    if($master_fix){
                        $total_jawaban = Jawaban::query()->where([['mahasiswa_id', $this->mahasiswa->id],['master_fix_id',$master_fix->id]])->sum('bobot_nilai');
                         $jumlah_jawaban = Jawaban::where([['mahasiswa_id', $this->mahasiswa->id],['master_fix_id', $master_fix->id]])->count();
                        if($master_fix->is_correct){
                            return $total_jawaban/$jumlah_jawaban;
                        }else{
                            return 'Belum dikoreksi';
                        }
               }else{
                return 'Belum tersedia';
               }
                
                }),
                     
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('lihat')
                ->url(fn($record):string => route('pembelajaran.master_soal',[$this->code_pembelajaran,$record->id]))
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.pages.widgets.pertemuan-mahasiswa-overview');
    }
}
