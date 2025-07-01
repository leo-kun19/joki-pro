<?php

namespace App\Livewire\Pages\Mahasiswa;

use App\Models\Soal;
use App\Models\Jawaban;
use Livewire\Component;
use App\Models\MainSoal;
use App\Models\Mahasiswa;
use App\Models\MasterFix;
use Livewire\Attributes\On;
use App\Models\Pembelajaran;
use Livewire\WithPagination;
use App\Models\PilihanJawaban;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Title;
use App\Models\AppearanceSetting;
use Illuminate\Support\Facades\DB;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Schema;
use Filament\Notifications\Notification;
use Filament\Actions\Contracts\HasActions;
use Filament\Notifications\Actions\Action;
use Psy\CodeCleaner\AssignThisVariablePass;
use App\Models\MasterSoal as ModelMasterSoal;
use App\Notifications\SendJawabanNotification;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Notifications\Actions\Action as ActionNotif;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class MasterSoal extends Component
{
    use WithPagination;

    public $code_pembelajaran;
    public $user;
    public $mahasiswa_id;
    public $master_soal_id;
    public $id_soal;
    public $index_jawaban;
    public $jawabans = [];
    public $jawaban_fixs = [];
    public $jawaban_all;
    public $pilihan_jawaban = [];
    public $updated = false;

    public $show_timer = false;
    public $timer_loading = false;
    public $show_kunci_jawaban = false;
    public $jam;
    public $menit;
    public $detik;

    public $master_fix = false;



    public function mount()
    {
        $pembelajaran = Pembelajaran::where('code', $this->code_pembelajaran)->first();
        $master_soal = ModelMasterSoal::find($this->master_soal_id);
        foreach ($master_soal->main_soals as $key => $ms) {
            foreach ($ms->soals as $key => $soal) {
                $soal->type_penyelesaian = $ms->type_penyelesaian;
                $soal->save();
            }
        }

        $this->jawaban_all = Jawaban::all();



        if (!$pembelajaran || !$master_soal) {
            return abort(404);
        }

        $this->user = Auth::user();
        $this->mahasiswa_id = Auth::user()->mahasiswa->id;
        if (!$this->timer_loading) {
            $this->jam = $master_soal->durasi_jam;
            $this->menit = $master_soal->durasi_menit;
            $this->detik = $master_soal->durasi_detik;
        }

        $master_fix = MasterFix::where([['master_soal_id', $this->master_soal_id], ['mahasiswa_id', $this->user->mahasiswa->id]])->first();



        if ($master_fix) {
            $this->master_fix = true;

            $jawaban = Jawaban::where([['mahasiswa_id', $this->user->mahasiswa->id], ['is_fix', true]])->get();
        } else {
            $jawaban = Jawaban::where([['mahasiswa_id', $this->user->mahasiswa->id], ['is_fix', false]])->get();
        }

        if ($this->jam || $this->menit  || $this->detik) {
            if ($master_fix) {
                $this->show_timer = false;
            } else {
                $this->show_timer = true;
            }
        }

        if ($jawaban) {
            foreach ($jawaban as $value) {
                $this->jawabans[$value->soal_id][$value->index_jawaban] = $value->jawaban;
                $this->jawaban_fixs[$value->soal_id][$value->index_jawaban] = $value;


                if ($value->type_soal == 'ganda') {
                    $soal = Soal::find($value->soal_id);

                    foreach ($soal->pilihan_jawabans as $key => $pilihan) {
                        if ($pilihan->index == $value->jawaban) {
                            $this->pilihan_jawaban[$soal->id]['pilihan_id'] = $pilihan->id;
                            $this->pilihan_jawaban[$soal->id]['jawaban'] = $pilihan->index . ' . ' . $pilihan->jawaban;
                        }
                    }
                }
            }
        }
    }

    public function send_id_soal($id, $index_jawaban)
    {
        $this->id_soal = $id;
        $this->index_jawaban = $index_jawaban;

        $soal = Soal::find($this->id_soal);

        if ($soal->type_soal == 'esai') {
            $this->dispatch('open-modal', 'jawab_soal');
        } else {
            if (!$this->pilihan_jawaban == []) {
                $pilihan = PilihanJawaban::where([['soal_id', $soal->id], ['id', $this->pilihan_jawaban[$soal->id]]])->first();
                $pilihan_benar =  PilihanJawaban::where([['soal_id', $soal->id], ['is_true', true]])->first();
                $soal->kunci_jawaban = $pilihan_benar->index;
                $soal->save();

                if ($soal->type_penyelesaian == 'kelompok') {
                    $mahasiswas =  Auth::user()->mahasiswa->kelompok->mahasiswas;
                    foreach ($mahasiswas as $key => $mahasiswa) {
                        Jawaban::create([
                            'jawaban' => $pilihan->index,
                            'is_true' => $pilihan->is_true,
                            'bobot_nilai' => $pilihan->is_true ? $soal->bobot_nilai : 0,
                            'type_soal' => $soal->type_soal,
                            'type_jawaban' => $soal->type_jawaban,
                            'type_penyelesaian' => $soal->type_penyelesaian,
                            'soal_id' => $soal->id,
                            'kelompok_id' => $mahasiswa->kelompok_id,
                            'mahasiswa_id' => $mahasiswa->id,
                        ]);
                    }
                } else {
                    Jawaban::create([
                        'jawaban' => $pilihan->index,
                        'is_true' => $pilihan->is_true,
                        'bobot_nilai' => $pilihan->is_true ? $soal->bobot_nilai : 0,
                        'type_soal' => $soal->type_soal,
                        'type_jawaban' => $soal->type_jawaban,
                        'type_penyelesaian' => $soal->type_penyelesaian,
                        'soal_id' => $soal->id,
                        'mahasiswa_id' => Auth::user()->mahasiswa->id,
                    ]);
                }
            } else {
                $this->addError('pilihan_jawaban', 'silahkan pilih salah satu');
            }


            $this->dispatch('hapus-textarea');
        }
    }




    public function send_id_soal_update($id, $index_jawaban)
    {
        $this->updated = true;
        $this->id_soal = $id;
        $this->index_jawaban = $index_jawaban;
        $soal = Soal::find($this->id_soal);
        if ($soal->type_penyelesaian == 'kelompok') {
            $mahasiswas =  Auth::user()->mahasiswa->kelompok->mahasiswas;
            foreach ($mahasiswas as $key => $mahasiswa) {
                $jawaban = Jawaban::where([['soal_id', $id], ['mahasiswa_id', $mahasiswa->id], ['index_jawaban', $this->index_jawaban]])->first();

                if ($jawaban) {
                    $this->dispatch('set-textarea', jawaban: $jawaban->jawaban);
                }


                if ($soal->type_soal == 'esai') {
                    $this->dispatch('open-modal', 'jawab_soal');
                } else {
                    if (!$this->pilihan_jawaban == []) {
                        $this->resetErrorBag();
                        $pilihan_benar =  PilihanJawaban::where([['soal_id', $soal->id], ['is_true', true]])->first();
                        $soal->kunci_jawaban = $pilihan_benar->index;
                        $soal->save();
                        $pilihan = PilihanJawaban::where([['soal_id', $soal->id], ['id', $this->pilihan_jawaban[$this->id_soal]]])->first();
                        $jawaban->jawaban = $pilihan->index;
                        $jawaban->is_true = $pilihan->is_true;
                        $jawaban->bobot_nilai = $pilihan->is_true ? $soal->bobot_nilai : 0;
                        $jawaban->save();
                        Notification::make()
                            ->title('Berhasil di update')
                            ->success()
                            ->send();
                    } else {
                        $this->addError('pilihan_jawaban', 'Silahkan pilih salah satu');
                    }

                    $this->dispatch('hapus-textarea');
                    $this->updated = false;
                }
            }
        } else {
            $jawaban = Jawaban::where([['soal_id', $id], ['mahasiswa_id', $this->user->mahasiswa->id], ['index_jawaban', $this->index_jawaban]])->first();

            if ($jawaban) {
                $this->dispatch('set-textarea', jawaban: $jawaban->jawaban);
            }


            if ($soal->type_soal == 'esai') {
                $this->dispatch('open-modal', 'jawab_soal');
            } else {
                if (!$this->pilihan_jawaban == []) {
                    $this->resetErrorBag();
                    $pilihan_benar =  PilihanJawaban::where([['soal_id', $soal->id], ['is_true', true]])->first();
                    $soal->kunci_jawaban = $pilihan_benar->index;
                    $soal->save();
                    $pilihan = PilihanJawaban::where([['soal_id', $soal->id], ['id', $this->pilihan_jawaban[$this->id_soal]]])->first();
                    $jawaban->jawaban = $pilihan->index;
                    $jawaban->is_true = $pilihan->is_true;
                    $jawaban->bobot_nilai = $pilihan->is_true ? $soal->bobot_nilai : 0;
                    $jawaban->save();
                    Notification::make()
                        ->title('Berhasil di update')
                        ->success()
                        ->send();
                } else {
                    $this->addError('pilihan_jawaban', 'Silahkan pilih salah satu');
                }

                $this->dispatch('hapus-textarea');
                $this->updated = false;
            }
        }
    }

    public function jawabAction()
    {
        $soal = Soal::find($this->id_soal);
        if ($soal->type_penyelesaian == 'kelompok') {
            $mahasiswas =  Auth::user()->mahasiswa->kelompok->mahasiswas;

            foreach ($mahasiswas as $key => $mahasiswa) {
                Jawaban::create([
                    'type_soal' => $soal->type_soal,
                    'type_jawaban' => $soal->type_jawaban,
                    'type_penyelesaian' => $soal->type_penyelesaian,
                    'jawaban' => $this->jawabans[$this->id_soal][$this->index_jawaban],
                    'index_jawaban' => $this->index_jawaban,
                    'soal_id' => $soal->id,
                    'mahasiswa_id' => $mahasiswa->id,
                    'kelompok_id' => $mahasiswa->kelompok_id,
                ]);
            }
        } else {

            Jawaban::create([
                'type_soal' => $soal->type_soal,
                'type_jawaban' => $soal->type_jawaban,
                'type_penyelesaian' => $soal->type_penyelesaian,
                'jawaban' => $this->jawabans[$this->id_soal][$this->index_jawaban],
                'index_jawaban' => $this->index_jawaban,
                'soal_id' => $soal->id,
                'mahasiswa_id' => Auth::user()->mahasiswa->id,
            ]);
        }

        $this->dispatch('hapus-textarea');
        $this->updated = false;
        $this->dispatch('close-modal', 'jawab_soal');
    }
    public function jawabActionUpdated()
    {
        $soal = Soal::find($this->id_soal);
        if ($soal->type_penyelesaian == 'kelompok') {
            $mahasiswas =  Auth::user()->mahasiswa->kelompok->mahasiswas;

            foreach ($mahasiswas as $key => $mahasiswa) {
                $jawaban = Jawaban::where([['soal_id', $this->id_soal], ['mahasiswa_id', $mahasiswa->id], ['index_jawaban', $this->index_jawaban]])->first();

                $jawaban->jawaban = $this->jawabans[$this->id_soal][$this->index_jawaban];
                $jawaban->save();
                $this->dispatch('hapus-textarea');
                $this->updated = false;
                $this->dispatch('close-modal', 'jawab_soal');
            }
        } else {
            $jawaban = Jawaban::where([['soal_id', $this->id_soal], ['mahasiswa_id', $this->user->mahasiswa->id], ['index_jawaban', $this->index_jawaban]])->first();

            $jawaban->jawaban = $this->jawabans[$this->id_soal][$this->index_jawaban];
            $jawaban->save();
            $this->dispatch('hapus-textarea');
            $this->updated = false;
            $this->dispatch('close-modal', 'jawab_soal');
        }
    }

    public function closeModal()
    {
        $this->redirectRoute('pembelajaran.master_soal', [$this->code_pembelajaran, $this->master_soal_id]);
    }

    public function konfirmasi_tolak()
    {
        return redirect()->route('pembelajaran.dashboard', $this->code_pembelajaran);
    }

    #[On('waktu_selesai')]
    public function kirim_semua_jawaban()
    {

        $soal = Soal::find($this->id_soal);
        $master_soal = ModelMasterSoal::find($this->master_soal_id);

        foreach ($master_soal->main_soals as  $value) {

       
            foreach ($value->soals as $soal) {
                if ($soal->type_penyelesaian == 'kelompok') {
                    $mahasiswas =  Auth::user()->mahasiswa->kelompok->mahasiswas;
                    foreach ($mahasiswas as $key => $mahasiswa) {
                        $master_fix = MasterFix::create([
                            'master_soal_id' => $this->master_soal_id,
                            'main_soal_judul' => $value->judul,
                            'main_soal_id' => $value->id,
                            'kelompok_id' => $mahasiswa->kelompok_id,
                            'mahasiswa_id' => $mahasiswa->id,
                        ]);
                        foreach (range(1, $soal->qty_jawaban) as  $index_jawaban) {
                            $jawaban = Jawaban::where([['soal_id', $soal->id], ['mahasiswa_id', $mahasiswa->id], ['index_jawaban', $index_jawaban]])->first();
                            if ($jawaban) {
                                $jawaban->is_fix = true;
                                $jawaban->save();
                            } else {
                                Jawaban::create([
                                    'type_soal' => $soal->type_soal,
                                    'type_jawaban' => $soal->type_jawaban,
                                    'type_penyelesaian' => $soal->type_penyelesaian,
                                    'jawaban' => null,
                                    'index_jawaban' => $index_jawaban,
                                    'is_fix' => true,
                                    'soal_id' => $soal->id,
                                    'mahasiswa_id' => $mahasiswa->id,
                                    'kelompok_id' => $mahasiswa->kelompok_id,
                                ]);
                            }
                        }
                    }
                } else {
                    $master_fix = MasterFix::create([
                        'master_soal_id' => $this->master_soal_id,
                        'main_soal_judul' => $value->judul,
                        'main_soal_id' => $value->id,
                        'mahasiswa_id' => Auth::user()->mahasiswa->id,
                    ]);
                    foreach (range(1, $soal->qty_jawaban) as  $index_jawaban) {
                        $jawaban = Jawaban::where([['soal_id', $soal->id], ['mahasiswa_id', $this->user->mahasiswa->id], ['index_jawaban', $index_jawaban]])->first();
                        if ($jawaban) {
                            $jawaban->is_fix = true;
                            $jawaban->master_fix_id = $master_fix->id;
                            $jawaban->save();
                        } else {
                            Jawaban::create([
                                'type_soal' => $soal->type_soal,
                                'type_jawaban' => $soal->type_jawaban,
                                'type_penyelesaian' => $soal->type_penyelesaian,
                                'jawaban' => null,
                                'index_jawaban' => $index_jawaban,
                                'is_fix' => true,
                                'soal_id' => $soal->id,
                                'mahasiswa_id' => Auth::user()->mahasiswa->id,
                                'master_fix_id' => $master_fix->id,
                            ]);
                        }
                    }
                }
            }
        };


        Notification::make()
            ->title('Jawaban berhasil dikirimkan')
            ->success()
            ->send();

        $dosen = Pembelajaran::where('code', $this->code_pembelajaran)->first()->dosen->user;

        Notification::make()
            ->title(Auth::user()->name . '(' . $this->user->mahasiswa->kelas->nama . ')' . ' ' . 'Mengirimkan Jawaban')
            ->actions([
                ActionNotif::make('view')
                    ->button()
                    ->markAsRead()
                    ->url(route('filament.admin.resources.jawabans.index', ['tableFilters[mahasiswa][value]' => $this->mahasiswa_id, 'tableFilters[is_correct][value]' => false]), shouldOpenInNewTab: true),
            ])
            ->sendToDatabase($dosen);

        // // dd($dosen);
        // $dosen->notify(
        //     Notification::make()
        //     ->title(Auth::user()->name .' '. 'Mengirimkan Jawaban')
        //     ->toDatabase(),
        // );

        // $dosen->notify(new SendJawabanNotification(Auth::user()));


        // $this->redirectRoute('pembelajaran.dashboard', $this->code_pembelajaran);
        $this->redirectRoute('pembelajaran.master_soal', [
            'code_pembelajaran' => $this->code_pembelajaran,
            'master_soal_id' => $this->master_soal_id,
        ]);
    }

    public function chatDosen($mahasiswa_id)
    {

        $this->redirectRoute('chat-dosen', [$this->master_soal_id, $mahasiswa_id]);
    }

    public function chatDiskusi($id_soal)
    {
        $this->redirectRoute('chat-diskusi', [$this->master_soal_id, $id_soal, Auth::user()->mahasiswa->kelompok_id]);
    }


    #[Title('Master Soal')]
    public function render()
    {
        $is_sharing = false;

        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();


        if ($mahasiswa) {
            $kelas_id = $mahasiswa->kelas_id;
            $today = Carbon::today()->toDateString(); // tanggal hari ini, format Y-m-d
            // DB::statement("
            //     CREATE TABLE IF NOT EXISTS master_soal_kelas (
            //         master_soal_id CHAR(36) NOT NULL,
            //         kelas_id BIGINT UNSIGNED NOT NULL,
            //         tanggal_sharing DATE NULL,
            //         created_at TIMESTAMP NULL,
            //         updated_at TIMESTAMP NULL,
            //         PRIMARY KEY (master_soal_id, kelas_id)
            //     ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            // ");

            $is_sharing = DB::table('master_soal_kelas')
                ->where('master_soal_id', $this->master_soal_id)
                ->where('kelas_id', $kelas_id)
                ->whereDate('tanggal_sharing', '>=', $today)
                ->exists();
        }
        $setting = null;

        if (Schema::hasTable('appearance_settings')) {
            $setting = AppearanceSetting::first();
        }

        return view('livewire.pages.mahasiswa.master-soal', [
            'main_soals' => MainSoal::where('master_soal_id', $this->master_soal_id)->paginate(1),
            'is_sharing' => $is_sharing,
            'setting' => $setting
        ]);
    }
}
