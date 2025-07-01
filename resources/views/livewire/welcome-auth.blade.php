<?php

use function Livewire\Volt\{state, booted, layout};

layout('layouts.auth');

$masuk_dosen = function () {
    $this->redirectIntended(default: route('filament.admin.pages.dashboard', absolute: false), navigate: false);
};
$masuk_mahasiswa = function () {
    $this->redirectIntended(default: route('mahasiswa', absolute: false), navigate: false);
};

// booted(function () {
//     if (auth()->user()->dosen) {
//         $this->redirectIntended(default: route('filament.admin.pages.dashboard', absolute: false), navigate: false);
//     } else {
//         $this->redirectIntended(default: route('mahasiswa', absolute: false), navigate: false);
//     }
// });

?>

<div class="flex h-screen flex-col items-center justify-center gap-2">
    @if (auth()->user()->dosen)
        <p> Halo {{ auth()->user()->dosen->nama }},</p>
        <p>Silahkan masuk dashboard dosen</p>
        <button class="rounded-md bg-emerald-500 px-2 shadow-md hover:bg-emerald-400" wire:click='masuk_dosen'>Masuk</button>
    @else
        <p> Halo {{ auth()->user()->mahasiswa->nama }},</p>
        <p>Silahkan masuk dashboard mahasiswa</p>
        <button class="rounded-md bg-emerald-500 px-2 shadow-md hover:bg-emerald-400" wire:click='masuk_mahasiswa'>Masuk</button>
    @endif
</div>
