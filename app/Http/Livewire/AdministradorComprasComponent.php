<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Quote;

class AdministradorComprasComponent extends Component
{
    public $search;
    // public function regresarPaginaAnterior()
    // {
    //     return redirect()->route('administrador');
    // }
    public function render()
    {
        // $q = Quote::all();
        $usercompras = Quote::join('users', 'users.id', 'quotes.user_id')
            ->join('quote_updates', 'quote_updates.quote_id', 'quotes.id')
            ->join('quote_products', 'quote_products.id', 'quote_updates.id')
            ->where("users.name", "LIKE", "%" . trim($this->search) . "%")
            ->orderBy("quotes.created_at", "desc")
            ->paginate(15);
        return view('livewire.administrador-compras-component', ['compras' => $usercompras]);
    }
}
