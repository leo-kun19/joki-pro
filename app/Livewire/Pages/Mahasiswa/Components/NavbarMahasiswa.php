<?php

namespace App\Livewire\Pages\Mahasiswa\Components;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Actions\Logout;

class NavbarMahasiswa extends Component
{
    public $code_pembelajaran;

    public function logout(Logout $logout)
    {
        $logout();

        $this->redirect('/', navigate: true);
    }

    public function render()
    {
        return view('livewire.pages.mahasiswa.components.navbar-mahasiswa', [
            'nama' => Auth::user()->mahasiswa->nama,
            'email' => Auth::user()->mahasiswa->email,
        ]);
    }
}
