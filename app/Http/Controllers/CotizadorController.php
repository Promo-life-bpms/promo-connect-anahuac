<?php

namespace App\Http\Controllers;

use App\Mail\SendDataErrorCreateQuote;
use App\Models\Banner;
use App\Models\Catalogo\Category;
use App\Models\Catalogo\GlobalAttribute;
use App\Models\Catalogo\Product;
use App\Models\Client;
use App\Models\CommentsSupport;
use App\Models\Muestra;
use App\Models\Quote;
use App\Models\QuoteDiscount;
use App\Models\QuoteInformation;
use App\Models\User;
use App\Notifications\PurchaseMadeNotification;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use SimpleXMLElement;

class CotizadorController extends Controller
{
    // use WithPagination;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $valores = [];
        for ($x = 0; $x < 100; $x++) {
            $num_aleatorio = rand(1, 14000);
            array_push($valores, $num_aleatorio);
        }

        $valores2 = [];
        for ($x = 0; $x < 100; $x++) {
            $num_aleatorio = rand(1, 14000);
            array_push($valores2, $num_aleatorio);
        }

        // Obtener los banner visibles, del primero al último
        $banners = Banner::where('visible', true)->orderBy('created_at', 'desc')->get();

        $getLatestProducts = Product::whereIn('id', $valores2)->get();
        $latestCategorias = Category::withCount('productCategories')
            ->orderBy('product_categories_count', 'DESC')
            ->where('family', 'not like', '%textil%')
            ->limit(6)
            ->get();
        $getmoreProducts = Product::whereIn('id', $valores)->get();

        $moreProducts = [];
        $latestProducts = [];
        $validColorIds = [2, 3, 12, 13, 41, 44, 48, 53, 54, 58, 60, 62, 63, 68, 69, 70, 78, 81];

        foreach ($getmoreProducts as  $getmoreProduct) {
            if (isset($getmoreProduct->color->id)) {
                if (in_array($getmoreProduct->color->id, $validColorIds) && count($moreProducts) < 6) {
                    array_push($moreProducts, $getmoreProduct);
                }
            }
        }

        foreach ($getLatestProducts as  $getmoreProduct2) {
            if (isset($getmoreProduct2->color->id)) {
                if (in_array($getmoreProduct2->color->id, $validColorIds) && count($latestProducts) < 6) {
                    array_push($latestProducts, $getmoreProduct2);
                }
            }
        }

