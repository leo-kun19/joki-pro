<?php

namespace App\Livewire\Pages\Mahasiswa;

use Livewire\Component;
use App\Models\Pembelajaran;
use Livewire\Attributes\Title;
use App\Models\AppearanceSetting;
use Illuminate\Support\Facades\Schema;

class DashboardPertemuan extends Component
{
    public $code_pembelajaran;

    public function mount()
    {
        $pembelajaran = Pembelajaran::where('code', $this->code_pembelajaran)->first();
        if (!$pembelajaran) {
            return abort(404);
        }
    }

    #[Title('Dashboard Pertemuan')]
    public function render()
    {
        $setting = null;

        if (Schema::hasTable('appearance_settings')) {
            $setting = AppearanceSetting::first();
        }
        return view('livewire.pages.mahasiswa.dashboard-pertemuan', [
            'pembelajaran' => Pembelajaran::where('code', $this->code_pembelajaran)->first(),
            'setting' => $setting
        ]);
    }
}
