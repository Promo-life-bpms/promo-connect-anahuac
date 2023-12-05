<?php

namespace App\Http\Livewire;

use App\Models\Catalogo\Product;
use App\Models\CurrentQuote;
use App\Models\CurrentQuoteDetails;
use App\Models\Muestra;
use App\Models\Quote;
use App\Models\QuoteDiscount;
use App\Models\QuoteInformation;
use App\Models\QuoteProducts;
use App\Models\QuoteTechniques;
use App\Models\QuoteUpdate;
use App\Models\User;
use App\Notifications\RequestedSampleNotification;
use App\Notifications\SendEmailCotizationNotification;
use Exception;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class CurrentQuoteComponent extends Component
{
    public $cotizacionActual, $totalQuote;
    public $discountMount = 0;

    public $value, $type;
    public $quoteEdit, $quoteShow;

    public $nombre, $telefono, $direccion, $quote_id;

    public $pdfDescargado = false;

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
                $this->totalQuote = $this->totalQuote + $productToSum->precio_total;
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


    public function generarPDF()
    {


        $this->pdfDescargado = true;
        
        $date =  Carbon::now()->format("d/m/Y");

        $cotizacionActual = auth()->user()->currentQuote->currentQuoteDetails;

        $totalQuote = 0;

        $lastQuote = Quote::latest()->first();
        if($lastQuote == null || (intval($lastQuote->id) -  count($cotizacionActual)) == 0){
            $startQS = 1;
        }else{
            $startQS = intval($lastQuote->id) -  count($cotizacionActual);
        }

        foreach ($cotizacionActual as $productToSum) {
            if ($productToSum->quote_by_scales) {
                try {
                    $totalQuote = $totalQuote + floatval(json_decode($productToSum->scales_info)[0]->total_price);
                } catch (Exception $e) {
                    $totalQuote = $totalQuote + 0;
                }
            } else {
                $totalQuote = $totalQuote + $productToSum->precio_total;
            }
        }

        $total = $totalQuote;
        if (auth()->user()->currentQuote->type == 'Fijo') {
            $discountMount = auth()->user()->currentQuote->value;
        } else {
            $discountMount = round((($totalQuote / 100) * auth()->user()->currentQuote->value), 2);
        }
        $discount = $discountMount;
        
        $cotizacionActual = auth()->user()->currentQuote->currentQuoteDetails;

        $quoteCotizationNumber = [];

        foreach($cotizacionActual as $cotizacion){

            $product = Product::find($cotizacion->product_id);

            if($product){
                $createQuote = new Quote(); 
                $createQuote->user_id = auth()->user()->id;
                $createQuote->address_id = 1;
                $createQuote->iva_by_item = 1;
                $createQuote->show_total = 1;
                $createQuote->logo = $cotizacion->logo ;
                $createQuote->status = 0;
                $createQuote->save();
    
                $createQuoteDiscount = new QuoteDiscount();
                $createQuoteDiscount->discount = 0;
                $createQuoteDiscount->type = 'Fijo';
                $createQuoteDiscount->value = 0.00;
                $createQuoteDiscount->save();
    
                $createQuoteInformation = new QuoteInformation();
                $createQuoteInformation->name = 'Cliente';
                $createQuoteInformation->email = 'email';
                $createQuoteInformation->landline = '1';
                $createQuoteInformation->cell_phone = '1';
                $createQuoteInformation->oportunity = 'Oportunidad';
                $createQuoteInformation->rank = '1';
                $createQuoteInformation->department = 'Departamento';
                $createQuoteInformation->information = 'Info';
                $createQuoteInformation->tax_fee = 0;
                $createQuoteInformation->shelf_life = 10;
                $createQuoteInformation->save();
    
                $createQuoteProduct = new QuoteProducts();
                $createQuoteProduct->product = json_encode($product);
                $createQuoteProduct->technique = json_encode(['price_technique' => $cotizacion->price_technique]);
                $createQuoteProduct->prices_techniques = $cotizacion->price_technique;
                $createQuoteProduct->color_logos = $cotizacion->color_logos;
                $createQuoteProduct->costo_indirecto = 0;
                $createQuoteProduct->utilidad = 0;
                $createQuoteProduct->dias_entrega = $cotizacion->dias_entrega;
                $createQuoteProduct->cantidad = $cotizacion->cantidad;
                $createQuoteProduct->precio_unitario = $cotizacion->precio_unitario;
                $createQuoteProduct->precio_total = $cotizacion->precio_total;
                $createQuoteProduct->quote_by_scales = 0;
                $createQuoteProduct->scales_info = null;
                $createQuoteProduct->save();
    
                $createQuoteUpdate = new QuoteUpdate();
                $createQuoteUpdate->quote_id = $createQuote->id;
                $createQuoteUpdate->quote_information_id = $createQuoteInformation->id;
                $createQuoteUpdate->quote_discount_id = $createQuoteDiscount->id;
                $createQuoteUpdate->type = 'created';
                $createQuoteUpdate->save();

                if($cotizacion->currentQuotesTechniques){
                    $createQuoteTechniques = new QuoteTechniques();
                    $createQuoteTechniques->quotes_id = $createQuote->id;
                    $createQuoteTechniques->material =  $cotizacion->currentQuotesTechniques->material;
                    $createQuoteTechniques->technique = $cotizacion->currentQuotesTechniques->technique;
                    $createQuoteTechniques->size = $cotizacion->currentQuotesTechniques->size;
                    $createQuoteTechniques->save();
                }
               

                array_push($quoteCotizationNumber, $createQuote->id );
            } 
        }
        
     /*    $pdf = \PDF::loadView('pages.pdf.cotizacionBH', ['date' =>$date, 'cotizacionActual'=>$cotizacionActual ]);
        $pdf->setPaper('Letter', 'portrait');
        return $pdf->stream("QS-1". '.pdf');  */
        
        $quotes = Quote::whereIn('id', $quoteCotizationNumber)->get();

        $correoDestino = 'fsolano.fs69@gmail.com';
        Notification::route('mail', $correoDestino)
        ->notify(new SendEmailCotizationNotification($date, $quotes ));

        $pdf = \PDF::loadView('pages.pdf.quoteBH', ['date' => $date, 'quotes' => $quotes]);
     
        /* $pdf = \PDF::loadView('pages.pdf.cotizacionBH', ['date' => $date, 'cotizacionActual' => $cotizacionActual, 'startQS' => $startQS]); */
        $pdf->setPaper('Letter', 'portrait');
        $filename = "Cotizacion.pdf";
        $pdf->save(public_path($filename));
        $this->pdfDescargado = true;

        $currentQuote = auth()->user()->currentQuote;

        if ($currentQuote) {
            $currentQuote->currentQuoteDetails->each(function ($detail) {
                $detail->delete();
            });
        }
        
        return response()->download(public_path($filename))->deleteFileAfterSend(true);

       
    }
}
