<?php

namespace App\Livewire\Pages\Mahasiswa;

use App\Models\MasterMateri as ModelsMasterMateri;
use Livewire\Component;

class MasterMateri extends Component
{
    public $master_materi_id;

    public $code_pembelajaran;


    public function render()
    {
        return view('livewire.pages.mahasiswa.master-materi', [
            'materi' => ModelsMasterMateri::where('id', $this->master_materi_id)->first()
        ]);
    }
}
