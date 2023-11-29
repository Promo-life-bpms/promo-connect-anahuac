<?php

namespace App\Http\Livewire;

use App\Models\Catalogo\Product;
use App\Models\Catalogo\address;
use App\Models\PricesTechnique;
use Livewire\Component;
use App\Http\Controllers\CotizadorController;
use App\Mail\SendDataErrorCreateQuote;
use App\Models\Address as ModelsAddress;
use App\Models\Client;
use App\Models\Quote;
use App\Models\QuoteDiscount;
use App\Models\QuoteInformation;
use App\Models\User;
use App\Notifications\PurchaseMadeNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use SimpleXMLElement;

class FinalizarCotizacion extends Component
{
    use WithFileUploads;
    public $cotizacionActual, $totalQuote;
    public $urlPDFPreview;
    public $direccion, $direccion_id, $direccionSeleccionadaId;

    public $nombre, $apellidos, $calle, $numero_exterior, $numero_interior, $referencias, $colonia, $codigo_postal, $delegacion_municipal, $estado, $telefono;
    public $addressinfo;
    public $total = 4;
    public $pasos = 1;
    public $todo;
    public $roles;

    public function mount()
    {
        $this->pasos = 1;
        $this->cotizacionActual = auth()->user()->currentQuote ? auth()->user()->currentQuote->currentQuoteDetails : [];
        $this->totalQuote = count($this->cotizacionActual) > 0 ? $this->cotizacionActual->sum('precio_total') : 0;
    }

    public function render()
    {
        return view('pages.catalogo.finalizar-cotizacion');
    }

    public function address()
    {
        $this->validate([
            'nombre' => 'required',
            'apellidos' =>  'required',
            'calle' => 'required',
            'numero_exterior' => 'required',
            'numero_interior' => 'required',
            'colonia' => 'required',
            'referencias' => 'required',
            'codigo_postal' => 'required',
            'delegacion_municipal' => 'required',
            'estado' => 'required',
            'telefono' => 'required',
        ]);

        if ((int)$this->direccion_id > 0) {
            $this->direccionSeleccionadaId = $this->direccion_id;
            $this->nombre = null;
            $this->apellidos = null;
            $this->calle = null;
            $this->numero_exterior = null;
            $this->numero_interior = null;
            $this->referencias = null;
            $this->colonia = null;
            $this->codigo_postal = null;
            $this->delegacion_municipal = null;
            $this->estado = null;
            $this->telefono = null;
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Dirección seleccionada correctamente']);
        } else {
            $addressinfo = ModelsAddress::create([
                'user_id' => auth()->user()->id,
                'nombre' => $this->nombre,
                'apellidos' => $this->apellidos,
                'calle' => $this->calle,
                'numero_exterior' => $this->numero_exterior,
                'numero_interior' => $this->numero_interior,
                'referencias' => $this->referencias,
                'colonia' => $this->colonia,
                'codigo_postal' => $this->codigo_postal,
                'delegacion_municipal' => $this->delegacion_municipal,
                'estado' => $this->estado,
                'telefono' => $this->telefono,
            ]);

            $this->nombre = null;
            $this->apellidos = null;
            $this->calle = null;
            $this->numero_exterior = null;
            $this->numero_interior = null;
            $this->referencias = null;
            $this->colonia = null;
            $this->codigo_postal = null;
            $this->delegacion_municipal = null;
            $this->estado = null;
            $this->telefono = null;

            $this->direccionSeleccionadaId = $addressinfo->id;
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Dirección guardada correctamente']);
        }
    }

    // Cambiar la direccion por una seleccionada por el usuario
    public function changeAddress()
    {
        if ((int)$this->direccion_id > 0) {
            // Obtner la direccion seleccionada por el usuario del dato direccion_id
            $address = ModelsAddress::find($this->direccion_id);
            // Establecer los datos en las variables
            $this->nombre = $address->nombre;
            $this->apellidos = $address->apellidos;
            $this->calle = $address->calle;
            $this->numero_exterior = $address->numero_exterior;
            $this->numero_interior = $address->numero_interior;
            $this->referencias = $address->referencias;
            $this->colonia = $address->colonia;
            $this->codigo_postal = $address->codigo_postal;
            $this->delegacion_municipal = $address->delegacion_municipal;
            $this->estado = $address->estado;
            $this->telefono = $address->telefono;
        } else {
            $this->direccionSeleccionadaId = null;
        }
    }
}
