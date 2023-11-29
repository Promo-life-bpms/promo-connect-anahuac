@php
    $layout = auth()
        ->user()
        ->hasRole(['seller', "buyers-manager"])
        ? 'cotizador'
        : 'app';
@endphp

@extends('layouts.' . $layout)


@section('content')
    <div class="container-fluid">
        <div>
            @foreach ($infouser as $user)
                <div class="row px-3">
                    <div class="card w-100">
                        <div class="card-body">
                            <div class="bg-white container mx-auto h-auto max-w-7xl grid md:grid-cols-2 p-3 gap-y-2">

                                <div class="relative  md:col-span-2  lg:mx-32 lg:mt-2 ">
                                    <h1>Informacion Del Usuario</h1>
                                    <div>
                                        <strong>Nombre:</strong>

                                        <span>{{ $user->name }}</span>
                                    </div>
                                    <div>
                                        <strong>Email:</strong>
                                        <span>{{ $user->email }}</span>
                                    </div>

                                </div>

                                <div class="relative overflow-y-auto md:col-span-2  lg:mx-32 lg:mt-2 ">
                                    <strong>COMPRAS</strong>
                                    <div class="relative" wire:loading.class="opacity-70">
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
                                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                            <thead class="text-xs text-white uppercase bg-[#2B2D2F] ">
                                                <tr>
                                                    <th scope="col" class="px-3 py-2 md:px-6  md:py-3">
                                                        NOMBRE
                                                    </th>
                                                    <th scope="col" class="px-3 py-2 md:px-6  md:py-3">
                                                        NOMBRE PEDIDO
                                                    </th>
                                                    <th scope="col" class="px-3 py-2 md:px-6  md:py-3">
                                                        NO. ORDEN DE COMPRA
                                                    </th>
                                                    <th scope="col" class="px-3 py-2 md:px-6  md:py-3">
                                                        IMPORTE DE PEDIDO
                                                    </th>
                                                    <th scope="col" class="px-3 py-2 md:px-6  md:py-3">
                                                        TOTAL DE COMPRA
                                                    </th>
                                                    <th scope="col" class="px-3 py-2 md:px-6  md:py-3">

                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @if ($longitudcompras > 0)
                                                    @foreach ($compras as $compra)
                                                        <?php
                                                        $price = $compra->precio_unitario;
                                                        ?>
                                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                            <th scope="row"
                                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                                {{ $compra->name }}
                                                            </th>
                                                            <td class="px-6 py-4">
                                                                ---
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                {{ $compra->lead }}
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                @if ($compra->precio_unitario)
                                                                    @if ($compra->precio_unitario > 0)
                                                                        <span>$</span>
                                                                        <span>{{ number_format($price, 2, '.', ',') }}
                                                                        </span>
                                                                    @else
                                                                        <span>$</span>
                                                                        <span>0.00
                                                                        </span>
                                                                    @endif
                                                                @else
                                                                    <span class="text-center">Sin Dato</span>
                                                                @endif
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                <span>$</span>
                                                                <span>{{ number_format($price * 0.16 + $price, 2, '.', ',') }}</span>
                                                            </td>
                                                            <td class="w-[15%]">

                                                                <a href="{{ route('verCotizacion', ['quote' => $compra->id]) }}"
                                                                    class="btn-sm"> <button
                                                                        class="bg-[#2B2D2F] text-white h-[50px] w-full px-2 ">VER
                                                                        COMPRA</button>
                                                                </a>
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <td colspan="6" class=" text-center">
                                                        No tiene compras por el momento
                                                    </td>
                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="relative overflow-y-auto md:col-span-2  lg:mx-32 lg:mt-2 ">
                                    <strong>MUESTRAS</strong>
                                    <div class="relative" wire:loading.class="opacity-70">
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
                                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 col-span-2">
                                            <thead class="text-xs text-white uppercase bg-[#2B2D2F] ">
                                                <tr>
                                                    <th scope="col" class="px-3 py-2 md:px-6  md:py-3">
                                                        NOMBRE
                                                    </th>
                                                    <th scope="col" class="px-3 py-2 md:px-6  md:py-3">
                                                        FECHA
                                                    </th>
                                                    <th scope="col" class="px-3 py-2 md:px-6  md:py-3">
                                                        DIRECCIÓN
                                                    </th>
                                                    <th scope="col" class="px-3 py-2 md:px-6  md:py-3">
                                                        PRODUCTO
                                                    </th>
                                                    {{-- <th scope="col" class="px-3 py-2 md:px-6  md:py-3">
                                                        ESTATUS
                                                    </th> --}}
                                                    <th scope="col" class="px-3 py-2 md:px-6  md:py-3">

                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @if ($longitudmuestras > 0)
                                                    @foreach ($muestras as $muestra)
                                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                            <th scope="row"
                                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                                {{ $muestra->user_name }}
                                                            </th>
                                                            <td class="px-6 py-4">
                                                                {{ $muestra->updated_at }}
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                {{ $muestra->address }}

                                                            </td>
                                                            <td class="px-6 py-4">
                                                                {{ $muestra->product_name }}

                                                            </td>
                                                            {{-- <td class="px-6 py-4">
                                                            {{ $muestra->status }}

                                                        </td> --}}
                                                            <td class="w-[13%]">
                                                                <a href="/carrito/muestra/{{ $muestra->id_muestra }}">
                                                                    <button
                                                                        class="bg-[#2B2D2F] text-white h-[50px] w-full px-2 ">VER
                                                                        PEDIDO </button>
                                                                </a>
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <td colspan="5" class=" text-center">
                                                        No tiene muestras por el momento
                                                    </td>
                                                @endif

                                            </tbody>
                                        </table>

                                    </div>

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

                                    .opacity-70 {
                                        opacity: 0.7;
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
                        </div>
                    </div>
                </div>
        </div>
        @endforeach

    </div>
@endsection
