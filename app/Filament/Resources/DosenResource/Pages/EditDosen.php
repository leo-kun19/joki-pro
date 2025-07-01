<?php

namespace App\Filament\Resources\DosenResource\Pages;

use App\Filament\Resources\DosenResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditDosen extends EditRecord
{
    protected static string $resource = DosenResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {

        $user = User::find($record->user_id);

        $user->update([
            'name' => $data['nama'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $data = [
            'nama' => $data['nama'],
            'user_id' => $user->id,
            'code' => $data['code'],
            'email' => $data['email'],
            'no_wa' => $data['no_wa'],
            'pas_photo' => $data['pas_photo'],

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
