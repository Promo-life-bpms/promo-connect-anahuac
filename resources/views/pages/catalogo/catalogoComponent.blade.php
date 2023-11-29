<div class="bg-gray-100">
    <div class="w-full bg-white">
        <div class="container mx-auto max-w-7xl py-2">
            <div class="grid grid-cols-1 sm:grid-cols-8 text-slate-700 " wire:target="changeCategory">
                @foreach ($categories as $categoria)
                    @if (
                        $categoria->family != 'CABALLERO' ||
                            $categoria->family != 'Boligrafos de Plastico' ||
                            $categoria->family != 'ESCOLARES')
                        <a class="py-1 text-center sm:border-l sm:border-slate-700 sm:last:border-r sm:text-center sm:font-semibold hover:cursor-pointer hover:bg-slate-200 rounded-sm {{ $categoria->id == $category ? 'bg-slate-200' : '' }}"
                            wire:click="changeCategory({{ $categoria->id }})">
                            {{ strtoupper($categoria->family) }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div id="accordion-collapse" data-accordion="collapse" wire:ignore>
        <h2 id="accordion-collapse-heading-3">
            <button type="button" class="w-full bg-slate-700 text-white justify-center flex py-1"
                data-accordion-target="#accordion-collapse-body-3" aria-expanded="false"
                aria-controls="accordion-collapse-body-3">
                <span>FILTRO DE BUSQUEDA</span>
                <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </h2>
        <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-3">
            <div class="w-full bg-white">
                <div class="container mx-auto max-w-7xl p-2">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 text-slate-700 gap-2">
                        <div class="flex gap-1 items-center">
                            <label for="name" class="text-slate-400 w-1/3">Nombre:</label>
                            <input wire:model='nombre' type="text"
                                class="py-1 px-2 border border-slate-700 rounded w-full" name="search" id="search"
                                placeholder="Nombre">
                        </div>
                        <div class="flex gap-1 items-center">
                            <label for="color" class="text-slate-400 w-1/3">Color:</label>
                            <input wire:model='color' type="text"
                                class="py-1 px-2 border border-slate-700 rounded w-full" name="color" id="color"
                                placeholder="Color">
                        </div>
                        <div class="flex gap-1 items-center">
                            <label for="piezas" class="text-slate-400 w-1/3">Piezas:</label>
                            <div class="flex gap-1 items-center">
                                <input wire:model='stockMin' type="number"
                                    class="py-1 px-2 border border-slate-700 rounded w-1/2" name="piezas"
                                    id="piezas" placeholder="Max">
                                <input wire:model='stockMax' type="number"
                                    class="py-1 px-2 border border-slate-700 rounded w-1/2" name="piezas1"
                                    id="piezas1" placeholder="Min">
                            </div>
                        </div>
                        <div class="flex gap-1 items-center">
                            <label for="precio" class="text-slate-400 w-1/3">Precio:</label>
                            <div class="flex gap-1 items-center">
                                <input wire:model='precioMin' type="number"
                                    class="py-1 px-2 border border-slate-700 rounded w-1/2" name="precio1"
                                    id="precio1" placeholder="Max">
                                <input wire:model='precioMax' type="number"
                                    class="py-1 px-2 border border-slate-700 rounded w-1/2" name="precio"
                                    id="precio" placeholder="Min">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="container mx-auto max-w-6xl px-2">
        <div class="text-center text-4xl font-semibold text-slate-700 py-8">CATALOGO DE PRODUCTOS</div>
        <div class="relative" wire:loading.class="opacity-40">
            <div class="absolute top-5 w-full">
                <div wire:loading.flex class="justify-center">
                    <div class="sk-chase">
                        <div class="sk-chase-dot"></div>
                        <div class="sk-chase-dot"></div>
                        <div class="sk-chase-dot"></div>
                        <div class="sk-chase-dot"></div>
                        <div class="sk-chase-dot"></div>
                        <div class="sk-chase-dot"></div>
                    </div>
                </div>
            </div>
            @if (count($products) <= 0)
                <div class="flex flex-wrap justify-center items-center flex-col  text-slate-700">
                    <p>No hay resultados de busqueda en la pagina actual</p>
                    @if (count($products->items()) == 0 && $products->currentPage() > 1)
                        <p>Click en la paginacion para ver mas resultados</p>
                    @endif
                </div>
            @endif
            <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 gap-8 pb-8">
                @foreach ($products as $row)
                    <div class="w-full h-auto bg-white rounded-xl shadow-md overflow-hidden p-4">
                        <div
                            class="flex sm:block gap-2 sm:bg-transparent bg-white rounded-md sm:rounded-none p-2 sm:p-0">
                            @php
                                $priceProduct = $row->price;
                                if ($row->producto_promocion) {
                                    $priceProduct = round($priceProduct - $priceProduct * ($row->descuento / 100), 2);
                                } else {
                                    $priceProduct = round($priceProduct - $priceProduct * ($row->provider->discount / 100), 2);
                                }
                                $priceProduct = round($priceProduct / ((100 - $utilidad) / 100), 2);
                                $priceProduct = round($priceProduct / ((100 - config('settings.utility_aditional')) / 100), 2);
                            @endphp
                            <div class="w-full flex justify-center  sm:p-5 sm:bg-white  text-center">
                                <div class="">
                                    <img src="{{ $row->firstImage ? $row->firstImage->image_url : '' }}"
                                        class="w-auto h-52" alt="{{ $row->name }}">
                                </div>
                            </div>
                            <div class="text-center flex-grow gap-2 flex flex-col justify-between sm:block">
                                <div class="py-2 text-lg text-slate-700">
                                    <h5 class="capitalize font-bold m-0">
                                        {{ Str::limit($row->name, 22, '...') }}</h5>
                                    <p class="m-0 font-semibold">$
                                        {{ $priceProduct }}</p>
                                </div>
                                <a href="{{ route('show.product', ['product' => $row->id]) }}"
                                    class="block w-full bg-primary hover:bg-primary-dark text-white text-center rounded-sm font-semibold py-2 rounded-xl">
                                    Cotizar
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class=" flex sm:hidden justify-center">
            {{ $products->onEachSide(0)->links() }}
        </div>
        <div class="hidden sm:flex justify-center">
            {{ $products->onEachSide(3)->links() }}
        </div>
        <br>
    </div>
    <style>
        .sk-chase {
            width: 40px;
            height: 40px;
            position: relative;
            animation: sk-chase 2.5s infinite linear both;
        }

        .sk-chase-dot {
            width: 100%;
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
            animation: sk-chase-dot 2.0s infinite ease-in-out both;
        }

        .sk-chase-dot:before {
            content: '';
            display: block;
            width: 25%;
            height: 25%;
            background-color: #000;
            border-radius: 100%;
            animation: sk-chase-dot-before 2.0s infinite ease-in-out both;
        }

        .sk-chase-dot:nth-child(1) {
            animation-delay: -1.1s;
        }

        .sk-chase-dot:nth-child(2) {
            animation-delay: -1.0s;
        }

        .sk-chase-dot:nth-child(3) {
            animation-delay: -0.9s;
        }

        .sk-chase-dot:nth-child(4) {
            animation-delay: -0.8s;
        }

        .sk-chase-dot:nth-child(5) {
            animation-delay: -0.7s;
        }

        .sk-chase-dot:nth-child(6) {
            animation-delay: -0.6s;
        }

        .sk-chase-dot:nth-child(1):before {
            animation-delay: -1.1s;
        }

        .sk-chase-dot:nth-child(2):before {
            animation-delay: -1.0s;
        }

        .sk-chase-dot:nth-child(3):before {
            animation-delay: -0.9s;
        }

        .sk-chase-dot:nth-child(4):before {
            animation-delay: -0.8s;
        }

        .sk-chase-dot:nth-child(5):before {
            animation-delay: -0.7s;
        }

        .sk-chase-dot:nth-child(6):before {
            animation-delay: -0.6s;
        }

        @keyframes sk-chase {
            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes sk-chase-dot {

            80%,
            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes sk-chase-dot-before {
            50% {
                transform: scale(0.4);
            }

            100%,
            0% {
                transform: scale(1.0);
            }
        }
    </style>
</div>
