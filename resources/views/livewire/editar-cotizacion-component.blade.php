<div>
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h5 class="card-title">Productos Cotizados</h5>
            <div class="text-success" style="width: 25px; cursor: pointer;" wire:click="editar" data-toggle="tooltip"
                data-placement="bottom" title="Editar">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                    <path fill-rule="evenodd"
                        d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                        clip-rule="evenodd" />
                </svg>
            </div>
        </div>
        <br>
        @php
            $subtotalAdded = 0;
            $subtotalSubstract = 0;
            $sumPrecioTotal = 0;
            $quoteScales = false;
        @endphp
        @if ($quote->latestQuotesUpdate)
            @if (count($quote->latestQuotesUpdate->quoteProducts) > 0)
                <div class="w-100">
                    <table class="table table-responsive-sm">
                        <thead class="w-100">
                            <tr class="w-100">
                                <th>Imagen</th>
                                <th>Producto</th>
                                <th>Subtotal</th>
                                <th>Piezas</th>
                                <th>Total</th>
                                <th>...</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quote->latestQuotesUpdate->quoteProducts as $product)
                                @php
                                    $producto = (object) json_decode($product->product);
                                    $tecnica = (object) json_decode($product->technique);
                                    $visible = true;
                                    $auxProduct = $product;
                                    
                                    foreach ($listUpdateCurrent as $productUpdate) {
                                        if ($product->id == $productUpdate['currentQuote_id']) {
                                            $product = (object) $productUpdate;
                                            $producto->image = ((object) json_decode($product->product))->image;
                                            $product->id = $productUpdate['currentQuote_id'];
                                        }
                                    }
                                    $sumPrecioTotal += $product->precio_total;
                                    
                                    foreach ($listDeleteCurrent as $productDeleted) {
                                        if ($product->id == $productDeleted['id']) {
                                            $visible = false;
                                            $subtotalSubstract += $product->precio_total;
                                        }
                                    }
                                    if ($product->quote_by_scales) {
                                        $quoteScales = true;
                                    }
                                @endphp
                                <tr class="{{ !$visible ? 'd-none' : '' }}">
                                    <td class="text-center">
                                        <img src="{{ $producto->image == '' ? asset('img/default.jpg') : $producto->image }}"
                                            style="max-height: 80px;height:auto;max-width: 70px;width:auto;"
                                            alt="" srcset="">
                                    </td>
                                    <td class="">
                                        <p>{{ Str::limit($producto->name, 25, '...') }}</p>
                                    </td>
                                    @if (!$product->quote_by_scales)
                                        <td class="">
                                            <p class="text-center">
                                                ${{ number_format($product->precio_unitario, 2, '.', ',') }}</p>
                                        </td>
                                        <td class="">
                                            <p class="text-center"> {{ $product->cantidad }} piezas</p>
                                        </td>
                                        <td>
                                            <p class="text-center">
                                                ${{ number_format($product->precio_total, 2, '.', ',') }}
                                            </p>
                                        </td>
                                    @else
                                        <td colspan="3" class="text-right">
                                            <table class="table table-sm table-bordered m-0">
                                                <thead>
                                                    <tr>
                                                        <th>Cantidad</th>
                                                        <th>Utilidad</th>
                                                        <th>Impresion</th>
                                                        <th>Unitario</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach (json_decode($product->scales_info) as $item)
                                                        <tr>
                                                            <td>{{ $item->quantity }} pz</td>
                                                            <td>{{ $item->utility }} %</td>
                                                            <td>$
                                                                {{ number_format($item->tecniquePrice, 2, '.', ',') }}
                                                            </td>
                                                            <td>$
                                                                {{ number_format($item->unit_price, 2, '.', ',') }}
                                                            </td>
                                                            <td>$
                                                                {{ number_format($item->total_price, 2, '.', ',') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </td>
                                    @endif
                                    <td class="text-center d-flex">
                                        <button class="btn btn-info btn-sm"
                                            wire:click="verDetalles({{ $auxProduct }})">
                                            <div style="width: 1rem">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                        </button>
                                        @if ($puedeEditar)
                                            <button class="btn btn-warning btn-sm"
                                                wire:click="editarProducto({{ $auxProduct }})">
                                                <div style="width: 1rem">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </div>
                                            </button>
                                            <button class="btn btn-danger btn-sm"
                                                wire:click="deleteProducto({{ $auxProduct }})">
                                                <div style="width: 1rem">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </div>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            @if ($puedeEditar)
                                @foreach ($listNewProducts as $newProduct)
                                    <tr>
                                        @php
                                            $producto = json_decode($newProduct['product']);
                                        @endphp
                                        <td class="text-center">
                                            <img src="{{ $producto->image == '' ? asset('img/default.jpg') : $producto->image }}"
                                                style="max-height: 100px;height:auto;max-width: 80px;width:auto;"
                                                alt="" srcset="">
                                        </td>
                                        <td class="">
                                            <p>{{ $producto->name }}</p>
                                        </td>

                                        @if (!$newProduct['quote_by_scales'])
                                            <td class="">
                                                <p class="text-center">${{ $newProduct['precio_unitario'] }}</p>
                                            </td>
                                            <td class="">
                                                <p class="text-center"> {{ $newProduct['cantidad'] }} piezas</p>
                                            </td>
                                            <td>
                                                <p class="text-center">${{ $newProduct['precio_total'] }}</p>
                                                @php
                                                    $subtotalAdded += $newProduct['precio_total'];
                                                @endphp
                                            </td>
                                        @else
                                            <td colspan="3" class="text-right">
                                                <table class="table table-sm table-bordered m-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Cantidad</th>
                                                            <th>Utilidad</th>
                                                            <th>Impresion</th>
                                                            <th>Unitario</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach (json_decode($newProduct['scales_info']) as $item)
                                                            <tr>
                                                                <td>{{ $item->quantity }} pz</td>
                                                                <td>{{ $item->utility }} %</td>
                                                                <td>$
                                                                    {{ number_format($item->tecniquePrice, 2, '.', ',') }}
                                                                </td>
                                                                <td>$
                                                                    {{ number_format($item->unit_price, 2, '.', ',') }}
                                                                </td>
                                                                <td>$
                                                                    {{ number_format($item->total_price, 2, '.', ',') }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </td>
                                        @endif
                                        <td class="text-center d-flex">
                                            <button class="btn btn-danger btn-sm"
                                                wire:click="deleteNewProducto({{ $newProduct['idNewQuote'] }})">
                                                <div style="width: 1rem">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </div>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <div>
                                            <button class="btn btn-light shadow-none text-center" data-toggle="modal"
                                                data-target="#modalCotizador">
                                                <div class="d-flex justify-content-center w-100">
                                                    <div style="width: 1rem;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 w-100"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                            stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                    Agregar Producto
                                                </div>
                                            </button>
                                        </div>
                                        <br>
                                        {{--  @livewire('add-new-product-to-quote') --}}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                @if ($puedeEditar)
                    <div class="row px-2">
                        <div class="col-md-6">
                            <button class="btn btn-info btn-block shadow-none" wire:click='editar'>
                                Cancelar
                            </button>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-center">
                                <div wire:loading wire:target="guardar">
                                    <div class="spinner-border text-success" role="status">
                                        <span class="sr-only">loading...</span>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-success btn-block shadow-none" wire:click="guardar">
                                Guardar Cambios en los Productos
                            </button>
                        </div>
                    </div>

                    <br>
                @endif
                {{-- INICIO DE LA PARTE DE LOS DESCUENTOS --}}
                {{-- @livewire('edit-quote-discount-component', ['quote' => $quote]) --}}
                @if (!$quoteScales)
                    @php
                        $subtotal = $sumPrecioTotal - $subtotalSubstract;
                        $discountValue = 0;
                        if ($type == 'Fijo') {
                            $discountValue = $value;
                        } else {
                            $discountValue = round(($subtotal / 100) * $value, 2);
                        }
                    @endphp
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title">Informacion del descuento actual</h5>
                        <div class="text-success" style="width: 25px; cursor: pointer;" data-toggle="modal"
                            data-target="#discountModalEdit" data-toggle="tooltip" data-placement="bottom"
                            title="Editar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                <path fill-rule="evenodd"
                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="d-flex flex-column">
                        <p><b>Subtotal: </b>$ {{ number_format($subtotal + $subtotalAdded, 2, '.', ',') }}</p>
                        <p><b>Descuento: </b>$ {{ number_format($discountValue, 2, '.', ',') }}
                        </p>
                        <p><b>Total: </b>$
                            {{ number_format($subtotal + $subtotalAdded - $discountValue, 2, '.', ',') }}
                        </p>
                    </div>
                @endif

                <!-- Modal -->
                <div class="modal fade" id="discountModalEdit" tabindex="-1"
                    aria-labelledby="discountModalEditLabel" aria-hidden="true" wire:ignore.self>
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="discountModalEditLabel">Editar Descuento</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="">Tipo de Descuento</label>
                                    <select class="form-control" wire:model.lazy="type">
                                        <option value=""
                                            {{ $quote->latestQuotesUpdate->quoteDiscount->type == '' ? 'selected' : '' }}>
                                            Seleccione...
                                        </option>
                                        <option value="Fijo"
                                            {{ $quote->latestQuotesUpdate->quoteDiscount->type == 'Fijo' ? 'selected' : '' }}>
                                            Valor Fijo
                                        </option>
                                        <option value="Porcentaje"
                                            {{ $quote->latestQuotesUpdate->quoteDiscount->type == 'Porcentaje' ? 'selected' : '' }}>
                                            Porcentaje</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Cantidad</label>
                                    <input type="number" class="form-control" placeholder="ej: 50, 2000"
                                        wire:model.lazy="value">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Cancelar</button>

                                <div class="d-flex justify-content-center">
                                    <div wire:loading wire:target="updateDiscount">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="sr-only">loading...</span>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary"
                                        wire:click="updateDiscount">Actualizar</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <script>
                    window.addEventListener('hideModalDiscount', event => {
                        $('#discountModalEdit').modal('hide')
                    })
                </script>
                {{-- FIN DE LA PARTE DE LOS DESCUENTOS --}}
            @else
                <p>No hay Productos Cotizados</p>
            @endif
        @else
            <p>No hay Productos Cotizados</p>
        @endif
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalCotizador" tabindex="-1" aria-labelledby="modalCotizadorLabel"
        data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCotizadorLabel">Añadir producto a la cotizacion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 80vh; overflow: auto;">
                    {{-- @livewire('catalogo-min-component') --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditarProducto" tabindex="-1" aria-labelledby="modalEditarProductoLabel"
        data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarProductoLabel">Editar Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 80vh; overflow: auto;">
                    @if ($puedeEditar && $productEdit)
                        {{-- @livewire('formulario-de-cotizacion', ['productEdit' => $productEdit], key($productEdit['id'])) --}}
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalVerProducto" tabindex="-1" aria-labelledby="modalVerProductoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalVerProductoLabel">Informacion del producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($showProduct)
                        <div class="row">
                            <div class="col-md-8">
                                @php
                                    $productoShow = (object) json_decode($showProduct['product']);
                                    $tecnicaShow = (object) json_decode($showProduct['technique']);
                                @endphp
                                <p class="m-0">Informacion del Producto: </p>
                                <p class="m-0"><b>Nombre: </b>{{ $productoShow->name }} </p>
                                <p class="m-0"><b>Descripcion: </b>{{ $productoShow->description }} </p>
                                <p class="m-0"><b>Precio: </b> $
                                    @php
                                        $priceProduct = 0;
                                        if ($dataProduct) {
                                            $priceProduct = $dataProduct->price;
                                            if ($dataProduct->producto_promocion) {
                                                $priceProduct = round($priceProduct - $priceProduct * ($dataProduct->descuento / 100), 2);
                                            } else {
                                                $priceProduct = round($priceProduct - $priceProduct * ($dataProduct->provider->discount / 100), 2);
                                            }
                                        }
                                    @endphp
                                    {{ $priceProduct }}
                                </p>
                                @if (property_exists($productoShow, 'provider'))
                                    <p class="m-0"><b>Proveedor: </b>{{ $productoShow->provider->company }} </p>
                                @endif
                                <br>
                                <p class="m-0">Informacion de la Tecnica: </p>
                                <p class="m-0"><b>Material: </b>{{ $tecnicaShow->material }} </p>
                                <p class="m-0"><b>Tecnica: </b>{{ $tecnicaShow->tecnica }} </p>
                                <p class="m-0"><b>Tamaño: </b>{{ $tecnicaShow->size }}</p>
                                <br>
                                <p class="m-0"><b>Numero de tintas o logos:</b>
                                    {{ $showProduct['color_logos'] }}
                                </p>
                                <p class="m-0"><b>Costo Indirecto:</b> $ {{ $showProduct['costo_indirecto'] }}</p>
                                <p class="m-0"><b>Margen de Utilidad:</b> {{ $showProduct['utilidad'] }} %</p>
                                <p class="m-0"><b>Dias de entrega:</b> {{ $showProduct['dias_entrega'] }} </p>
                                @if ($showProduct['quote_by_scales'])
                                    <table class="table table-sm table-bordered m-0">
                                        <thead>
                                            <tr>
                                                <th>Cantidad</th>
                                                <th>Utilidad</th>
                                                <th>Impresion</th>
                                                <th>Unitario</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (json_decode($showProduct['scales_info']) as $item)
                                                <tr>
                                                    <td>{{ $item->quantity }} pz</td>
                                                    <td>{{ $item->utility }} %</td>
                                                    <td>$
                                                        {{ number_format($item->tecniquePrice, 2, '.', ',') }}
                                                    </td>
                                                    <td>$
                                                        {{ number_format($item->unit_price, 2, '.', ',') }}
                                                    </td>
                                                    <td>$
                                                        {{ number_format($item->total_price, 2, '.', ',') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="m-0"><b>Precio de la tecnica:</b> $
                                        {{ $showProduct['prices_techniques'] }}</p>
                                    <p class="m-0"><b>Precio Unitario:</b> $ {{ $showProduct['precio_unitario'] }}
                                    </p>
                                    <p class="m-0"><b>Cantidad:</b> {{ $showProduct['cantidad'] }} </p>
                                    <p class="m-0"><b>Precio Total:</b> $ {{ $showProduct['precio_total'] }} </p>
                                @endif
                                {{-- {{ dd($showProduct) }} --}}
                            </div>
                            <div class="col-md-4">
                                <div class="">
                                    <img src="{{ $productoShow->image }}" alt=""
                                        style="max-width: 200px; width: auto;max-height: 500px; height:auto;">
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('showProduct', event => {
            $('#modalVerProducto').modal('show')
        })
        window.addEventListener('showModalEditar', event => {
            $('#modalEditarProducto').modal('show')
        })
        window.addEventListener('closeModal', event => {
            $('#modalEditarProducto').modal('hide')
            $('#modalCotizador').modal('hide')
        })
        window.addEventListener('Editarproducto', event => {
            Swal.fire('Actualizado correctamente')
        })
        window.addEventListener('Noseedito', event => {
            Swal.fire('No hay cambio')
        })
        window.addEventListener('Editardescuento', event => {
            Swal.fire('Descuento modificado')
        })
    </script>
</div>
