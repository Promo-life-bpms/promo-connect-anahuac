<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Client;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class TableUsuariosComponent extends Component
{
    use WithPagination;
    public $search;

    public function render()
    {
        $users = User::join('role_user', 'role_user.user_id', 'users.id')
            ->whereIn("role_user.role_id", [4, 3])
            ->where("name", "LIKE", "%" . $this->search . "%")->paginate(10);
        return view('livewire.table-usuarios-component', ['users' => $users]);
    }

    public function administrador()
    {
        return view('pages.catalogo.administrador');
    }

    public function updated() {
        $this->resetPage();
    }
}
