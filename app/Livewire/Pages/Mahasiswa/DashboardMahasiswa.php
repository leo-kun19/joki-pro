<?php

namespace App\Livewire\Pages\Mahasiswa;

use Livewire\Component;
use Livewire\Attributes\Title;

use App\Models\Pembelajaran;
use Illuminate\Support\Facades\Auth;

class DashboardMahasiswa extends Component
{

    public function mount() {}


    #[Title('Dashboard Mahasiswa')]
    public function render()
    {
        $mahasiswa = Auth::user()->mahasiswa;

        $pembelajaran = $mahasiswa
            ? Pembelajaran::where('kelas_id', $mahasiswa->kelas_id)->get()
            : collect(); // kalau null, kembalikan collection kosong

        return view('livewire.pages.mahasiswa.dashboard-mahasiswa', [
            'pembelajaran' => $pembelajaran
        ]);
    }
}
