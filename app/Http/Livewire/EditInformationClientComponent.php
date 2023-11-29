<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\QuoteInformation;
use App\Models\User;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\WithFileUploads;

class EditInformationClientComponent extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    public $quoteInfo, $quote;
    public $tipoCliente, $clienteSeleccionado = '', $nombre, $empresa, $email, $telefono, $celular, $oportunidad, $rank = '', $departamento, $informacion, $clients,  $logo,  $ivaByItem, $showTotal, $typeDays, $taxFee, $shelfLife;

    public function mount()
    {
        $this->ivaByItem = $this->quote->iva_by_item;
        $this->showTotal = $this->quote->show_total;
        $this->nombre = $this->quoteInfo->name;
        $this->empresa = $this->quoteInfo->company;
        $this->email = $this->quoteInfo->email;
        $this->telefono = $this->quoteInfo->landline;
        $this->celular = $this->quoteInfo->cell_phone;
        $this->oportunidad = $this->quoteInfo->oportunity;
        $this->rank = $this->quoteInfo->rank;
        $this->departamento = $this->quoteInfo->department;
        $this->informacion = $this->quoteInfo->information;
        $this->taxFee = $this->quoteInfo->taxFee;
        $this->shelfLife = $this->quoteInfo->shelfLife;
    }

    public function render()
    {
        if ($this->taxFee > 99)
            $this->taxFee = 99;
        return view('livewire.edit-information-client-component');
    }

    public function guardarCotizacion()
    {
        $this->authorize('update', $this->quote);
        $this->validate([
            // 'tipoCliente' => 'rsequired',
            'email' => 'required|email',
            'telefono' => 'required|numeric',
            'celular' => 'required|numeric',
            'oportunidad' => 'required',
            'rank' => 'required',
        ]);

        $pathLogo = null;
        if ($this->logo != null) {
            $name = time() . $this->empresa .  $this->logo->getClientOriginalExtension();
            $pathLogo = 'storage/logos/' . $name;
            $this->logo->storeAs('public/logos', $name);
            // Guardar La cotizacion
        }

        $this->quote->update([
            'iva_by_item' => boolval($this->ivaByItem),
            'show_total' => boolval($this->showTotal),
            'logo' => $pathLogo,
        ]);
        // Guardar la Info de la cotizacion
        $quoteInfo = QuoteInformation::create([
            'name' => $this->nombre,
            'company' => $this->quoteInfo->company,
            'email' => $this->email,
            'landline' => $this->telefono,
            'cell_phone' => $this->celular,
            'oportunity' => $this->oportunidad,
            'rank' => $this->rank,
            'department' => $this->departamento,
            'information' => $this->informacion,
            'tax_fee' => $this->taxFee > 0 ? $this->taxFee : null,
            'shelf_life' => trim($this->shelfLife) == "" ? null : $this->shelfLife,
        ]);


        $latestProductos = $this->quote->latestQuotesUpdate->quoteProducts;
        $newQuoteUpdate =  $this->quote->quotesUpdate()->create([
            'quote_information_id' => $quoteInfo->id,
            'quote_discount_id' => $this->quote->latestQuotesUpdate->quote_discount_id,
            'type' => "information"
        ]);
        foreach ($latestProductos as $product) {
            $newQuoteUpdate->quoteProducts()->create([
                "product" => $product->product,
                "technique" => $product->technique,
                "prices_techniques" => $product->prices_techniques,
                "color_logos" => $product->color_logos,
                "costo_indirecto" => $product->costo_indirecto,
                "utilidad" => $product->utilidad,
                "dias_entrega" => $product->dias_entrega,
                "cantidad" => $product->cantidad,
                "precio_unitario" => $product->precio_unitario,
                "precio_total" => $product->precio_total,
            ]);
        }
        $this->emit('updateQuoteInfo', $quoteInfo);
        $this->dispatchBrowserEvent('showModalInfoClient');
    }
}
