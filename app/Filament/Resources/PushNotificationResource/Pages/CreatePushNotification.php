<?php

namespace App\Filament\Resources\PushNotificationResource\Pages;

use App\Models\Kelas;
use Filament\Actions;
use App\Models\Kelompok;
use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Notifications\SendPushNotification;
use App\Filament\Resources\PushNotificationResource;

class CreatePushNotification extends CreateRecord
{
    protected static string $resource = PushNotificationResource::class;


    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     if(isset($data['kelas']) && $data['kelas'] != []){
    //         foreach ($data['kelas'] as $key => $value) {
    //            $kelas= Kelas::find($value);
                
    //         }

    //     }elseif(isset($data['kelompok']) && $data['kelompok'] != []){
    //         dd('semua kelompok');
    //     }elseif(isset($data['mahasiswa']) && $data['mahasiswa'] != []){
    //         dd('salah satu nama mahasiswa');
    //     }else{
    //         dd('semua mahasiswa');
    //     }

    //     return $data;
    // }

    protected function handleRecordCreation(array $data): Model
    {
        
        $id_users = [];


        if(isset($data['kelas']) && $data['kelas'] != []){
            foreach ($data['kelas'] as $key => $value) {
                $mhs = Kelas::find($value)->mahasiswas()->get();
                foreach ($mhs as $key => $value) {
                    $id_users[]= $value->user_id;
                }
               
            }
        }elseif(isset($data['kelompok']) && $data['kelompok'] != []){
            foreach ($data['kelompok'] as $key => $value) {
                $mhs = Kelompok::find($value)->mahasiswas()->get();
                foreach ($mhs as $key => $value) {
                    $id_users[]= $value->user_id;
                }
               
            }
        }elseif(isset($data['mahasiswa']) && $data['mahasiswa'] != []){
           
            foreach ($data['mahasiswa'] as $key => $value) {
                $mhs = Mahasiswa::find($value);
                   $id_users[]= $mhs->user_id;   
            }
        }else{
           
            $mhs = Mahasiswa::all();
            foreach ($mhs as $key => $value) {
                $id_users[]= $value->user_id;
            }
          
        }
        
        
        $data_fix = array();
        $data_fix['title'] = $data['title'];
        $data_fix['body'] = $data['body'];
        $data_fix['image'] = $data['image'];
        $data_save = static::getModel()::create($data_fix);

        foreach($id_users as $key => $value){
            $data_save->users()->attach($value);
        }

        $users = $data_save->users()->get();


        $title = $data_save->title;
        $body = $data_save->body;
        $image = env('APP_URL').'/storage'.'/'. $data_save->image;

        foreach($users as $key => $value){
            $value->notify(new SendPushNotification($title,$body,$image,[]));
            Notification::make()
                ->title($title)
                ->body($body)
                ->actions([
                    Action::make('view')
                        ->button()
                        ->markAsRead(),
                ])
                ->sendToDatabase($value);;
        }


        return $data_save;


    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }


}
