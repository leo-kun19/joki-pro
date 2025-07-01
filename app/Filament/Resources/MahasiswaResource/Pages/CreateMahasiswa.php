<?php

namespace App\Filament\Resources\MahasiswaResource\Pages;

use App\Filament\Resources\MahasiswaResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateMahasiswa extends CreateRecord
{
    protected static string $resource = MahasiswaResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $user = User::create([
            'name' => $data['nama'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $data = [
            'nama' => $data['nama'],
            'user_id' => $user->id,
            'nim' => $data['nim'],
            'email' => $data['email'],
            'no_wa' => $data['no_wa'],
            'pas_photo' => $data['pas_photo'],
            'nim' => $data['nim'],
            'angkatan' => $data['angkatan'],
            'program_studi' => $data['program_studi'],
            'is_active' => $data['is_active'],
            'kelas_id' => $data['kelas_id'],
        ];

        return static::getModel()::create($data);

    }
}
