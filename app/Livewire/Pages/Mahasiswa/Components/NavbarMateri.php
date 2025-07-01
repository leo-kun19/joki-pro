<?php

namespace App\Livewire\Pages\Mahasiswa\Components;

use App\Models\Navbar;
use App\Models\Pembelajaran;
use Livewire\Component;

class NavbarMateri extends Component
{

    public $code_pembelajaran;

    public $pembelajaran_id;

    public function mount()
    {

        $pembelajaran = Pembelajaran::where('code', $this->code_pembelajaran)->first();
        $this->pembelajaran_id = $pembelajaran->id;
    }


    public function render()
    {
        return view('livewire.pages.mahasiswa.components.navbar-materi', [
            'navbars' => Navbar::where('pembelajaran_id', $this->pembelajaran_id)->get()
        ]);
    }
}