        return view('home', compact('latestProducts', 'latestCategorias', 'moreProducts', 'banners'));
    }

    public function categoryfilter($category)
    {
        session()->put('category', $category);
        return redirect('/catalogo');
    }

    public function catalogo()
    {
        return view('pages.catalogo.catalogo');
    }

    public function verProducto(Product $product)
    {
        $utilidad = (float) config('settings.utility');
        $msg = '';
        // Consultar las existencias de los productos en caso de ser de Doble Vela.
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
        return view('pages.catalogo.product', compact('product', 'utilidad', "msg"));
    }

    public function cotizacion()
    {
        $cotizacionActual = [];

        $total = 0;
        if (auth()->user()->currentQuote) {
            $cotizacionActual = auth()->user()->currentQuote->currentQuoteDetails;
            $total = $cotizacionActual->sum('precio_total');
        }
        return view('pages.catalogo.cotizacion-actual', compact('cotizacionActual', 'total'));
    }

    public function procesoMuestra($id)
    {
        return view('pages.catalogo.proceso-muestra', compact('id'));
    }

    public function infoperfil($id)
    {
        $datainforusers = User::where("id", $id)->select("users.*")->get();
        $db = config('database.connections.mysql_catalogo.database');
        $userproducts = Muestra::join('users', 'users.id', 'muestras.user_id')
            ->join($db . ".products",  'muestras.product_id', $db . ".products.id")
            ->select('users.name as user_name', 'products.name as product_name as product_name', 'muestras.updated_at', 'muestras.address',  'muestras.current_quote_id', 'muestras.id as id_muestra')
            ->where('users.id', $id)
            ->get();

        $usercompras = Quote::join('users', 'users.id', 'quotes.user_id')
            ->join('quote_updates', 'quote_updates.quote_id', 'quotes.id')
            ->join('quote_products', 'quote_products.id', 'quote_updates.id')
            ->where('users.id', $id)
            ->get();

        $longitudcompras = count($usercompras);
        $longitudmuestras = count($userproducts);
        return view('pages.catalogo.info-user', compact('id'), ['infouser' => $datainforusers, 'muestras' => $userproducts, 'longitudmuestras' => $longitudmuestras, 'compras' => $usercompras, 'longitudcompras' => $longitudcompras]);
    }

    public function administrador()
    {
        return view('pages.catalogo.administrador');
    }

    public function administradorcompras()
    {
        return view('pages.catalogo.administradorcompras');
    }

    public function administradorpedidos()
    {
        return view('pages.catalogo.administradorpedidos');
    }


    public function cotizaciones()
    {
        return view('pages.catalogo.cotizaciones');
    }
    public function muestras()
    {
        return view('pages.catalogo.muestras');
    }

    public function settings()
    {
        return view('pages.catalogo.settings');
    }

    public function verCotizacion(Quote $quote)
    {
        return view('pages.catalogo.ver-cotizacion', compact('quote'));
    }

    public function finalizar()
    {
        return view('pages.catalogo.finalizar');
    }
    public function previsualizar(Quote $quote)
    {
        $pdf = \PDF::loadView('pages.pdf.bh', ['quote' => $quote, 'nombreComercial' => ""]);
        $pdf->setPaper('Letter', 'portrait');
        return $pdf->stream("QS-" . $quote->id . " " . $quote->latestQuotesUpdate->quotesInformation->oportunity . ' ' . $quote->updated_at->format('d/m/Y') . '.pdf');
    }


    public function all()
    {
        return view('pages.catalogo.cotizaciones-all');
    }
    public function dashboard()
    {
        return view('pages.catalogo.dashboard');
    }

    public function exportUsuarios()
    {

        $documento = new Spreadsheet();
        $documento
            ->getProperties()
            ->setCreator("Aquí va el creador, como cadena")
            ->setLastModifiedBy('Parzibyte') // última vez modificado por
            ->setTitle('Mi primer documento creado con PhpSpreadSheet')
            ->setSubject('El asunto')
            ->setDescription('Este documento fue generado para parzibyte.me')
            ->setKeywords('etiquetas o palabras clave separadas por espacios')
            ->setCategory('La categoría');

        $nombreDelDocumento = "Reporte de Usuarios con corte al " . now()->format('d-m-Y') . ".xlsx";

        $hoja = $documento->getActiveSheet();
        $hoja->setTitle("Usuarios");
        $users = User::where('visible', 1)->get();
        $i = 2;
        $hoja->setCellValueByColumnAndRow(1, 1,  'Nombre');
        $hoja->setCellValueByColumnAndRow(2, 1,  'Apellido');
        $hoja->setCellValueByColumnAndRow(3, 1,  'Correo');
        $hoja->setCellValueByColumnAndRow(4, 1,  'Ultimo Inicio de Sesion');

        foreach ($users as $user) {
            $hoja->setCellValueByColumnAndRow(1, $i,  $user->name);
            $hoja->setCellValueByColumnAndRow(2, $i,  $user->lastname);
            $hoja->setCellValueByColumnAndRow(3, $i,  $user->email);
            $hoja->setCellValueByColumnAndRow(4, $i,  $user->last_login != null ? $user->last_login : "No hay Registro");
            $i++;
        }

        /**
         * Los siguientes encabezados son necesarios para que
         * el navegador entienda que no le estamos mandando
         * simple HTML
         * Por cierto: no hagas ningún echo ni cosas de esas; es decir, no imprimas nada
         */

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($documento, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    public function enviarCompra(Request $request)
    {
        if (Auth::user()->hasRole('seller')) {
            return 'No tienes permisos para realizar esta acción';
        }

        $currentSale = auth()->user()->currentQuote;

        $quote = [
            'iva_by_item' => 1,
            'address_id' => $request->direccionSeleccionada,
            'show_total' => 1,
            'logo' => '',
            'status' => 0,
            'quote_info' => [
                'name' => "Cliente",
                'company' => "Company",
                'email' => "email",
                'landline' => 00001,
                'cell_phone' => 00001,
                'oportunity' => "Oportunidad",
                'rank' => 1,
                'department' => "Departamento",
                'information' => "Info",
                'tax_fee' => 0,
                'shelf_life' =>  10,
            ],
            "quoteProducts" => [],
        ];


        // Ligar Productos al update

        // Guardar los productos de la cotizacion
        foreach (auth()->user()->currentQuote->currentQuoteDetails as $item) {
            $product = Product::find($item->product_id);
            // Agregar la URL de la Imagen
            $product->image = $item->images_selected == null ? ($product->firstImage == null ? '' : $product->firstImage->image_url) : $item->images_selected;
            unset($product->firstImage);
            $product->provider;

            $dataProduct = [
                'product' => json_encode($product->toArray()),
                'technique' =>  json_encode(["price_technique" => $item->price_technique]),
                'new_description' => "jid",
                'color_logos' => $item->color_logos,
                'costo_indirecto' => 0,
                'utilidad' => 0,
                'dias_entrega' => $item->dias_entrega,
            ];
            $price_tecnica = $item->price_technique;
            $dataProduct['prices_techniques'] = $price_tecnica;
            $dataProduct['cantidad'] = $item->cantidad;
            $dataProduct['costo_unitario'] = $item->costo_unitario;
            $dataProduct['costo_total'] = $item->costo_total;
            $dataProduct['quote_by_scales'] = false;
            $dataProduct['scales_info'] = null;
            array_push($quote['quoteProducts'], $dataProduct);
        }


        // Buscar usuarios con el rol de vendedor y gerente de compras
        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['buyers-manager', 'seller']);
        })->get();
        /* foreach ($users as $user) {
            // Enviar notificacion a los usuarios con el rol de vendedor y gerente de compras
            $user->notify(new PurchaseMadeNotification(auth()->user()->name));
        }*/

        $datosToSend = [
            "email" => auth()->user()->email,
            "token" => auth()->user()->punchoutSession->token,
            "total_cost" => 0,
            "total_cost_with_iva" => 0,
            "total_price" => 0,
            "total_price_with_iva" => 0,
            "currency" => "MXN",
            "products" => []
        ];

        foreach ($currentSale->currentQuoteDetails as $currentQuote) {
            $data["supplier_part_id"] = $currentQuote->product->internal_sku;
            $data["description"] = $currentQuote->product->description;
            $data["unit_cost"] = (float) $currentQuote->costo_unitario;
            $data["unit_cost_with_iva"] = round($data["unit_cost"] * 1.16, 2);
            $data["unit_price"] = round(($currentQuote->costo_unitario / ((100 - config("settings.utility_aditional")) / 100)));
            $data["unit_price_with_iva"] = round($data["unit_price"] * 1.16, 2);
            $data["quantity"] = $currentQuote->cantidad;
            $data["quantity"] = $currentQuote->cantidad;
            $data['print_customization_id'] = 1;
            $data['url_image'] = $currentQuote->logo ? asset('storage/logos/' . $currentQuote->logo) : '';
            array_push($datosToSend["products"], $data);

            $datosToSend["total_cost"] += ($data["unit_cost"] * $data["quantity"]);
            $datosToSend["total_cost_with_iva"] += ($data["unit_cost_with_iva"] * $data["quantity"]);
            $datosToSend["total_price"] += ($data["unit_price"] * $data["quantity"]);
            $datosToSend["total_price_with_iva"] += ($data["unit_price_with_iva"] * $data["quantity"]);
        }

        $url = config("settings.url_post_cart");
        $datosToSendString = json_encode($datosToSend);

        // Eliminar carrito
        auth()->user()->currentQuote->currentQuoteDetails()->delete();
        auth()->user()->currentQuote()->delete();

        return view('pages.catalogo.submitCoupa', compact('url', 'datosToSendString'));
    }
}
