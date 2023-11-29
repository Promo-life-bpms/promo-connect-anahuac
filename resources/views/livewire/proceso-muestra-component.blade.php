<div class="mx-auto">
    @php
        $priceProduct = $product->price;
    @endphp
    @if ($product->precio_unico)
        @php
            if ($product->producto_promocion) {
                $priceProduct = round($priceProduct - $priceProduct * ($product->descuento / 100), 2);
            } else {
                $priceProduct = round($priceProduct - $priceProduct * ($product->discount / 100), 2);
            }
        @endphp
    @endif
    <div class="container mx-auto max-w-7xl py-2">
        <div class="flex flex-col md:flex-row p-2 md:gap-x-5 gap-y-4 lg:gap-x-24">
            <div class="w-full md:w-2/3 lg:w-[62%]">
                <div class="bg-stone-50 rounded-lg grid grid-cols-2 gap-x-6 p-4 lg:gap-x-0">

                    <div class="col-span-2 ">
                        <button wire:click="goBack" class="lg:hidden">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-7 h-7 lg:w-9 lg:h-9 lg:mb-4 block mb-2"
                                style="display: inline">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
                            </svg>
                        </button>

                        <strong class="text-2xl lg:text-4xl m-"> PROCESO DE ENTREGA </strong>
                    </div>

                    <div class="tabs col-span-2 flex justify-center">
                        <div class="border-b border-gray-200 dark:border-gray-700">
                            <ul class="flex flex-wrap  text-sm text-center text-gray-500 dark:text-gray-400">
                                <li class="mr-2">
                                    <a href="#"
                                        class="inline-flex p-1 px-2 border-b-2  rounded-t-lg
                                        {{ $muestra->status >= 1 ? 'text-black' : 'text-[#B3B2B2]' }}
                                        {{ $muestra->status === 1 ? 'border-black' : 'border-transparent' }}">
                                        <div
                                            class="rounded-full  text-[#F2F2F2] h-6 w-6 mr-2 flex justify-center pt-[0.5px]
                                            {{ $muestra->status >= 1 ? 'bg-black' : 'bg-[#B3B2B2] ' }}">
                                            1
                                        </div>
                                        TU MUESTRA SE ESTA PREPARANDO
                                    </a>
                                </li>
                                <li class="mr-2">
                                    <a href="#"
                                        class="inline-flex p-1 px-2 border-b-2  rounded-t-lg
                                        {{ $muestra->status >= 2 ? 'text-black' : 'text-[#B3B2B2]' }}
                                        {{ $muestra->status === 2 ? 'border-black' : 'border-transparent' }}">
                                        <div
                                            class="rounded-full  text-[#F2F2F2] h-6 w-6 mr-2 flex justify-center pt-[0.5px]
                                            {{ $muestra->status >= 2 ? 'bg-black' : 'bg-[#B3B2B2] ' }}">
                                            2
                                        </div>
                                        TU MUESTRA VA EN CAMINO
                                    </a>
                                </li>
                                <li class="mr-2">
                                    <a href="#"
                                        class="inline-flex p-1 px-2 border-b-2  rounded-t-lg
                                    {{ $muestra->status >= 3 ? 'text-black' : 'text-[#B3B2B2]' }}
                                    {{ $muestra->status === 3 ? 'border-black' : 'border-transparent' }}">
                                        <div
                                            class="rounded-full  text-[#F2F2F2] h-6 w-6 mr-2 flex justify-center pt-[0.5px]
                                        {{ $muestra->status >= 3 ? 'bg-black' : 'bg-[#B3B2B2] ' }}">
                                            3
                                        </div>
                                        ENTREGADO
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class=" col-span-2 p-5 flex justify-around w-full">
                        <p><strong>Fecha de Solicitud: </strong>{{ $muestra->created_at->format('d-m-Y') }}</p>
                        <p><strong>Fecha de Entrega Aproximada: </strong>{{ $muestra->created_at->format('d-m-Y') }}
                        </p>
                    </div>
                    <div class="flex justify-center py-16 md:py-9 lg:py-3 lg:justify-center ">
                        <img src="{{ $product->images_selected ?: ($product->firstImage ? $product->firstImage->image_url : asset('img/default.jpg')) }}"
                            alt="" class="w-auto h-40">
                    </div>
                    <div class="grid grid-cols-1 gap-y-1">
                        <div>
                            <strong>{{ $product->name }}</strong>
                        </div>
                        <div>
                            @if ($muestra->status === 1)
                                <strong class="">ESTAMOS PREPARANDO TU PEDIDO</strong>
                            @endif
                            @if ($muestra->status === 2)
                                <strong class="">TU PEDIDO YA ESTA LISTO Y VA EN CAMINO</strong>
                            @endif
                            @if ($muestra->status === 3)
                                <strong class="">TU PEDIDO SE TE HA ENTREGADO CORRECTAMENTE</strong>
                            @endif
                        </div>
                        <div>
                            <strong>Precio unitario:</strong>
                            <span>$ {{ round($priceProduct / ((100 - $utilidad) / 100), 2) }}</span>
                        </div>
                        <div>
                            <strong>Descripción:
                            </strong>
                        </div>
                        <div>
                            <span> {{ $product->description }}
                            </span>
                        </div>
                    </div>
                </div>
                {{-- Colocar una seccion para la informacion de la  muestra que tiene name, address y phone --}}
                <div class="bg-stone-50 rounded-lg grid grid-cols-2 gap-x-6 p-4 lg:gap-x-0 mt-4">
                    <div class="grid grid-cols-1 gap-y-1">
                        <div>
                            <strong>Direccion de Envio</strong>
                        </div>
                        <div>
                            <strong>Nombre:</strong>
                            <span>{{ $muestra->name }}</span>
                        </div>
                        <div>
                            <strong>Teléfono:</strong>
                            <span>{{ $muestra->phone }}</span>
                        </div>
                        <div>
                            <strong>Dirección:</strong>
                            <span>{{ $muestra->address }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/3 lg:w-1/4">
                @role('seller')
                    <div class="flex-grow space-y-3">
                        <div class="flex items-center space-x-3 mt-2">
                            <strong>Estado de la muestra:</strong>
                            <select wire:model="productStatus"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[45%] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="1">Se esta preparando</option>
                                <option value="2">Va en camino</option>
                                <option value="3">Ya se entrego</option>
                            </select>
                        </div>

                        <div class="flex items-center space-x-3 mt-2">
                            <button
                                class="block w-full bg-red-700 text-white text-center rounded-sm font-semibold py-1 px-4"
                                wire:click='updateMuestraStatus'>
                                Confirmar Cambio De Estado
                            </button>
                        </div>
                    </div>
                    <br>
                @endrole
                <div class="h-[500px] overflow-x-clip rounded-lg bg-stone-50 py-4 p-5 flex flex-col">
                    <strong class="text-center pb-3">Atencion a cliente</strong>
                    <div class="flex-grow bg-stone-50  overflow-y-auto">
                        <ul class="flex flex-col space-y-2">
                            @foreach ($comments as $message)
                                @if ($message->role_id == 2)
                                    <li class=" flex justify-start">
                                        <div class="w-3/4 bg-slate-100 rounded-2xl px-2 py-1">
                                            <p class="text-left text-sm"><strong>{{ $message->name }}</strong></p>
                                            <p class="text-left">{{ $message->message }}</p>
                                            <p class="text-right text-sm text-gray-500">
                                                {{ $message->created_at->format('H:i:s') }}</p>
                                        </div>
                                    </li>
                                @else
                                    <li class=" flex justify-end">
                                        <div class="w-3/4 bg-blue-500 rounded-2xl px-2 py-1">
                                            <p class="text-left text-white text-sm">
                                                <strong>{{ $message->name }}</strong>
                                            </p>
                                            <p class="text-left text-white">{{ $message->message }}</p>
                                            <p class="text-right text-sm text-white">
                                                {{ $message->created_at->format('H:i:s') }}</p>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <form wire:submit.prevent="addMessage" class="mt-4 flex space-x-1 w-full">
                        <input wire:model="message" class="border border-gray-300 rounded p-2">
                        <button class="bg-blue-500 text-white px-4 py-2 rounded">Enviar</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <script>
        window.addEventListener('cambio-status', event => {
            Swal.fire({
                icon: "success",
                title: "Se ha hactualizado el estado de la muestra",
                showConfirmButton: false,
                timer: 3000
            })
        });
    </script>
</div>
