<?php

namespace App\Livewire\Pages\Mahasiswa;

use App\Models\Soal;
use Livewire\Component;





use App\Models\MainSoal;
use App\Models\MasterSoal;
use App\Models\DiskusiDosen;
use Livewire\Attributes\Title;
use App\Models\ChatDiskusiDosen;
use Illuminate\Support\Facades\Auth;


class ChatDosen extends Component
{

    public $master_soal_id;
    public $diskusi_dosen_id;
    public $mahasiswa_id;
    public $isi_pesan;

    public function mount()
    {
        $dosen_id = MasterSoal::find($this->master_soal_id)->menu_pertemuan->parent->pertemuan->pembelajaran->dosen_id;

        $diskusi_dosen = DiskusiDosen::where([['master_soal_id', $this->master_soal_id], ['mahasiswa_id', $this->mahasiswa_id], ['dosen_id', $dosen_id]])->first();
        if ($diskusi_dosen == null) {
            $diskusi_dosen = DiskusiDosen::create([
                'master_soal_id' => $this->master_soal_id,
                'mahasiswa_id' => $this->mahasiswa_id,
                'dosen_id' => $dosen_id
            ]);
            $this->diskusi_dosen_id = $diskusi_dosen->id;
        } else {
            $this->diskusi_dosen_id = $diskusi_dosen->id;
        }
    }

    public function send_chat()
    {

        ChatDiskusidosen::create([
            'isi_pesan' => $this->isi_pesan,
            'pengirim_id' => Auth::user()->id,
            'diskusi_dosen_id' => $this->diskusi_dosen_id
        ]);
        $this->isi_pesan = '';
        $this->dispatch('hapus-textarea');
    }
    public function send_soal($id_soal)
    {

        $soal = Soal::find($id_soal);

        ChatDiskusidosen::create([
            'isi_pesan' => $soal->pertanyaan,
            'is_pinned' => true,
            'pengirim_id' => Auth::user()->id,
            'diskusi_dosen_id' => $this->diskusi_dosen_id
        ]);
        $this->isi_pesan = '';
        $this->dispatch('hapus-textarea');
    }

    #[Title('Chat Dosen')]
    public function render()
    {
        return view('livewire.pages.mahasiswa.chat-dosen', [
            'main_soals' => MainSoal::where('master_soal_id', $this->master_soal_id)->get(),
            'pembelajaran' => MasterSoal::find($this->master_soal_id)->menu_pertemuan->parent->pertemuan->pembelajaran,
            'diskusi_dosen' => DiskusiDosen::find($this->diskusi_dosen_id)
        ]);
    }
}
