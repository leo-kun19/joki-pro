<?php

namespace App\Filament\Resources\DosenResource\Pages;

use App\Filament\Resources\DosenResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class CreateDosen extends CreateRecord
{
    protected static string $resource = DosenResource::class;

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
            'code' => $data['code'],
            'email' => $data['email'],
            'no_wa' => $data['no_wa'],
            'pas_photo' => $data['pas_photo'],

        ];

        $recipient = User::first();

        Notification::make()
            ->title('Saved successfully')
            ->sendToDatabase($recipient);


        return static::getModel()::create($data);
    }
}
