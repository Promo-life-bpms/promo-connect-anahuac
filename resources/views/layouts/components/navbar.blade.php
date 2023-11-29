<div  class="fixed top-0 left-0 right-0 z-50">
    <nav class="w-full flex justify-between py-2 px-12 items-center flex-wrap md:flex-nowrap px-3 md:py-1 bg-primary" >
        <div class="w-2/12">
            <a href="{{ route('index') }}">
                <img src="{{asset('img/logo-white.png')}}"
                    style="object-fit: cover;"
                    alt="logo" class="w-24 p-2 ml-12">
            </a>
        </div>
       
        <div id="popup-modal" tabindex="-1"
            class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                        data-modal-hide="popup-modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>

                        </svg>
                        <span class="sr-only">Cerrar</span>
                    </button>
                    <div class="p-6 text-center">
                        <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">¿Esta seguro de que desea
                            salir del sitio?</h3>
                        <a class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2"
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            Si, estoy seguro</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                        <button data-modal-hide="popup-modal" type="button"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No,
                            cancelar</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="w-8/12">
            <div class="flex justify-end pr-10 ">

                <div>
                    @if (!request()->is('administrador/*', 'administrador'))
                        @role(['buyers-manager', 'buyer'])
                            <div class="w-3/12 sm:w-5/12">
                                @livewire('searching-component')
                            </div>
                        @endrole
                    @endif
                </div>

            <div>
            <div class="flex items-start justify-end">

                <div class="flex justify-between sm:justify-end gap-5 font-semibold text-md items-center mt-3 sm:mt-0">

                    @role('seller')
                        <ul class="flex ">
                            <li>
                                <a href="{{ route('seller.content') }}"
                                    class="block px-4 py-2 text-white hover:text-primary-superlight text-lg">Banners</a>
                            </li>
                            <li>
                                <a href="{{ route('seller.compradores') }}"
                                    class="block px-4 py-2 text-lg text-white hover:text-primary-superlight">Compradores</a>
                            </li>
                            <li>
                                <a href="{{ route('seller.pedidos') }}"
                                    class="block px-4 py-2 text-white hover:text-primary-superlight text-lg">Compras</a>
                            </li>
                            <li>
                                <a href="{{ route('seller.muestras') }}"
                                    class="block px-4 py-2 text-white hover:text-primary-superlight text-lg">Muestras</a>
                            </li>
                           

                        </ul>
                    @endrole

                    <div class="relative inline-flex w-fit">

                        <a class="relative inline-flex items-center text-gray-500">
                            <div style="width: 2rem">

                                {{--   <button id="notificacionStatus" data-dropdown-toggle="dropdownStatus" class="text-gray-500"
                                    type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" />
                                    </svg>
                                </button> --}}
                                <!--
                                @if (auth()->user()->unreadNotifications->count() > 0)
                                    <div
                                        class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -right-2 dark:border-gray-900">
                                        {{ auth()->user()->unreadNotifications->count() }}
                                    </div>
                                @endif -->

                            </div>
                        </a>

                        <!-- Notificaciones -->
                        <div id="dropdownStatus"
                            class="z-40 hidden bg-white divide-y divide-gray-100 rounded-lg shadow  w-60 lg:w-80 dark:bg-gray-700 dark:divide-gray-600 ">
                            <div class=" max-h-56 overflow-y-auto">

                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="notificacionStatus">
                                    @foreach (auth()->user()->unreadNotifications as $notificaciones)
                                        <li>
                                            <div class="flex p-2 hover:bg-gray-100">
                                                @switch($notificaciones->type)
                                                    @case('App\Notifications\RequestedSampleNotification')
                                                        <a href="{{ route('procesoMuestra', ['id' => $notificaciones->data['sample_id']]) }}"
                                                            class="block px-2 py-2">
                                                            <p>
                                                                <strong>{{ $notificaciones->data['user'] }}</strong> ha
                                                                solicitado una muestra
                                                                del producto <strong>{{ $notificaciones->data['producto'] }}
                                                                </strong>
                                                            </p>
                                                        </a>
                                                    @break

                                                    @case('App\Notifications\StatusPedidoNotification')
                                                        <a href="{{ route('verCotizacion', ['quote' => $notificaciones->data['pedido_id']]) }}"
                                                            class="block px-2 py-2">
                                                            El pedido <strong>{{ $notificaciones->data['pedido'] }}
                                                            </strong>
                                                            a
                                                            cambiado
                                                            de estado a
                                                            <strong>
                                                                @if ($notificaciones->data['status'] == 1)
                                                                    se esta prepartando
                                                                @elseif ($notificaciones->data['status'] == 2)
                                                                    va en camino
                                                                @elseif ($notificaciones->data['status'] == 3)
                                                                    entregado
                                                                @else
                                                                @endif
                                                            </strong>
                                                        </a>
                                                    @break

                                                    @case('App\Notifications\MuestraStatusNotification')
                                                        <a href="{{ route('procesoMuestra', ['id' => $notificaciones->data['id']]) }}"
                                                            class="block px-2 py-2">
                                                            Tu muestra <strong>{{ $notificaciones->data['product_name'] }}
                                                            </strong>
                                                            a
                                                            cambiado
                                                            de estado a
                                                            <strong>
                                                                @if ($notificaciones->data['status'] == 1)
                                                                    se esta prepartando
                                                                @elseif ($notificaciones->data['status'] == 2)
                                                                    va en camino
                                                                @elseif ($notificaciones->data['status'] == 3)
                                                                    entregado
                                                                @else
                                                                @endif
                                                            </strong>

                                                            <!-- Contenido de la tabla -->

                                                        </a>
                                                    @break

                                                    {{-- PurchaseMadeNotification --}}
                                                    @case('App\Notifications\PurchaseMadeNotification')
                                                        {{-- <a href="{{ route('verCotizacion', ['quote' => $notificaciones->data['pedido_id']]) }}"
                                                                class="block px-2 py-2"> --}}
                                                        <p>
                                                            El usuario <strong>{{ $notificaciones->data['name'] }}
                                                            </strong>
                                                            a
                                                            realizado una compra
                                                        </p>
                                                        {{-- </a> --}}
                                                    @break

                                                    @default
                                                @endswitch
                                                <div class="flex items-center flex-shrink">
                                                    <a
                                                        href="{{ route('cerrar_notificacion', ['notificacion_id' => $notificaciones->id]) }}">
                                                        <div
                                                            class="inline-flex items-center justify-center w-7 h-7 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full ">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                                class="w-4 h-4">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                            </svg>

                                                        </div>
                                                    </a>
                                                </div>

                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <ul>
                                <li class="text-center">
                                    @if (auth()->user()->unreadNotifications->count() > 0)
                                        <a href="{{ route('eliminar_notificaciones') }}" class="text-red-500"> Eliminar
                                            Notificaciones
                                        </a>
                                    @else
                                        <strong>No Tienes Notificaciones</strong>
                                    @endif
                                </li>
                            </ul>

                        </div>

                    </div>

                    <!-- Dropdown menu -->
                    <div id="dropdown"
                        class="z-40 hidden bg-primary divide-y divide-gray-100 rounded-lg shadow w-44 text-white hover:text-white">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">
                            @role('buyers-manager')
                                <li>
                                    <a href="{{ route('administrador') }}"
                                        class="w-full text-left text-base block px-4 py-2 text-white hover:text-[#0F0E24] hover:bg-white">Administrador</a>
                                </li>
                            @endrole
                            @role('seller')
                                {{-- <li>
                                    <a href="{{ route('seller.content') }}"
                                        class="w-full text-left text-base block px-4 py-2 text-white hover:text-[#0F0E24] hover:bg-white">Contenido</a>
                                </li> --}}
                            @endrole
                            @role('admin')
                                <li>
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="w-full text-left text-base block px-4 py-2 text-white hover:text-[#0F0E24] hover:bg-white">Administrador</a>
                                </li>
                            @endrole
                            @role(['buyers-manager', 'buyer'])
                                <li>
                                    <a href="{{ route('compras') }}"
                                        class="w-full text-left text-base block px-4 py-2 text-white hover:text-[#0F0E24] hover:bg-white">Mis
                                        Compras</a>
                                </li>
                                <li>
                                    <a href="{{ route('muestras') }}"
                                        class="w-full text-left text-base block px-4 py-2 text-white hover:text-[#0F0E24] hover:bg-white">Mis
                                        Muestras</a>
                                </li>
                            @endrole

                            <li>
                                <button data-modal-target="popup-modal" data-modal-toggle="popup-modal"
                                    class="w-full text-left text-base block px-4 py-2 text-white hover:text-white hover:bg-primary-dark">Cerrar
                                    Sesion</button>
                            </li>

                        </ul>
                    </div>
                </div>

                <button id="dropdownHoverButton" data-dropdown-toggle="dropdown"
                    class="text-primary hover:text-primary focus:ring-4 focus:outline-none p-1 font-medium focus:rounded text-lg text-center inline-flex items-center"
                    type="button">
                    <svg width="25px" height="25px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="6" r="4"  stroke-width="2"fill="white" />
                        <ellipse cx="12" cy="17" rx="7" ry="4" stroke-width="2" fill="white"/>
                    </svg>

                </button>
                
                @role(['buyers-manager', 'buyer'])
                    <a class="text-primary hover:text-primary" href="{{ route('catalogo') }}">
                        <div class="mt-1">
                            <svg width="25px" height="25px" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.25013 6.01489C8.25003 6.00994 8.24998 6.00498 8.24998 6V5C8.24998 2.92893 9.92892 1.25 12 1.25C14.0711 1.25 15.75 2.92893 15.75 5 V6C15.75 6.00498 15.7499 6.00994 15.7498 6.01489C17.0371 6.05353 17.8248 6.1924 18.4261 6.69147C19.2593 7.38295 19.4787 8.55339 19.9177 10.8943L20.6677 14.8943C21.2849 18.186 21.5934 19.8318 20.6937 20.9159C19.794 22 18.1195 22 14.7704 22H9.22954C5.88048 22 4.20595 22 3.30624 20.9159C2.40652 19.8318 2.71512 18.186 3.33231 14.8943L4.08231 10.8943C4.52122 8.55339 4.74068 7.38295 5.57386 6.69147C6.17521 6.1924 6.96287 6.05353 8.25013 6.01489ZM9.74998 5C9.74998 3.75736 10.7573 2.75 12 2.75C13.2426 2.75 14.25 3.75736 14.25 5 V6C14.25 5.99999 14.25 6.00001 14.25 6C14.1747 5.99998 14.0982 6 14.0204 6H9.97954C9.90176 6 9.82525 6 9.74998 6.00002C9.74998 6.00002 9.74998 6.00003 9.74998 6.00002V5" fill="white"/>
                            </svg>
                        </div>
                    </a>
                    <div class=" mt-3" style="width: 2rem">
                        @livewire('count-cart-quote')
                    </div>
                @endrole
                @role('seller')
                    <div class=" mt-2 ml-2" style="width: 2rem">
                        @livewire('count-messages-support')
                    </div>
                @endrole

                </div>
            </div>


            </div>
        </div>
       
    </nav>
   
       

</div>
