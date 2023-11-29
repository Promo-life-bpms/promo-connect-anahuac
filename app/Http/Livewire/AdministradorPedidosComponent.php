<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Muestra;
use App\Models\Catalogo\Product;
use Livewire\WithPagination;

class AdministradorPedidosComponent extends Component
{
    use WithPagination;

    public $search;

    public function render()
    {
        $db = config('database.connections.mysql_catalogo.database');
        $userproducts = Muestra::join('users', 'users.id', 'muestras.user_id')
            ->join($db . ".products",  'muestras.product_id', $db . ".products.id")
            ->select('users.name as user_name', 'products.name as product_name as product_name', 'muestras.updated_at', 'muestras.address',  'muestras.status', 'muestras.current_quote_id', 'muestras.id as id_muestra')
            ->where("products.name",  "LIKE", "%" . $this->search . "%")
            ->orWhere("users.name", "LIKE", "%" . $this->search . "%")
            ->get();
        // dd($userproducts);

        return view('livewire.administrador-pedidos-component', ['muestras' => $userproducts]);
    }
}
