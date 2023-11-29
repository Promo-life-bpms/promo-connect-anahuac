<?php

namespace App\Http\Livewire;

use App\Models\Muestra;
use Livewire\Component;
use Livewire\WithPagination;

class ListarMuestrasComponent extends Component
{
    use WithPagination;
    public $search;

    public function goBack()
    {
        return redirect()->route('index');
    }


    public function render()
    {
        $userproducts = auth()->user()->muestras()->orderBy('created_at', 'desc')->paginate(10);
        return view('livewire.listar-muestras-component', ['muestras' => $userproducts]);
    }

    public function paginationView()
    {
        return 'vendor.livewire.tailwind';
    }
}
