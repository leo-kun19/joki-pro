<?php

namespace App\Filament\Resources\MahasiswaResource\Pages;

use App\Filament\Resources\MahasiswaResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditMahasiswa extends EditRecord
{
    protected static string $resource = MahasiswaResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $user = User::find($record->user_id);

        $user->update([
            'name' => $data['nama'],
            'email' => $data['email'],
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

        $record->update($data);

        return $record;

    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
