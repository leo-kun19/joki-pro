<?php

namespace App\Filament\Resources\MasterMateriResource\Pages;

use Filament\Actions;
use App\Models\Navbar;
use App\Models\MenuNavbar;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\MasterMateriResource;
use App\Models\MasterMateri;

class EditMasterMateri extends EditRecord
{
    protected static string $resource = MasterMateriResource::class;

    

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
       
        $master_materi = MasterMateri::find($record->id);
         
       if($master_materi->navbar_id){
            $navbar = Navbar::find($master_materi->navbar_id);
            $navbar->has_materi = false;
            $navbar->save();
        }else{
            $menu_navbar = MenuNavbar::find($master_materi->navbar_id);
            if($menu_navbar){
            $menu_navbar->has_materi = false;
            $menu_navbar->save();
            }
          
        }

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
        
        $record->update($data);
    
        return $record;
    }

   
}
