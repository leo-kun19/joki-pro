<?php

namespace App\Filament\Resources\MasterMateriResource\Pages;

use Filament\Actions;
use App\Models\Navbar;
use App\Models\MenuNavbar;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\MasterMateriResource;

class CreateMasterMateri extends CreateRecord
{
    protected static string $resource = MasterMateriResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        
        $data['slug'] = Str::slug($data['judul']);

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
       
        if($data['navbar_id'] != null){
            $navbar = Navbar::find($data['navbar_id']);
            $navbar->has_materi = true;
            $navbar->save();
            $data['menu_navbar_id'] = null;
        }else{
            $menu_navbar = MenuNavbar::find($data['menu_navbar_id']);
            $menu_navbar->has_materi = true;
            $menu_navbar->save();
        }

      
        return static::getModel()::create($data);
    }
}
