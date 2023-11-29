<?php

namespace App\Http\Livewire;

use App\Models\Settings;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SettingsComponent extends Component
{
    public $selectedProviders = [];
    public $radioValue = '';


    public function render()
    {
        $settings = Settings::all();
        $providers = DB::connection('mysql_catalogo')->table('providers')->get();

        return view('livewire.settings-component', compact('settings', 'providers'));
    }

    public function saveProviders($providerId)
    {
        $settingsProviders = Settings::where('slug', 'providers')->first();

        $proveedores = trim($settingsProviders->value) == '' ? [] : explode(',', trim($settingsProviders->value));
        $index = array_search($providerId, $proveedores);
        if ($index === false) {
            // Si no existe, agregarlo
            array_push($proveedores, $providerId);
        } else {
            // Si existe, eliminarlo
            unset($proveedores[$index]);
        }
        $proveedores = implode(',', $proveedores);
        $settingsProviders->value = $proveedores;
        $settingsProviders->save();

        $this->dispatchBrowserEvent('hide-modal');
    }
}
