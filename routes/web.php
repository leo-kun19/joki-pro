<?php


use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SendTokenFcm;
use App\Livewire\Pages\Mahasiswa\ChatDosen;
use App\Livewire\Pages\Mahasiswa\Dashboard;
use App\Livewire\Pages\Mahasiswa\MasterSoal;
use App\Livewire\Pages\Mahasiswa\ChatDiskusi;
use App\Livewire\Pages\Mahasiswa\MasterMateri;
use App\Livewire\Pages\Mahasiswa\DashboardMahasiswa;
use App\Livewire\Pages\Mahasiswa\DashboardPertemuan;


Route::get('/', function () {
    if (Auth::user()) {
        if (Auth::user()->dosen) {
            return redirect()->route('filament.admin.pages.dashboard');
        } else {
            return redirect()->route('mahasiswa');
        }
    } else {
        return redirect()->route('login');
    }
})->name('home');

Volt::route('/auth', 'welcome-auth')->name('auth-welcome');

Route::get('mahasiswa/', DashboardMahasiswa::class)
    ->middleware(['auth', 'verified'])
    ->name('mahasiswa');

Route::post('send-token-fcm/', SendTokenFcm::class)
    ->middleware(['auth', 'verified']);

Route::get('mahasiswa/', DashboardMahasiswa::class)
    ->middleware(['auth', 'verified'])
    ->name('mahasiswa');

Route::get('pembelajaran/{code_pembelajaran}', DashboardPertemuan::class)
    ->middleware(['auth', 'verified'])
    ->name('pembelajaran.dashboard');

Route::get('pembelajaran/{code_pembelajaran}/{master_soal_id}', MasterSoal::class)
    ->middleware(['auth', 'verified'])
    ->name('pembelajaran.master_soal');

Route::get('materi/{code_pembelajaran}/{master_materi_id}', MasterMateri::class)
    ->middleware(['auth', 'verified'])
    ->name('pembelajaran.master_materi');

Route::get('chat-dosen/{master_soal_id}/{mahasiswa_id}', ChatDosen::class)
    ->middleware(['auth', 'verified'])
    ->name('chat-dosen');

Route::get('chat-diskusi/{master_soal_id}/{soal_id}/{kelompok_id}', ChatDiskusi::class)
    ->middleware(['auth', 'verified'])
    ->name('chat-diskusi');

Route::get('/csrf-token', function () {
    return response()->make(csrf_token());
});


Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::get('/generate', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    echo 'ok';
});


Route::get('logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


Route::get('/livewire/update', function () {
    Log::info('GET /livewire/update triggered by: ', [
        'url' => url()->previous(),
        'ip' => request()->ip(),
        'headers' => request()->headers->all(),
    ]);
    return response('', 204); // 204 No Content
});

// web.php
Route::get('/keep-alive', fn() => response()->noContent());


require __DIR__ . '/auth.php';
