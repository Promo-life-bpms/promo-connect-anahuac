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
        for ($x = 0; $x < 6; $x++) {
            $num_aleatorio = rand(1, 14000);
            array_push($valores, $num_aleatorio);
        }

        // Obtener los banner visibles, del primero al último
        $banners = Banner::where('visible', true)->orderBy('created_at', 'desc')->get();

        $latestProducts = Product::where('provider_id', '1982')
            ->orderBy('created_at', 'desc') 
            ->limit(6) 
            ->get();

        $latestCategorias = Category::withCount('productCategories')
            ->orderBy('product_categories_count', 'DESC')
            ->where('family', 'not like', '%textil%')
            ->limit(6)
            ->get();
        $moreProducts = Product::where('provider_id', '1982')
            ->take(6) 
            ->get();
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
        $request->validate(['direccionSeleccionada' => 'required']);

        if (Auth::user()->hasRole('seller')) {
            return 'No tienes permisos para realizar esta acción';
        }

        $currentSale = auth()->user()->currentQuote;

        $quote = auth()->user()->quotes()->create([
            'iva_by_item' => 1,
            'address_id' => $request->direccionSeleccionada,
            'show_total' => 1,
            'logo' => '',
            'status' => 0
        ]);

        // Guardar la Info de la cotizacion
        $quoteInfo = QuoteInformation::create([
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
        ]);

        // Guardar descuento
        $type = 'Fijo';
        $value = 0;
        $discount = false;
        if (auth()->user()->currentQuote->discount) {
            $discount = true;
            $type = auth()->user()->currentQuote->type;
            $value = auth()->user()->currentQuote->value;
        }

        $dataDiscount = [
            'discount' => $discount,
            'type' => $type,
            'value' => $value,
        ];

        $quoteDiscount = QuoteDiscount::create($dataDiscount);

        // Guardar la actualizacion
        $quoteUpdate = $quote->quotesUpdate()->create([
            'quote_information_id' => $quoteInfo->id,
            'quote_discount_id' => $quoteDiscount->id,
            'type' => "created"
        ]);

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
            $dataProduct['precio_unitario'] = $item->precio_unitario;
            $dataProduct['precio_total'] = $item->precio_total;
            $dataProduct['quote_by_scales'] = false;
            $dataProduct['scales_info'] = null;

            $quoteUpdate->quoteProducts()->create($dataProduct);
        }

        // Buscar usuarios con el rol de vendedor y gerente de compras
        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['buyers-manager', 'seller']);
        })->get();

        foreach ($users as $user) {
            // Enviar notificacion a los usuarios con el rol de vendedor y gerente de compras
            $user->notify(new PurchaseMadeNotification(auth()->user()->name));
        }




        // Crear un nuevo objeto SimpleXMLElement
        $xml = new SimpleXMLElement('<!DOCTYPE cXML SYSTEM "http://xml.cxml.org/schemas/cXML/1.2.014/cXML.dtd"><cXML></cXML>');

        // Agregar atributos al elemento cXML
        $xml->addAttribute('payloadID', '1686259207.6514087@stg791app53.int.coupahost.com');
        $xml->addAttribute('xml:lang', 'en-US');
        $xml->addAttribute('timestamp', now());
        $xml->addAttribute('version', '1.2.0.14');

        // Agregar el elemento Header
        $header = $xml->addChild('Header');

        // Agregar el elemento From dentro de Header
        $from = $header->addChild('From');
        $fromCredential = $from->addChild('Credential');
        $fromCredential->addAttribute('domain', 'NetworkID');
        $fromCredential->addChild('Identity', auth()->user()->email);

        // Agregar el elemento To dentro de Header
        $to = $header->addChild('To');
        $toCredential = $to->addChild('Credential');
        $toCredential->addAttribute('domain', 'NetworkId');
        $toCredential->addChild('Identity', auth()->user()->email);

        // Agregar el elemento Sender dentro de Header
        $sender = $header->addChild('Sender');
        $senderCredential = $sender->addChild('Credential');
        $senderCredential->addAttribute('domain', 'NetworkID');
        $senderCredential->addChild('Identity', auth()->user()->email);
        $senderCredential->addChild('SharedSecret', auth()->user()->punchoutSession->sharesecret);
        $sender->addChild('UserAgent', 'bhtrade');

        // Agregar el elemento Message
        $message = $xml->addChild('Message');
        // Agregar el elemento PunchOutOrderMessage dentro de Message
        $punchOutOrderMessage = $message->addChild('PunchOutOrderMessage');
        $punchOutOrderMessage->addChild('BuyerCookie', auth()->user()->punchoutSession->cookie);
        // Agregar el elemento PunchOutOrderMessageHeader dentro de PunchOutOrderMessage
        $punchOutOrderMessageHeader = $punchOutOrderMessage->addChild('PunchOutOrderMessageHeader');
        $punchOutOrderMessageHeader->addAttribute('operationAllowed', 'edit');

        // Agregar el elemento Total dentro de PunchOutOrderMessageHeader
        $total = $punchOutOrderMessageHeader->addChild('Total');
        $money = $total->addChild('Money', $currentSale->currentQuoteDetails->sum('precio_total'));
        $money->addAttribute('currency', 'MXN');
        foreach ($currentSale->currentQuoteDetails as $currentQuote) {
            // Agregar el elemento ItemIn dentro de PunchOutOrderMessage
            $itemIn = $punchOutOrderMessage->addChild('ItemIn');
            $itemIn->addAttribute('quantity', $currentQuote->cantidad);

            // Agregar el elemento ItemID dentro de ItemIn
            $itemID = $itemIn->addChild('ItemID');
            $itemID->addChild('SupplierPartID', $currentQuote->product->internal_sku);

            // Agregar el elemento ItemDetail dentro de ItemIn
            $itemDetail = $itemIn->addChild('ItemDetail');
            $unitPrice = $itemDetail->addChild('UnitPrice');
            $money = $unitPrice->addChild('Money', $currentQuote->precio_unitario);
            $money->addAttribute('currency', 'MXN');
            $itemDetail->addChild('Description', $currentQuote->product->description)->addAttribute('xml:lang', 'en-US');
            $itemDetail->addChild('UnitOfMeasure', 'PZ');
            $itemDetail->addChild('Classification', '80141605')->addAttribute('domain', 'UNSPSC');
        }

        $xmlString = $xml->asXML();
        $cXMLString = str_replace("lang=", "xml:lang=", $xmlString);


        $url = 'https://grupoherdez-test.coupahost.com/punchout/checkout?id=11';

        // Eliminar los datos del carrito
        auth()->user()->currentQuote->currentQuoteDetails()->delete();
        auth()->user()->currentQuote()->delete();

        return view('pages.catalogo.submitCoupa', compact('url', 'cXMLString'));
    }

    public function misCotizaciones()
    {
     
        if(auth()->user()->hasRole( "buyers-manager")){
            $quotes = Quote::simplePaginate(10);
        }else{
            $quotes =  auth()->user()->quotes()->simplePaginate(10);
        }
    
        return view('pages.catalogo.misCotizaciones', compact('quotes'));
    }
}
