<?php

namespace App\Livewire\Pages\Mahasiswa\Components;

use Livewire\Component;
use App\Models\Pembelajaran;

class SidebarPertemuan extends Component
{
    public $code_pembelajaran;

    public function mount()
    {
        $pembelajaran = Pembelajaran::where('code', $this->code_pembelajaran)->first();
        if (!$pembelajaran) {
            return abort(404);
        }
    }

    public function render()
    {
        return view('livewire.pages.mahasiswa.components.sidebar-pertemuan', [
            'pembelajaran' => Pembelajaran::where([['code', $this->code_pembelajaran]])->first()
        ]);
    }
}
