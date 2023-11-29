<div class="mx-auto max-w-7xl py-2">
    <div class="flex items-center py-6">
        <div class="w-16">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-12 h-12">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>

        </div>
        <h2 class="text-4xl font-bold">Proceso de Compra</h2>


    </div>
    <div class="grid px-4 sm:grid-cols-7 grid-cols-1 pt-4">
        @if (count($cotizacionActual) <= 0)
            <div class="col-span-7 text-center">
                <p>No tienes una cotizacion activa</p>
                {{-- Boton para regresar al catalogo --}}
                <a href="{{ route('catalogo') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="w-6 h-6 mr-2 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Regresar al catalogo
                </a>
            </div>
        @else
            <div class="col-span-5">
                <div class="px-3 mx-3 mb-4 border-b border-gray-200 bg-stone-50  p-8 rounded-md">
                    <div class="flex flex-wrap justify-center">
                        {{-- pasos 1 --}}
                        @if ($pasos == 1)
                            <div class="col-span-2 flex justify-center">
                                <div class="border-b border-gray-200 dark:border-gray-700">
                                    <ul class="flex flex-wrap  text-sm text-center text-gray-500 dark:text-gray-400">
                                        <li class="mr-2">
                                            <a
                                                class="inline-flex p-1 px-2  text-black border-b-2 border-black rounded-t-lg active dark:text-black dark:border-black group">
                                                <div
                                                    class="rounded-full bg-black text-[#F2F2F2] h-6 w-6 mr-2 flex justify-center pt-[0.5px] ">
                                                    1
                                                </div>
                                                Cotizacion
                                            </a>
                                        </li>
                                        <li class="mr-2">
                                            <a
                                                class="inline-flex p-1 px-2 border-b-2 border-transparent rounded-t-lg text-[#B3B2B2]">
                                                <div
                                                    class="rounded-full bg-[#B3B2B2] text-[#F2F2F2] h-6 w-6 mr-2 flex justify-center pt-[0.5px]">
                                                    2
                                                </div>
                                                Orden de Compra
                                            </a>
                                        </li>
                                        <li>
                                            <a class="inline-flex p-1 px-2 border-b-2 border-transparent rounded-t-lg text-[#B3B2B2]"
                                                id="contacts-tab" data-tabs-target="#contacts" type="button"
                                                role="tab" aria-controls="contacts" aria-selected="false">

                                                <div
                                                    class="rounded-full bg-[#B3B2B2] text-[#F2F2F2] h-6 w-6 mr-2 flex justify-center pt-[0.5px] ">
                                                    3
                                                </div>
                                                Confirmacion
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="px-8 justify-between">
                                @if (count($cotizacionActual) > 0)
                                    @php
                                        $quoteByScales = false;
                                    @endphp
                                    @foreach ($cotizacionActual as $quote)
                                        <div class="shadow-md border border-black/50 p-4 rounded-md my-2">
                                            <div class="flex flex-wrap justify-between py-3 px-5 space-x-8">
                                                <div class="flex items-center">
                                                    <div style="width: 2rem">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <img src="{{ $quote->images_selected ?: ($quote->product->firstImage ? $quote->product->firstImage->image_url : asset('img/default.jpg')) }}"
                                                            alt="" width="100">
                                                    </div>
                                                </div>
                                                <div class="flex-grow">
                                                    <p class="font-bold text-lg">{{ $quote->product->name }}</p>
                                                    <p class="text-md">$ {{ $quote->precio_unitario }}</p>
                                                    <p class="text-md">{{ $quote->cantidad }} pz.</p>
                                                    <p>Costo de Personalizacion: <span class="font-bold"> $
                                                            {{ $quote->price_technique }} c/u</span> </p>
                                                </div>
                                                <div class="">
                                                    <p class="font-bold">$ {{ $quote->precio_total }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="space-x-2 grid grid-cols-2">
                                </div>
                                @error('direccionSeleccionada')
                                    <div class="bg-red-400 text-white w-full text-sm rounded-sm text-center mt-2 py-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        @endif
                        {{-- paso2 --}}
                        @if ($pasos == 2)
                            <div class="col-span-2 flex justify-center">
                                <div class="border-b border-gray-200 dark:border-gray-700">
                                    <ul class="flex flex-wrap  text-sm text-center text-gray-500 dark:text-gray-400">
                                        <li class="mr-2">
                                            <a
                                                class="inline-flex p-1 px-2 border-b-2 border-transparent rounded-t-lg text-[#B3B2B2]">
                                                <div
                                                    class="rounded-full bg-[#B3B2B2] text-[#F2F2F2] h-6 w-6 mr-2 flex justify-center pt-[0.5px]">
                                                    1
                                                </div>
                                                Cotizacion
                                            </a>
                                        </li>
                                        <li class="mr-2">
                                            <a
                                                class="inline-flex p-1 px-2  text-black border-b-2 border-black rounded-t-lg active dark:text-black dark:border-black group">
                                                <div
                                                    class="
                                            rounded-full bg-black text-[#F2F2F2] h-6 w-6 mr-2 flex justify-center pt-[0.5px] ">
                                                    2
                                                </div>
                                                Orden de Compra
                                            </a>
                                        </li>
                                        <li>
                                            <a class="inline-flex p-1 px-2 border-b-2 border-transparent rounded-t-lg text-[#B3B2B2]"
                                                id="contacts-tab" data-tabs-target="#contacts" type="button"
                                                role="tab" aria-controls="contacts" aria-selected="false">

                                                <div
                                                    class="rounded-full bg-[#B3B2B2] text-[#F2F2F2] h-6 w-6 mr-2 flex justify-center pt-[0.5px] ">
                                                    3
                                                </div>
                                                Confirmacion
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="px-8 justify-between">
                                @if (count($cotizacionActual) > 0)
                                    @php
                                        $quoteByScales = false;
                                    @endphp
                                    @foreach ($cotizacionActual as $quote)
                                        <div
                                            class="flex flex-wrap shadow-md border border-black/50 p-4 rounded-md my-2">
                                            <div class="flex flex-wrap justify-between py-3 px-5 space-x-8">
                                                <div class="flex items-center">
                                                    <div style="width: 2rem">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <img src="{{ $quote->images_selected ?: ($quote->product->firstImage ? $quote->product->firstImage->image_url : asset('img/default.jpg')) }}"
                                                            alt="" width="100">
                                                    </div>
                                                </div>
                                                <div class="flex-grow">
                                                    <p class="font-bold text-lg">{{ $quote->product->name }}</p>
                                                    <p class="text-md">$ {{ $quote->precio_unitario }}</p>
                                                    <p class="text-md">{{ $quote->cantidad }} pz.</p>
                                                    <p>Costo de Personalizacion: <span class="font-bold"> $
                                                            {{ $quote->price_technique }} c/u</span> </p>
                                                </div>
                                                <div class="">
                                                    <p class="font-bold">$ {{ $quote->precio_total }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                @if ($pasos == 1 || $pasos == 2 || $pasos == 3)
                                    <div class="space-x-2 grid grid-cols-2">
                                        <button
                                            class="col-start-1 col-end-1  bg-transparent-300 py-2 text-black underline font-bold col-span-4">
                                            Revisar direccion de envio
                                        </button>
                                        <button
                                            class="col-start-2 bg-gray-400 py-2 text-stone-50 col-span-4 hover:bg-black
                                        p-1 px-2 border-b-2 border-transparent"
                                            wire:click="increase()">
                                            En proceso de autorizacion
                                        </button>
                                @endif

                            </div>
                            <div>

                            </div>
                        @endif

                        {{-- pasos 3 --}}

                        @if ($pasos == 3)
                            <div class="col-span-2 flex justify-center">
                                <div class="border-b border-gray-200 dark:border-gray-700">
                                    <ul class="flex flex-wrap  text-sm text-center text-gray-500 dark:text-gray-400">
                                        <li class="mr-2">
                                            <a
                                                class="inline-flex p-1 px-2 border-b-2 border-transparent rounded-t-lg text-[#B3B2B2]">
                                                <div
                                                    class="rounded-full bg-[#B3B2B2] text-[#F2F2F2] h-6 w-6 mr-2 flex justify-center pt-[0.5px]">
                                                    1
                                                </div>
                                                Cotizacion
                                            </a>
                                        </li>
                                        <li class="mr-2">
                                            <a
                                                class=" inline-flex p-1 px-2 border-b-2 border-transparent rounded-t-lg text-[#B3B2B2]">
                                                <div
                                                    class="    rounded-full bg-[#B3B2B2] text-[#F2F2F2] h-6 w-6 mr-2 flex justify-center pt-[0.5px] ">
                                                    2
                                                </div>
                                                Orden de Compra
                                            </a>
                                        </li>
                                        <li>
                                            <a class="inline-flex p-1 px-2  text-black border-b-2 border-black rounded-t-lg active dark:text-black dark:border-black group
                              "
                                                id="contacts-tab" data-tabs-target="#contacts" type="button"
                                                role="tab" aria-controls="contacts" aria-selected="false">

                                                <div
                                                    class="  rounded-full bg-black text-[#F2F2F2] h-6 w-6 mr-2 flex justify-center pt-[0.5px]
                                    ">
                                                    3
                                                </div>
                                                Confirmacion
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="px-8 justify-between">
                                @if (count($cotizacionActual) > 0)
                                    @php
                                        $quoteByScales = false;
                                    @endphp
                                    @foreach ($cotizacionActual as $quote)
                                        <div
                                            class="flex flex-wrap shadow-md border border-black/50 p-4 rounded-md my-2">
                                            <div class="flex flex-wrap justify-between py-3 px-5 space-x-8">
                                                <div class="flex items-center">
                                                    <div style="width: 2rem">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <img src="{{ $quote->images_selected ?: ($quote->product->firstImage ? $quote->product->firstImage->image_url : asset('img/default.jpg')) }}"
                                                            alt="" width="100">
                                                    </div>
                                                </div>
                                                <div class="flex-grow">
                                                    <p class="font-bold text-lg">{{ $quote->product->name }}</p>
                                                    <p class="text-md">$ {{ $quote->precio_unitario }}</p>
                                                    <p class="text-md">{{ $quote->cantidad }} pz.</p>
                                                    <p>Costo de Personalizacion: <span class="font-bold"> $
                                                            {{ $quote->price_technique }} c/u</span> </p>
                                                </div>
                                                <div class="">
                                                    <p class="font-bold">$ {{ $quote->precio_total }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="space-x-5 grid grid-cols-2 hyphens-auto">
                                    <button
                                        class="col-start-1 col-end-1  bg-transparent-300 py-2 text-black underline font-bold col-span-4">
                                        Revisar direccion de envio
                                    </button>
                                    <button
                                        class="col-start-2 bg-gray-400 py-2 text-stone-50 col-span-4 hover:bg-black
                                     p-1 px-2 border-b-2 border-transparent space-y-4">
                                        Tu orden de compra fue generada correctamente
                                        <br>
                                        <span>Tu pedido se esta preparando</span>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>


            </div>
            <div class="md:col-span-2 col-span-1">
                <div class="py-4 px-3 mx-3  bg-stone-50 rounded-md">
                    <p class="text-md py-3 text-center font-bold">RESUMEN DEL PEDIDO</p>
                    <div class="px-8 space-y-3">
                        <hr class="border-black">
                        <div class="flex justify-between">
                            <p>Total:</p>
                            <p class="font-bold">$ {{ number_format($totalQuote, 2, '.', ',') }}</p>
                        </div>
                        <hr class="border-black">
                        <div>
                            <form action="{{ route('enviar-compra') }}" method="POST"
                                class="col-start-2 col-span-4">
                                @method('POST')
                                @csrf
                                <button type="submit"
                                    class="w-full py-2 text-stone-50 border-2 border-[#0047BB] hover:border-[#009CDE] bg-[#0047BB] hover:bg-[#009CDE]">
                                    Enviar Carrito
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>


    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        window.addEventListener('isntCompany', event => {
            Swal.fire('No tienes una empresa asignada')
        })

        function preview() {
            $('#modalPreview').modal('show')
            @this.previewQuote()
        }

        function cerrarPreview() {
            $('#modalPreview').modal('hide')
            @this.urlPDFPreview = null;
        }

        function enviar() {
            Swal.fire({
                title: '¿Desea confirmar la cotización?',
                showCancelButton: true,
                icon: 'warning',
                confirmButtonText: 'Guardar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    @this.guardarCotizacion()
                } else {
                    Swal.fire('No se realizo ningun cambio', '', 'info')
                }
            })
        }
        window.addEventListener('alert', event => {
            Swal.fire({
                icon: event.detail.type,
                title: event.detail.message,
                showConfirmButton: false,
                timer: 3000
            })
        })
    </script>
</div>
