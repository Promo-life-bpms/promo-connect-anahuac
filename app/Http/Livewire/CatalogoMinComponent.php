<?php

namespace App\Http\Livewire;

use App\Models\Catalogo\GlobalAttribute;
use App\Models\Catalogo\Product as CatalogoProduct;
use App\Models\Catalogo\Provider as CatalogoProvider;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use App\Models\Catalogo\Product;

class CatalogoMinComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $nombre, $producto = '';

    protected $listeners = ['addProductNewQuote' => 'regresar'];

    public function render()
    {
        $utilidad = (float) config('settings.utility');

        $nombre = '%' . $this->nombre . '%';

        $products  = CatalogoProduct::where('name', 'LIKE', $nombre)->where('visible', true)
            ->where('products.visible', '=', true)
            ->whereIn('products.type_id', [1, 2])
            ->paginate(9);

        return view('livewire.catalogo-min-component', [
            'products' => $products,
            'utilidad' => $utilidad,
        ]);
    }
    public function seleccionarProducto(Product $product)
    {
        if ($product->provider_id == 5) {
            $cliente = new \nusoap_client('http://srv-datos.dyndns.info/doblevela/service.asmx?wsdl', 'wsdl');
            $error = $cliente->getError();
            if ($error) {
                echo 'Error' . $error;
            }
            //agregamos los parametros, en este caso solo es la llave de acceso
            $parametros = array('Key' => 't5jRODOUUIoytCPPk2Nd6Q==', 'codigo' => $product->sku_parent);
            //hacemos el llamado del metodo
            $resultado = $cliente->call('GetExistencia', $parametros);
            $msg = '';
            if (array_key_exists('GetExistenciaResult', $resultado)) {
                $informacionExistencias = json_decode(utf8_encode($resultado['GetExistenciaResult']))->Resultado;
                if (count($informacionExistencias) > 1) {
                    foreach ($informacionExistencias as $productExistencia) {
                        if ($product->sku == $productExistencia->CLAVE) {
                            $product->stock = $productExistencia->EXISTENCIAS;
                            $product->save();
                            break;
                        }
                        $msg = "Este producto no se encuentra en el catalogo que esta enviado DV via Servicio WEB";
                    }
                } else {
                    $msg = "Este producto no se encuentra en el catalogo que esta enviado DV via Servicio WEB";
                }
            } else {
                $msg = "No se obtuvo informacion acerca del Stock de este producto. Es posible que los datos sean incorrectos";
            }
        }
        $this->producto = $product;
    }

    public function regresar()
    {
        $this->producto = '';
    }
}
