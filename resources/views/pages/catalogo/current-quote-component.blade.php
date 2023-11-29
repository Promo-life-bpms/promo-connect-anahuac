<div class="container mx-auto max-w-7xl py-2">
    <div class="grid sm:grid-cols-7 grid-cols-1">
        <div class="sm:col-span-5 col-span-1 px-6">
            <div class="font-semibold text-slate-700 py-8 flex items-center space-x-2">
                <div class="w-16">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </div>

                <p class="text-4xl">CARRITO</p>
            </div>


            @if (count($cotizacionActual) > 0)
                @php
                    $quoteByScales = false;
                @endphp
                @foreach ($cotizacionActual as $quote)
                    <div
                        class="flex justify-between border-t last:border-b border-gray-800 py-3 px-5 gap-2 items-center">
                        <div class="flex items-center">
                            <div style="width: 2rem">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <img src="{{ $quote->images_selected ?: ($quote->product->firstImage ? $quote->product->firstImage->image_url : asset('img/default.jpg')) }}"
                                    alt="" width="100">
                            </div>
                        </div>
                        <div class="flex-grow space-y-3">
                            <p class="font-bold text-lg">{{ $quote->product->name }}</p>
                            <div class="flex items-center space-x-3">
                                <p>Cantidad: <strong>{{ $quote->cantidad }}</strong> <span>PZ</span></p>
                                {{--        <input type="number" class="rounded-md border-gray-700 border text-center p-1 w-20"
                                    min="1" value="{{ $quote->cantidad }}"> --}}
                            </div>
                            {{-- <p>Costo de Personalizacion: <span class="font-bold"> $ {{ $quote->price_technique }}
                                    c/u</span> </p> --}}
                        </div>
                        <div class="h-full text-center">
                            @if ($quote->logo)
                                <img src="{{ asset('storage/logos/' . $quote->logo) }}" class="h-20 w-auto">
                            @else
                                <p class="text-center">Sin logo</p>
                            @endif
                        </div>
                        <div class="flex flex-col items-end space-y-2">

                            @php
                                $precioTotal = round(($quote->costo_total / ((100 - config('settings.utility_aditional')) / 100)) * 1.16, 2);
                            @endphp
                            <p class="font-bold text-lg">$ {{ number_format($precioTotal, 2, '.', ',') }}</p>
                            <button type="button" onclick='eliminar({{ $quote->id }})'
                                class="block w-full text-center text-sm underline rounded-sm font-semibold py-1 px-4">
                                Eliminar del carrito
                            </button>
                            {{-- {{ $quote }} --}}
                            @if (count($quote->haveSampleProduct($quote->product->id)) > 0)
                                @php
                                    // Obtener el id del proceso de muestra que viene en un array
                                    $sampleProcess = $quote->haveSampleProduct($quote->product->id)->toArray();
                                @endphp
                                <a href="{{ route('procesoMuestra', ['id' => $sampleProcess[0]['id']]) }}"
                                    class=" bg-[#662D91] text-white block w-full text-center text-sm underline rounded-sm font-semibold py-1 px-4">
                                    Ver Proceso
                                </a>
                                <button
                                    class="block w-full border-primary hover:border-primary-dark text-center rounded-sm font-semibold py-1 px-4"
                                    onclick="solicitarMuestra({{ $quote->id }})">
                                    Solicitar Muestra
                                </button>
                            @else
                                <button
                                    class="block w-full border-2 border-primary hover:border-primary-dark text-center rounded-sm font-semibold py-1 px-4"
                                    onclick="solicitarMuestra({{ $quote->id }})">
                                    Solicitar Muestra
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="sm:col-span-2 col-span-1">
            <div class="py-8 px-6">
                <p class="text-md py-3 text-center font-bold">RESUMEN DEL PEDIDO</p>
                <div class="px-8 space-y-3">
                    {{--                     <div class="flex justify-between">
                        <p>Subtotal:</p>
                        <p class="font-bold">$ {{ $totalQuote }}</p>
                    </div>
                    <div class="flex justify-between">
                        <p>Costo de envio:</p>
                        <p class="font-bold">$ {{ $totalQuote }}</p>
                    </div>
                    <hr class="border-black"> --}}
                    <div class="flex justify-between">
                        <p>Total:</p>
                        @php
                            $total = round(($totalQuote / ((100 - config('settings.utility_aditional')) / 100)) * 1.16, 2);
                        @endphp
                        <p class="font-bold">$ {{ number_format($total, 2, '.', ',') }}</p>
                    </div>
                    <hr class="border-black">
                    <form action="{{ route('enviar-compra') }}" method="POST" class="col-start-2 col-span-4">
                        @method('POST')
                        @csrf
                        <button type="submit"
                            class="block w-full bg-primary hover:bg-primary-dark text-white text-center rounded-sm font-semibold py-2 px-4">
                            Enviar Carrito
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self
        class="hidden bg-slate-800 bg-opacity-50 justify-center items-center absolute top-0 right-0 bottom-0 left-0"
        id="modalSolicitarMuestra">
        <div class="bg-white px-16 py-6 rounded-sm text-center" style="width: 600px">
            <p class="text-xl mb-4 font-bold">Ingresa los datos para hacerte llegar la muestra</p>
            <div class="grid grid-cols-3 px-4">
                <div class="col-span-1 py-2 text-left">
                    <label for="nombre">Nombre: </label>
                </div>
                <div class="col-span-2 py-2 flex flex-col">
                    <input type="text" class="flex flex-wrap w-full ring-1 ring-inset placeholder:text-gray-300"
                        wire:model="nombre">
                    @error('nombre')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-1 py-2 text-left">
                    <label for="telefono">Telefono: </label>
                </div>
                <div class="col-span-2 py-2">
                    <input type="text" class="flex flex-wrap w-full ring-1 ring-inset placeholder:text-gray-300"
                        wire:model="telefono">
                    @error('telefono')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-1 py-2 text-left">
                    <label for="direcion">Direccion: </label>
                </div>
                <div class="col-span-2 py-2">
                    <textarea name="" id="" cols="10" rows="3"
                        class="flex flex-wrap w-full ring-1 ring-inset placeholder:text-gray-300" wire:model="direccion"></textarea>
                    @error('direccion')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button class="px-3 py-1 text-md " onclick="closeModal()">Cancelar</button>
            <button class="px-5 py-1 ml-2 rounded-sm text-md text-white font-semibold bg-primary hover:bg-primary-dark"
                wire:click="solicitarMuestra">Enviar</button>
        </div>

    </div>
    <script>
        function solicitarMuestra(id) {
            let modal = document.querySelector('#modalSolicitarMuestra')
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            @this.quote_id = id;
        }

        function closeModal() {
            let modal = document.querySelector('#modalSolicitarMuestra')
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        window.addEventListener('muestraSolicitada', event => {
            let modal = document.querySelector('#modalSolicitarMuestra')
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            Swal.fire({
                icon: event.detail.error ? "error" : "success",
                title: event.detail.msg,
                showConfirmButton: false,
                timer: 3000
            })
        })

        function eliminar(id) {
            Swal.fire({
                title: 'Esta seguro?',
                text: "Esta accion ya no se puede revertir!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar!',
                cancelButtonText: 'Cancelar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.eliminar(id)
                    Swal.fire(
                        'Eliminado!',
                        'El producto se ha eliminado.',
                        'success'
                    )
                }
            })
        }
    </script>
</div>
