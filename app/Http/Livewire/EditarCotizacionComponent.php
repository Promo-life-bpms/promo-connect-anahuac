<?php

namespace App\Http\Livewire;

use App\Models\Catalogo\Product;
use App\Models\PricesTechnique;
use App\Models\Quote;
use App\Models\QuoteDiscount;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EditarCotizacionComponent extends Component
{
    use AuthorizesRequests;

    // Informaicon de los descuentos
    public $discount, $value, $type, $discountStatus;
    // Informaicon de los descuentos

    public $quote, $puedeEditar = false, $inputDiscount;

    protected $listeners = ['productAdded' => 'addProducto', 'puedeEditar' => 'editar', 'productUpdate' => 'updateProduct'];

    // Variables Editables
    public $listNewProducts = [], $listUpdateCurrent = [], $listDeleteCurrent = [], $newDiscount;

    public $productEdit = null;

    // Informacion a mostrar
    public $showProduct, $dataProduct;

    public function mount()
    {
        $discount = $this->quote->latestQuotesUpdate->quoteDiscount;
        $this->value = $discount->value;
        $this->type = $discount->type;
        $this->discountStatus = $discount->discount;

        // dd($this->type, $this->value, $this->discountStatus);
    }

    public function render()
    {
        $quote = Quote::find($this->quote->id);
        return view('livewire.editar-cotizacion-component', ['quote' => $quote]);
    }

    public function verDetalles($product)
    {
        $this->showProduct = $product;
        $this->dataProduct = Product::find(json_decode($product['product'])->id);
        $this->dispatchBrowserEvent('showProduct');
    }

    public function editar()
    {
        $this->puedeEditar = !$this->puedeEditar;
        if (!$this->puedeEditar) {
            $this->listNewProducts = [];
            $this->listUpdateCurrent = [];
            $this->listDeleteCurrent = [];
        }
    }

    public function editarProducto($product, $isNew = false)
    {
        if ($isNew) {
            foreach ($this->listNewProducts as $newProduct) {
                if ($newProduct['idNewQuote'] == $product) {
                    $this->productEdit = $newProduct;
                }
            }
        } else {
            $this->productEdit = $product;
        }
        // $this->emit('editProduct', ['productEdit' => $this->productEdit, 'isNew' => $isNew]);
        $this->dispatchBrowserEvent('showModalEditar');
    }

    public function addProducto($productAdded)
    {
        array_push($this->listNewProducts, $productAdded);
        $this->dispatchBrowserEvent('Editarproducto');
    }
    public function updateProduct($productUpdate)
    {
        $this->authorize('update', $this->quote);
        if ($productUpdate['currentQuote_id'] !== "") {
            // Revisar si se actualizo una actualizacion o es nueva
            $listUpdate = [];
            $isNewEdit = false;
            $this->dispatchBrowserEvent('Editarproducto');
            if (count($this->listUpdateCurrent) <= 0) {
                $isNewEdit = true;
                $this->dispatchBrowserEvent('Nosedito');
            } else {
                foreach ($this->listUpdateCurrent as $key => $productQuoteEdit) {

                    if ($productUpdate['currentQuote_id'] == $productQuoteEdit['currentQuote_id']  && $isNewEdit == false) {
                        $productQuoteEdit = $productUpdate;
                        $this->dispatchBrowserEvent('Editarproducto');
                    } else {
                        $isNewEdit = true;
                    }
                    array_push($listUpdate, $productQuoteEdit);
                }
            }

            if ($isNewEdit) {
                array_push($this->listUpdateCurrent, $productUpdate);
            } else {
                $this->listUpdateCurrent = $listUpdate;
                $this->dispatchBrowserEvent('Editarproducto');
            }
        }
    }

    public function deleteProducto($productDeleted)
    {
        array_push($this->listDeleteCurrent, $productDeleted);
    }

    public function deleteNewProducto($productDeleted)
    {
        $newArray = [];
        foreach ($this->listNewProducts as $newProduct) {
            if ($newProduct['idNewQuote'] != $productDeleted) {
                array_push($newArray, $newProduct);
            }
        }
        $this->listNewProducts = $newArray;
    }

    public function guardar()
    {
        $this->authorize('update', $this->quote);
        if (count($this->listNewProducts) <= 0 && count($this->listUpdateCurrent) <= 0 && count($this->listDeleteCurrent) <= 0) {
            return;
        }
        // Obtener los productos
        $latestProductos = $this->quote->latestQuotesUpdate->quoteProducts;
        $this->dispatchBrowserEvent('Editarcliente');

        // Crear la nueva cotizacion
        $newQuoteUpdate =  $this->quote->quotesUpdate()->create([
            'quote_information_id' => $this->quote->latestQuotesUpdate->quote_information_id,
            'quote_discount_id' => $this->quote->latestQuotesUpdate->quote_discount_id,
            'type' => "product"
        ]);

        // Buscar que productos fueron elimiandos y sarcarlos de la lista de productos
        if (count($this->listDeleteCurrent) > 0) {
            foreach ($latestProductos as $key => $productQuote) {
                for ($j = 0; $j < count($this->listDeleteCurrent); $j++) {
                    if ($productQuote->id == $this->listDeleteCurrent[$j]['id']) {
                        unset($latestProductos[$key]);
                        break;
                    }
                }
            }
        }

        // Actualizar las cotizaciones editadas en la lista
        $newLatestProducts = [];
        if (count($this->listUpdateCurrent) > 0) {
            foreach ($latestProductos as $key => $productQuote) {
                foreach ($this->listUpdateCurrent as $keyList => $productQuoteEdit) {
                    if ($productQuote->id == $productQuoteEdit['currentQuote_id']) {
                        $tecnica = PricesTechnique::find($productQuoteEdit['prices_techniques_id']);
                        $material = $tecnica->sizeMaterialTechnique->materialTechnique->material->nombre;
                        $material_id = $tecnica->sizeMaterialTechnique->materialTechnique->material->id;
                        $tecnica_nombre = $tecnica->sizeMaterialTechnique->materialTechnique->technique->nombre;
                        $tecnica_id = $tecnica->sizeMaterialTechnique->materialTechnique->technique->id;
                        $size = $tecnica->sizeMaterialTechnique->size->nombre;
                        $size_id = $tecnica->sizeMaterialTechnique->size->id;
                        $infoTecnica = [
                            'material_id' => $material_id,
                            'material' => $material,
                            'tecnica' => $tecnica_nombre,
                            'tecnica_id' => $tecnica_id,
                            'size' => $size,
                            'size_id' => $size_id,
                        ];
                        $productQuote->product = $productQuoteEdit['product'];
                        $productQuote->technique = json_encode($infoTecnica);
                        if (!$productQuoteEdit['quote_by_scales']) {
                            $productQuote->prices_techniques = $productQuoteEdit['newPriceTechnique'] != null
                                ? $productQuoteEdit['newPriceTechnique']
                                : ($tecnica->tipo_precio == 'D'
                                    ? round($tecnica->precio / $productQuoteEdit['cantidad'], 2)
                                    : $tecnica->precio);
                        } else {
                            $productQuote->prices_techniques = null;
                        }
                        $productQuote->new_description = $productQuoteEdit['new_description'];
                        $productQuote->color_logos = $productQuoteEdit['color_logos'];
                        $productQuote->costo_indirecto = $productQuoteEdit['costo_indirecto'];
                        $productQuote->utilidad = $productQuoteEdit['utilidad'];
                        $productQuote->dias_entrega = $productQuoteEdit['dias_entrega'];
                        $productQuote->cantidad = $productQuoteEdit['cantidad'];
                        $productQuote->precio_unitario = $productQuoteEdit['precio_unitario'];
                        $productQuote->precio_total = $productQuoteEdit['precio_total'];
                        $productQuote->quote_by_scales = $productQuoteEdit['quote_by_scales'];
                        $productQuote->scales_info = $productQuoteEdit['scales_info'];
                        unset($this->listUpdateCurrent[$keyList]);
                    }
                }
                array_push($newLatestProducts, $productQuote);
            }
        }
        // Agregar los productos de la nueva lista que tiene los productos editados y no estan los elimiandos
        foreach ($latestProductos as $productQuote) {
            $newQuoteUpdate->quoteProducts()->create([
                "product" => $productQuote->product,
                "technique" => $productQuote->technique,
                "prices_techniques" => $productQuote->prices_techniques,
                "new_description" => $productQuote->new_description,
                "color_logos" => $productQuote->color_logos,
                "costo_indirecto" => $productQuote->costo_indirecto,
                "utilidad" => $productQuote->utilidad,
                "dias_entrega" => $productQuote->dias_entrega,
                "cantidad" => $productQuote->cantidad,
                "precio_unitario" => $productQuote->precio_unitario,
                "precio_total" => $productQuote->precio_total,
                "quote_by_scales" => $productQuote->quote_by_scales,
                "scales_info" => $productQuote->scales_info,
            ]);
        }

        // Agregar los productos nuevos
        if (count($this->listNewProducts) > 0) {
            foreach ($this->listNewProducts as $item) {
                $tecnica = PricesTechnique::find($item['prices_techniques_id']);
                $material = $tecnica->sizeMaterialTechnique->materialTechnique->material->nombre;
                $material_id = $tecnica->sizeMaterialTechnique->materialTechnique->material->id;
                $tecnica_nombre = $tecnica->sizeMaterialTechnique->materialTechnique->technique->nombre;
                $tecnica_id = $tecnica->sizeMaterialTechnique->materialTechnique->technique->id;
                $size = $tecnica->sizeMaterialTechnique->size->nombre;
                $size_id = $tecnica->sizeMaterialTechnique->size->id;
                $infoTecnica = [
                    'material_id' => $material_id,
                    'material' => $material,
                    'tecnica' => $tecnica_nombre,
                    'tecnica_id' => $tecnica_id,
                    'size' => $size,
                    'size_id' => $size_id,
                ];
                $dataNewQuote = [
                    'product' => $item['product'],
                    'technique' =>  json_encode($infoTecnica),
                    "new_description" => $item['new_description'],
                    'color_logos' => $item['color_logos'],
                    'costo_indirecto' => $item['costo_indirecto'],
                    'utilidad' => $item['utilidad'],
                    'dias_entrega' => $item['dias_entrega'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'precio_total' => $item['precio_total'],
                    'quote_by_scales' => $item['quote_by_scales'],
                    'scales_info' => $item['scales_info'],
                ];
                if (!$item['quote_by_scales']) {
                    $dataNewQuote['prices_techniques'] =  $item['newPriceTechnique'] != null
                        ? $item['newPriceTechnique']
                        : ($tecnica->tipo_precio == 'D'
                            ? round($tecnica->precio / $item['cantidad'], 2)
                            : $tecnica->precio);
                } else {
                    $dataNewQuote['prices_techniques'] = null;
                }
                $newQuoteUpdate->quoteProducts()->create($dataNewQuote);
            }
        }
        $this->quote = Quote::find($this->quote->id);

        $this->puedeEditar = false;
        $this->listNewProducts = [];
        $this->listUpdateCurrent = [];
        $this->listDeleteCurrent = [];
    }

    public function updateDiscount()
    {
        $this->authorize('update', $this->quote);
        $dataDiscount = [
            'discount' => $this->discountStatus,
            'type' => $this->type,
            'value' => $this->value,
        ];

        $quoteDiscount = QuoteDiscount::create($dataDiscount);

        $latestProductos = $this->quote->latestQuotesUpdate->quoteProducts;
        $newQuoteUpdate =  $this->quote->quotesUpdate()->create([
            'quote_information_id' => $this->quote->latestQuotesUpdate->quote_information_id,
            'quote_discount_id' => $quoteDiscount->id,
            'type' => "discount"
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
            $this->dispatchBrowserEvent('Editardescuento');
        }
        $this->value = $quoteDiscount->value;
        $this->type = $quoteDiscount->type;
        $this->discountStatus = $quoteDiscount->discount;
        $this->dispatchBrowserEvent('hideModalDiscount');
        session()->flash('message', 'Por favor espere...');
    }
}
