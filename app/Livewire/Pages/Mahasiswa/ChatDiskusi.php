<?php

namespace App\Livewire\Pages\Mahasiswa;

use App\Models\Soal;

use Livewire\Component;
use App\Models\MasterSoal;
use App\Models\DiskusiKelompok;
use App\Models\ChatDiskusiKelompok;
use Illuminate\Support\Facades\Auth;




class ChatDiskusi extends Component
{
    public $soal_id;
    public $master_soal_id;
    public $kelompok_id;
    public $diskusi_kelompok_id;
    public $isi_pesan;

    public $select_balas;
    public $chat_dibalas;

    public function mount()
    {


        $diskusi_kelompok = DiskusiKelompok::where([['soal_id', $this->soal_id], ['kelompok_id', $this->kelompok_id]])->first();

        if ($diskusi_kelompok == null) {
            $diskusi_kelompok = DiskusiKelompok::create([
                'soal_id' => $this->soal_id,
                'kelompok_id' => $this->kelompok_id,
            ]);
            $this->diskusi_kelompok_id = $diskusi_kelompok->id;
        } else {
            $this->diskusi_kelompok_id = $diskusi_kelompok->id;
        }
    }

    public function balasChat($id)
    {
        $this->chat_dibalas = ChatDiskusiKelompok::find($id);
    }
    public function hapusChatDibalas()
    {
        $this->reset('chat_dibalas');
    }


    public function send_chat()
    {
        if ($this->chat_dibalas) {
            ChatDiskusiKelompok::create([
                'isi_pesan' => $this->isi_pesan,
                'pengirim_id' => Auth::user()->id,
                'parent_id' => $this->chat_dibalas->id,
                'diskusi_kelompok_id' => $this->diskusi_kelompok_id
            ]);
        } else {
            ChatDiskusiKelompok::create([
                'isi_pesan' => $this->isi_pesan,
                'pengirim_id' => Auth::user()->id,
                'diskusi_kelompok_id' => $this->diskusi_kelompok_id
            ]);
        }


        $this->isi_pesan = '';
        $this->reset('chat_dibalas');
        $this->dispatch('hapus-textarea');
    }

    public function render()
    {
        return view('livewire.pages.mahasiswa.chat-diskusi', [
            'soal' => Soal::find($this->soal_id),
            'pembelajaran' => MasterSoal::find($this->master_soal_id)->menu_pertemuan->parent->pertemuan->pembelajaran,
            'diskusi_kelompok' => DiskusiKelompok::find($this->diskusi_kelompok_id),
        ]);
    }
}
