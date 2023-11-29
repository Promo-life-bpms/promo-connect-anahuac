<?php

namespace App\Http\Livewire;

use App\Models\Catalogo\Product;
use App\Models\CurrentQuote;
use App\Models\CurrentQuoteDetails;
use App\Models\Muestra;
use App\Models\Quote;
use App\Models\User;
use App\Notifications\RequestedSampleNotification;
use Exception;
use Livewire\Component;

class CurrentQuoteComponent extends Component
{
    public $cotizacionActual, $totalQuote;
    public $discountMount = 0;

    public $value, $type;
    public $quoteEdit, $quoteShow;

    public $nombre, $telefono, $direccion, $quote_id;

    protected $listeners = ['updateProductCurrent' => 'resetData'];

    public $count;
    public $conteoMuestras = [];

    public function mount()
    {
        $this->cotizacionActual = auth()->user()->currentQuote->currentQuoteDetails;
        $this->totalQuote = $this->cotizacionActual->sum('precio_total');
        if (auth()->user()->currentQuote->discount) {
            $this->value = auth()->user()->currentQuote->value;
            $this->type = auth()->user()->currentQuote->type;
        } else {
            $this->value = 0;
            $this->type = '';
        }
    }


    public function render()
    {

        $ccd = CurrentQuoteDetails::find('current_quote_id');
        $this->cotizacionActual = auth()->user()->currentQuote->currentQuoteDetails;
        $this->totalQuote = 0;

        foreach ($this->cotizacionActual as $productToSum) {
            if ($productToSum->quote_by_scales) {
                try {
                    $this->totalQuote = $this->totalQuote + floatval(json_decode($productToSum->scales_info)[0]->total_price);
                } catch (Exception $e) {
                    $this->totalQuote = $this->totalQuote + 0;
                }
            } else {
                $this->totalQuote = $this->totalQuote + $productToSum->costo_total;
            }
        }

        $total = $this->totalQuote;
        if (auth()->user()->currentQuote->type == 'Fijo') {
            $this->discountMount = auth()->user()->currentQuote->value;
        } else {
            $this->discountMount = round((($this->totalQuote / 100) * auth()->user()->currentQuote->value), 2);
        }
        $discount = $this->discountMount;

        return view('pages.catalogo.current-quote-component',  ['total' => $total, 'discount' => $discount]);
    }

    public function edit($quote_id)
    {
        $this->quoteEdit = CurrentQuoteDetails::find($quote_id);
        $this->dispatchBrowserEvent('show-modal-edit');
    }

    public function show($quote_id)
    {
        $this->quoteShow = CurrentQuoteDetails::find($quote_id);
        $this->dispatchBrowserEvent('show-modal-show');
    }

    public function eliminar(CurrentQuoteDetails $cqd)
    {
        $cqd->delete();
        if (count(auth()->user()->currentQuote->currentQuoteDetails) < 1) {
            auth()->user()->currentQuote->delete();
        }
        $this->resetData();
        $this->emit('currentQuoteAdded');
    }
    public function resetData()
    {
        $this->cotizacionActual = auth()->user()->currentQuote->currentQuoteDetails;
        $this->quoteEdit = null;
        $this->quoteShow = null;
    }

    public function solicitarMuestra()
    {
        $this->validate([
            'nombre' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',
        ]);

        $msg = "";
        $error = false;
        try {
            $ccd = CurrentQuoteDetails::find($this->quote_id);
            if (count($ccd->haveSampleProduct($ccd->product->id)) >= 3) {
                $error = true;
                $msg = "Ya has solicitado 3 muestras de este producto";
            } else {
                $muestra = auth()->user()->sampleRequest()->create([
                    'address' => $this->direccion,
                    'phone' => $this->telefono,
                    'name' => $this->nombre,
                    'product_id' => $ccd->product->id,
                    'status' => 1,
                    'current_quote_id' => $ccd->id,
                ]);

                $msg = "La muestra del producto se ha solicitado correctamente";
                $this->nombre = null;
                $this->telefono = null;
                $this->direccion = null;
                $this->quote_id = null;

                $users = User::whereHas('roles', function ($query) {
                    $query->whereIn('name', ['buyers-manager', 'seller']);
                })->get();
                $dataNotification = [
                    'user' => auth()->user()->name,
                    'producto' => $ccd->product->name,
                    'sample_id' => $muestra->id,
                ];
                foreach ($users as $user) {
                    // Enviar notificacion a los usuarios con el rol de vendedor y gerente de compras
                    $user->notify(new RequestedSampleNotification($dataNotification));
                }
            }
        } catch (Exception $e) {
            $msg = $e->getMessage();
            $error = true;
        }
        $this->dispatchBrowserEvent('muestraSolicitada', ['msg' => $msg, "error" => $error]);
    }
}
