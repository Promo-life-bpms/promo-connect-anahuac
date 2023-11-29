<?php

namespace App\Http\Livewire;

use App\Models\Catalogo\Category;
use Livewire\Component;

class MenuCategories extends Component
{
    public $latestCategorias;

    public function mount()
    {
        $this->latestCategorias = Category::withCount('productCategories')
            ->orderBy('product_categories_count', 'DESC')
            ->where('family', 'not like', '%textil%')
            ->limit(6)
            ->get();
    }

    public function render()
    {


        return view('livewire.menu-categories');
    }
}
