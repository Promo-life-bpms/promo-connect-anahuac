<div class="bg-white container mx-auto h-auto max-w-7xl p-7 ">

    <div class="flex">
        <div class="flex-grow">
            <h1 class="md:text-3xl text-2xl font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-8 h-8 block mb-1" style="display: inline">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
                </svg>Banner Informativos
            </h1>
        </div>
        <div class="flex-grow-0 flex gap-2">

            <div class="">
                <button data-modal-target="modalAddBanner" data-modal-toggle="modalAddBanner"
                    class="bg-primary hover:bg-primary-dark text-white w-full rounded-md  px-4 py-2">
                    Agregar
                </button>
            </div>
            <div>
                <label for="default-search"
                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    </div>
                    <input type="search"
                        class="border-2 lg:block border-gray-400 py-2 text-sm bg-white rounded-md pr-10 pl-2 focus:outline-none focus:bg-white focus:text-gray-900 w-full"
                        placeholder="Buscar..." autocomplete="off" name="busqueda" wire:model="searchBanner">
                    <span class="absolute inset-y-0 right-0 flex items-center pr-2">
                        <button type="submit" class="p-1 focus:outline-none focus:shadow-outline">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="relative overflow-x-auto md:col-span-2  ">
        <div class="relative mb-4" wire:loading.class="opacity-70">
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
                            Imagen
                        </th>
                        <th scope="col" class="px-3 py-2 md:px-6  md:py-3">
                            Autor
                        </th>
                        <th scope="col" class="px-3 py-2 md:px-6  md:py-3">
                            Visible
                        </th>
                        <th scope="col" class="px-3 py-2 md:px-6  md:py-3">
                            Fecha De Creacion
                        </th>
                        <th scope="col" class="px-3 py-2 md:px-6  md:py-3">
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @if (count($banners) <= 0)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td colspan="5">
                                <p class="text-center">No hay registros</p>
                            </td>
                        </tr>
                    @endif

                    @foreach ($banners as $bannerItem)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">
                                {{ $bannerItem->url_banner }}
                            </td>
                            <td class="px-6 py-4">
                                {{-- Obtener el usuario que creo el banner --}}
                                {{ $bannerItem->user->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $bannerItem->visible }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $bannerItem->created_at->format('d/m/Y') }}
                            </td>
                            <td class="w-[13%]">
                                {{-- <a href="{{ route('procesoMuestra', ['id' => $muestra->id]) }}">
                                <button class="bg-[#2B2D2F] text-white h-[50px] w-full px-2 ">VER MUESTRA </button>
                            </a> --}}
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class=" flex sm:hidden justify-center">
            {{ $banners->onEachSide(0)->links() }}
        </div>
        <div class="hidden sm:flex justify-center">
            {{ $banners->onEachSide(3)->links() }}
        </div>
    </div>


    <!-- Main modal -->
    <div wire:ignore.self id="modalAddBanner" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Agregar Banner
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="modalAddBanner">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <div class="flex">
                        {{-- Campos para agregar un banner --}}
                        <div>
                            <div>
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">
                                        Seleccionar Imagen
                                    </span>
                                </label>
                            </div>

                            <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-finish="isUploading = false"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <input type="file"
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    wire:model="banner" accept="image/*">
                                <div x-show="isUploading" class="progress">
                                    <div class="flex justify-between mb-1">
                                        <span
                                            class="text-base font-medium text-slate-700 dark:text-white">Progreso</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                        <div class="bg-slate-600 h-2.5 rounded-full"
                                            x-bind:style="`width: ${progress}%`">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            @if ($banner)
                                <img src="{{ $banner->temporaryUrl() }}" alt=""
                                    style="max-width: 100%; height: auto; max-height: 150px; width: auto">
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="modalAddBanner" type="button" wire:click='addBanner'
                        class="text-white bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Guardar</button>
                    <button data-modal-hide="modalAddBanner" type="button"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancelar</button>
                </div>
            </div>
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

        .sk-chase-dot:nth-child(4):before {
            animation-delay: -0.8s;
        }

        .sk-chase-dot:nth-child(5):before {
            animation-delay: -0.7s;
        }

        .sk-chase-dot:nth-child(6):before {
            animation-delay: -0.6s;
        }

        .opacity-70 {
            opacity: 0.7;
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
