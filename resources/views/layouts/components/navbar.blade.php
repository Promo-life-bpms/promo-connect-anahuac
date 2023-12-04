<div  class="fixed top-0 left-0 right-0 z-50">
    
    <nav class="w-full flex justify-between py-2 px-12 items-center flex-wrap md:flex-nowrap px-3 md:py-1 bg-white" >
        <div class="w-3/12">
            <a href="{{ route('index') }}">
                <img src="{{asset('img/logo-anahuac.png')}}"
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


        <div class="w-5/12">
            <div class="flex justify-center pr-10 ">

                @if (!request()->is('administrador/*', 'administrador'))

                    @role(['buyers-manager', 'buyer'])
                        <div class="w-full">
                            @livewire('searching-component')
                        </div>

                    @endrole
                @endif
                
            </div>
        </div>

       

        <div class="w-5/12">
            <div class="flex justify-around">
                <div>
                    @if (auth()->user())
                        <div class="text-black mt-6">
                            <div class="flex">
                                <button id="dropdownHoverButton" data-dropdown-toggle="dropdown"
                                    class="text-primary hover:text-primary focus:ring-4 focus:outline-none p-1 font-medium focus:rounded text-lg text-center inline-flex items-center"
                                    type="button">
                                    <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 21C5 17.134 8.13401 14 12 14C15.866 14 19 17.134 19 21M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="#FF5900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>

                                    <p class="ml-2 text-lg text-orange-500 font-semibold">{{ strtoupper(auth()->user()->name) }}</p>

                                </button>
                                
                            </div>
                            
                        </div>
                    @endif
                </div>
                <div>
                    <p class="mt-8 text-lg text-orange-500 font-semibold"><a href="{{ route('compras') }}">MIS COMPRAS</a></p>
                    
                </div>
                <div class="flex">
                    @role(['buyers-manager', 'buyer'])
                        <a class="text-primary hover:text-primary mt-6" href="{{ route('catalogo') }}">
                            <div class="mt-1">
                                <svg width="25px" height="25px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">

                                    <defs>
                                    
                                    <style>.cls-1{fill:none;stroke:#020202;stroke-miterlimit:10;stroke-width:1.91px;}</style>
                                    
                                    </defs>
                                    
                                    <g id="handbag">
                                    
                                    <path class="cls-1" d="M3.41,7.23H20.59a0,0,0,0,1,0,0v12a3.23,3.23,0,0,1-3.23,3.23H6.64a3.23,3.23,0,0,1-3.23-3.23v-12A0,0,0,0,1,3.41,7.23Z"/>
                                    
                                    <path class="cls-1" d="M8.18,10.09V5.32A3.82,3.82,0,0,1,12,1.5h0a3.82,3.82,0,0,1,3.82,3.82v4.77"/>
                                    
                                    </g>
                                    
                                    </svg>
                            </div>
                        </a>
                        <div class=" mt-3" style="width: 2rem">
                            @livewire('count-cart-quote')
                        </div>
                    @endrole
                    @role('seller')
                        <div class=" mt-8  ml-2" style="width: 2rem">
                            @livewire('count-messages-support')
                        </div>
                    @endrole
                </div>
            </div>
            
            
            <div class="flex items-start justify-end">

                <div class="flex justify-between sm:justify-end gap-5 font-semibold text-md items-center mt-3 sm:mt-0">

                   {{--  @role('seller')
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
                    @endrole --}}

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

                            @role('seller')
                            
                            <li>
                                <a href="{{ route('seller.content') }}"
                                class="w-full text-left text-base block px-4 py-2 text-white hover:text-[#0F0E24] hover:bg-white">Banners</a>
                            </li>
                            <li>
                                <a href="{{ route('seller.compradores') }}"
                                class="w-full text-left text-base block px-4 py-2 text-white hover:text-[#0F0E24] hover:bg-white">Compradores</a>
                            </li>
                            <li>
                                <a href="{{ route('seller.pedidos') }}"
                                class="w-full text-left text-base block px-4 py-2 text-white hover:text-[#0F0E24] hover:bg-white">Compras</a>
                            </li>
                            <li>
                                <a href="{{ route('seller.muestras') }}"
                                class="w-full text-left text-base block px-4 py-2 text-white hover:text-[#0F0E24] hover:bg-white">Muestras</a>
                            </li>
                            
                            @endrole

                            <li>
                                <button data-modal-target="popup-modal" data-modal-toggle="popup-modal"
                                    class="w-full text-left text-base block px-4 py-2 text-white hover:text-[#0F0E24] hover:bg-white">Cerrar
                                    Sesion</button>
                            </li>
                            

                        </ul>
                    </div>
                </div>

                
            
                

            </div>
            
        </div>
       
    </nav>

    <div class="w-full bg-[#FF5900] h-16 ">
        <div class="flex">
            <div class="w-2/3 mx-5">
                <div class="flex items-center justify-between ">
                    <a href="{{ route('catalogo')}}"><p class="text-white mt-5 font-bold">CATÁLOGO </p></a>
                    <a href="{{ route('catalogo')}}"><p class="text-white mt-5 font-bold">MEJORES DESCUENTOS</p></a>
                    <a href="{{ route('catalogo')}}"><p class="text-white mt-5 font-bold">RECIÉN LLEGADO</p></a>
                    <a href="{{ route('catalogo')}}"><p class="text-white mt-5 font-bold">MEJOR CALIFICADO</p></a>
                    <a href="{{ route('catalogo')}}"><p class="text-white mt-5 font-bold">MEJOR CALIFICADO</p></a>
                </div>
            </div>
            <div class="w-1/3">
                <p class="text-white font-bold text-right mt-5 mr-8">COMPRA <b class="text-black">$1,500</b> Y OBTÉN EL ENVÍO GRATIS</p>
            </div>
        </div>
    </div>
       

</div>
