<?php

namespace App\Http\Livewire;

use App\Models\Catalogo\Category;
use App\Models\Catalogo\GlobalAttribute;
use App\Models\Catalogo\Product as CatalogoProduct;
use App\Models\Catalogo\Provider as CatalogoProvider;
use App\Models\Settings;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class Catalogo extends Component
{
    use WithPagination;

    public $category;

    public $nombre, $proveedor, $color, $precioMax, $precioMin, $stockMax, $stockMin, $orderStock = '', $orderPrice = '';
    public $search;

    public $settings = [];

    public function __construct()
    {
        $utilidad = (float) config('settings.utility');
        $price = DB::connection('mysql_catalogo')->table('products')->max('price');
        $this->precioMax = round($price + $price * ($utilidad / 100), 2);
        $this->precioMin = 0;
        $stock = DB::connection('mysql_catalogo')->table('products')->max('stock');
        $this->stockMax = $stock;
        $this->stockMin = 0;
    }

    public function mount()
    {
        try {
            $this->search = session()->get('busqueda', "");
            session()->put('busqueda', '');
            $this->nombre = $this->search;

            if (session()->get('category', "")) {
                $this->changeCategory(session()->get('category', ""));
                session()->put('category', '');
            }
        } catch (Exception $th) {
            //throw $th;
        }

        // Setear a los valores de porveedores en settings
        $providerSeleccionados = Settings::where('slug', 'providers')->first();
        $providerSeleccionados = trim($providerSeleccionados->value) == '' ? [] : explode(',', trim($providerSeleccionados->value));
        $this->settings['providers'] = $providerSeleccionados;
        $utilidad = (float) config('settings.utility');

        $price = DB::connection('mysql_catalogo')->table('products')->max('price');
        $this->precioMax = round($price + $price * ($utilidad / 100), 2);
        $this->precioMin = 0;
        $stock = DB::connection('mysql_catalogo')->table('products')->max('stock');
        $this->stockMax = $stock;
        $this->stockMin = 0;
    }

    public function render()
    {
        $utilidad = (float) config('settings.utility');

        // Agrupar Colores similares
        $price = DB::connection('mysql_catalogo')->table('products')->max('price');
        $price = round($price + $price * ($utilidad / 100), 2);
        $stock = DB::connection('mysql_catalogo')->table('products')->max('stock');
        $nombre = '%' . $this->nombre . '%';
        $color = $this->color;
        $category = $this->category;
        $precioMax = $price;
        if ($this->precioMax != null) {
            $precioMax =  round($this->precioMax / (($utilidad / 100) + 1), 2);
        }
        $precioMin = 0;
        if ($this->precioMin != null) {
            $precioMin =  round($this->precioMin / (($utilidad / 100) + 1), 2);
        }
        $stockMax =  $this->stockMax;
        $stockMin =  $this->stockMin;
        if ($stockMax == null) {
            $stockMax = $stock;
        }

        if ($stockMin == null) {
            $stockMin = 0;
        }
        $categories = Category::withCount('productCategories')
            ->orderBy('product_categories_count', 'DESC')
            ->where('family', 'not like', '%textil%')
            ->limit(8)
            ->get();
        $products = CatalogoProduct::leftjoin('product_category', 'product_category.product_id', 'products.id')
            ->leftjoin('categories', 'product_category.category_id', 'categories.id')
            ->leftjoin('colors', 'products.color_id', 'colors.id')
            ->where('products.name', 'LIKE', $nombre)
            ->where('products.visible', '=', true)
            ->where('products.price', '>', 0)
            ->whereIn('products.provider_id', $this->settings['providers'])
            ->whereBetween('products.price', [$precioMin, $precioMax])
            ->whereBetween('products.stock', [$stockMin, $stockMax])
            ->whereIn('products.type_id', [1])
            ->when($color !== '' && $color !== null, function ($query, $color) {
                $newColor  = '%' . $this->color . '%';
                $query->where('colors.color', 'LIKE', $newColor);
            })
            ->when($category !== '' && $category !== null, function ($query, $category) {
                $query->where('categories.id', $this->category);
            })
            ->select('products.*')
            ->paginate(32);

        return view('pages.catalogo.catalogoComponent', [
            'products' => $products,
            'categories' => $categories,
            'utilidad' => $utilidad,
            'price' => $price,
            'priceMax' => $precioMax,
            'priceMin' => $precioMin,
            'stock' => $stock,
            'stockMax' => $stockMax,
            'stockMin' => $stockMin,
        ]);
    }
    public function paginationView()
    {
        return 'vendor.livewire.tailwind';
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function limpiar()
    {
        $this->nombre = '';
        $this->color = '';
        $this->category = '';
        $this->proveedor = null;
        $this->orderPrice = '';
        $this->orderStock = '';
    }

    public function changeCategory($category_id)
    {
        $this->category =  $this->category == $category_id ? null : $category_id;
    }
}
