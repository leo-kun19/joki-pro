<?php

namespace App\Filament\Pages;

use App\Models\AppearanceSetting;
use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Group;
use Filament\Notifications\Notification;

class AppearanceSettings extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';
    protected static string $view = 'filament.pages.appearance-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(
            AppearanceSetting::firstOrCreate([])->toArray()
        );
    }

    public function save(): void
    {
        $state = $this->form->getState();

        AppearanceSetting::updateOrCreate([], $state);

        Notification::make()
            ->title('Pengaturan tampilan berhasil disimpan.')
            ->success()
            ->send();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make([
                    Select::make('font_family')
                        ->label('Font')
                        ->options([
                            'Cambria' => 'Cambria',
                            'Arial' => 'Arial',
                            'Times New Roman' => 'Times New Roman',
                            'Verdana' => 'Verdana',
                            'Georgia' => 'Georgia',
                            'Trebuchet MS' => 'Trebuchet MS',
                            'Courier New' => 'Courier New',
                            'Tahoma' => 'Tahoma',
                            'Helvetica' => 'Helvetica',
                            'Lucida Console' => 'Lucida Console',
                            'Segoe UI' => 'Segoe UI',
                            'Impact' => 'Impact',
                            'Palatino Linotype' => 'Palatino Linotype',
                            'Gill Sans' => 'Gill Sans',
                            'Garamond' => 'Garamond',
                            'Monaco' => 'Monaco',
                            'Brush Script MT' => 'Brush Script MT',
                        ])
                        ->required(),


                    Select::make('font_size')
                        ->label('Ukuran Font')
                        ->options([
                            'extra-small' => 'Sangat Kecil',
                            'small' => 'Kecil',
                            'normal' => 'Normal',
                            'medium' => 'Sedang',
                            'large' => 'Besar',
                            'extra-large' => 'Sangat Besar',
                        ])
                        ->required(),


                    ColorPicker::make('font_color')
                        ->label('Warna Huruf')
                        ->required(),

                    ColorPicker::make('background_color')
                        ->label('Warna Latar Umum')
                        ->required(),

                    ColorPicker::make('menu_background_color')
                        ->label('Warna Latar Menu')
                        ->required(),

                    ColorPicker::make('submenu_background_color')
                        ->label('Warna Latar Submenu')
                        ->required(),

                    ColorPicker::make('menu_hover_color')
                        ->label('Warna Hover Menu/Submenu')
                        ->required(),

                    ColorPicker::make('menu_active_color')
                        ->label('Warna Aktif Menu/Submenu')
                        ->required(),

                ])->columns(2),
            ])
            ->statePath('data');
    }
}
