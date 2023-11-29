<div class="container mx-auto max-w-7xl py-2">
    <div class="flex flex-col md:flex-row p-2 md:gap-x-5 gap-y-4 lg:gap-x-24">
        <div class="w-full md:w-2/3 lg:w-[62%]">
            <div class="bg-[#EEEEEE] rounded-lg grid grid-cols-2 gap-x-6 p-4 lg:gap-x-0">
                <div class="col-span-2 ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-7 h-7 lg:w-9 lg:h-9 lg:mb-4 block mb-2" style="display: inline">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
                    </svg>
                    <strong class="text-2xl lg:text-4xl m-"> PROCESO DE ENTREGA </strong>
                </div>
                @if ($quote->status === 0)
                    <div class="col-span-2 text-center font-bold text-xl py-3">Pedido En Espera</div>
                @endif
                <div class="tabs col-span-2 flex justify-center">
                    <div class="border-b border-gray-200 dark:border-gray-700">
                        <ul class="flex flex-wrap  text-sm text-center text-gray-500 dark:text-gray-400">

                            <li class="mr-2">
                                <a href="#"
                                    class="inline-flex p-1 px-2 border-b-2  rounded-t-lg
                                    {{ $quote->status >= 1 ? 'text-black' : 'text-[#B3B2B2]' }}
                                    {{ $quote->status === 1 ? 'border-black' : 'border-transparent' }}">
                                    <div
                                        class="rounded-full  text-[#F2F2F2] h-6 w-6 mr-2 flex justify-center pt-[0.5px]
                                        {{ $quote->status >= 1 ? 'bg-black' : 'bg-[#B3B2B2] ' }}">
                                        1
                                    </div>
                                    TU PEDIDO SE ESTA PREPARANDO
                                </a>
                            </li>
                            <li class="mr-2">
                                <a href="#"
                                    class="inline-flex p-1 px-2 border-b-2  rounded-t-lg
                                    {{ $quote->status >= 2 ? 'text-black border-black' : 'text-[#B3B2B2]' }}
                                    {{ $quote->status === 2 ? 'border-black' : 'border-transparent' }}">
                                    <div
                                        class="rounded-full  text-[#F2F2F2] h-6 w-6 mr-2 flex justify-center pt-[0.5px]
                                        {{ $quote->status >= 2 ? 'bg-black' : 'bg-[#B3B2B2] ' }}">
                                        2
                                    </div>
                                    TU PEDIDO VA EN CAMINO
                                </a>
                            </li>
                            <li class="mr-2">
                                <a href="#"
                                    class="inline-flex p-1 px-2 border-b-2  rounded-t-lg
                                {{ $quote->status >= 3 ? 'text-black' : 'text-[#B3B2B2]' }}
                                {{ $quote->status === 3 ? 'border-black' : 'border-transparent' }}">
                                    <div
                                        class="rounded-full  text-[#F2F2F2] h-6 w-6 mr-2 flex justify-center pt-[0.5px]
                                    {{ $quote->status >= 3 ? 'bg-black' : 'bg-[#B3B2B2] ' }}">
                                        3
                                    </div>
                                    ENTREGADO
                                </a>
                            </li>
                    </div>
                </div>
                <div class="col-span-2">
                    @foreach ($products as $product)
                        @php
                            $producto = (object) json_decode($product->product);
                        @endphp
                        <div class="grid grid-cols-2">
                            <div class="flex justify-end  md:py-9 lg:py-3 lg:justify-center lg:px-20">
                                <img class="rounded-lg"
                                    src="{{ $producto->image == '' ? asset('img/default.jpg') : $producto->image }}"
                                    class="h-full" alt="" srcset="">
                            </div>
                            <div class="align-middle">
                                <p class="m-0 p-0 block">
                                    <strong> {{ $producto->name }}
                                    </strong>
                                </p>
                                <p class="m-0 p-0 block">
                                    <span>Llega el 14 de marzo</span>
                                </p>
                                <p class="m-0 p-0 block">
                                    <strong>Precio unitario</strong>
                                    <span>$ {{ $product->precio_unitario }}</span>
                                </p>
                                <p class="m-0 p-0 block">
                                    <strong>Cantidad</strong>
                                    <span>$ {{ $product->cantidad }}</span>
                                </p>
                                <p class="m-0 p-0 block">
                                    <strong>Descripción:</strong>
                                </p>
                                <p>
                                    <span> {{ $producto->description }}</span>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            {{-- Colocar la direccion de esa cotizacion --}}
            <div class="bg-[#EEEEEE] rounded-lg p-4 mt-4">
                <div class="col-span-2 flex justify-center">
                    <strong>INFORMACIÓN DE ENVIO</strong>
                </div>
                <br>
                <div class="grid grid-cols-2 gap-y-1">
                    <div>
                        <strong>Nombre:</strong>
                        <span>{{ $quote->address->nombre }}</span>
                    </div>
                    <div>
                        <strong>Apellido:</strong>
                        <span>{{ $quote->address->apellidos }}</span>
                    </div>
                    <div>
                        <strong>Calle:</strong>
                        <span>{{ $quote->address->calle }}</span>
                    </div>
                    <div>
                        <strong>N. Exterior:</strong>
                        <span>{{ $quote->address->numero_exterior }}</span>
                    </div>
                    <div>
                        <strong>N. Interior:</strong>
                        <span>{{ $quote->address->numero_interior }}</span>
                    </div>
                    <div>
                        <strong>Referencias:</strong>
                        <span>{{ $quote->address->referencias }}</span>
                    </div>
                    <div>
                        <strong>Colonia:</strong>
                        <span>{{ $quote->address->colonia }}</span>
                    </div>
                    <div>
                        <strong>Código Postal:</strong>
                        <span>{{ $quote->address->codigo_postal }}</span>
                    </div>
                    <div>
                        <strong>Delegacion:</strong>
                        <span>{{ $quote->address->delegacion_municipal }}</span>
                    </div>
                    <div>
                        <strong>Estado:</strong>
                        <span>{{ $quote->address->estado }}</span>
                    </div>
                    <div>
                        <strong>Telefono:</strong>
                        <span>{{ $quote->address->telefono }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full md:w-1/3 lg:w-1/4">
            <div class="bg-stone-50 rounded-lg p-4 grid grid-cols-2 gap-y-1">
                <div class="col-span-2 flex justify-center">
                    <strong>RESUMEN DEL PEDIDO</strong>
                </div>
                <span class="">Total :</span>
                <strong class="text-right">$
                    {{ number_format($quote->latestQuotesUpdate->quoteProducts->sum('precio_total'), 2, '.', ',') }}
                </strong>
                <hr class="col-span-2 h-[2.0px] bg-black">
            </div>
            @role('seller')
                <div class="flex-grow space-y-3">
                    <div class="flex items-center space-x-3 mt-2">
                        <strong>Estado de la Compra:</strong>
                        <select wire:model="quoteStatus"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[45%] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="1" {{ $quote->status == 1 ? 'disabled' : '' }}>Se esta preparando</option>
                            <option value="2" {{ $quote->status == 2 ? 'disabled' : '' }}>Va en camino</option>
                            <option value="3" {{ $quote->status == 3 ? 'disabled' : '' }}>Ya se entrego</option>
                        </select>
                    </div>

                    <div class="flex items-center space-x-3 mt-2">
                        <button class="block w-full bg-red-700 text-white text-center rounded-sm font-semibold py-1 px-4"
                            wire:click='updatePedidoStatus'>
                            Confirmar Cambio De Estado
                        </button>
                    </div>
                </div>
            @endrole
            @if (Auth::user()->hasRole('admin') == false)
                <div class="rounded-lg bg-stone-50 flex flex-col justify-items-center gap-3 py-4 p-5 mt-3 h-96">
                    <strong class="text-center">Atencion a cliente</strong>
                    <div class="flex-1 grid overflow-y-auto h-80">
                        @foreach ($comments as $message)
                            @if ($message->role_id == 2)
                                <ul class="justify-self-start w-4/5">
                                    <li class="bg-slate-100 rounded-2xl">
                                        <div>
                                            <p class="text-left mt-1 text-sm px-2">
                                                <strong>{{ $message->name }}</strong>
                                            </p>
                                            <p class="text-left mt-1 px-2">{{ $message->message }}</p>
                                            <p class="text-right mt-1 px-2 text-sm text-gray-500">
                                                {{ $message->created_at->format('H:i:s') }}</p>
                                        </div>
                                    </li>
                                </ul>
                            @else
                                <ul class="justify-self-end w-4/5 rounded-all">

                                    <li class="bg-red-700 rounded-2xl">
                                        <div>
                                            <p class="text-left mt-1 px-2 text-sm text-white">
                                                <strong>{{ $message->name }}</strong>
                                            </p>
                                            <p class="text-left mt-1 px-2 text-white">{{ $message->message }}</p>
                                            <p class="text-right mt-1 px-2 text-sm text-white">
                                                {{ $message->created_at->format('H:i:s') }}</p>
                                        </div>
                                    </li>

                                </ul>
                            @endif
                        @endforeach
                    </div>
                    <form wire:submit.prevent="addMessage" class="flex mt-1 py-1">
                        <input wire:model="message" class="border border-gray-300 rounded p-2 mr-2">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Enviar</button>

                    </form>
                </div>
            @endif
        </div>

    </div>
    <script>
        window.addEventListener('cambio-status', event => {
            Swal.fire({
                icon: "success",
                title: "Se ha hactualizado el estado de la compra",
                showConfirmButton: false,
                timer: 3000
            })
        });
    </script>
</div>
