<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SearchingComponent extends Component
{
    public $search;
    public function render()
    {
        return view('livewire.searching-component');
    }

    public function buscar()
    {
        session()->put('busqueda', $this->search);
        return redirect('/catalogo');
    }
}
