{{-- @section('title', __('Companys'))
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <h4><i class="fab fa-laravel text-info"></i>
                                Company Listing </h4>
                        </div>
                        <div wire:poll.60s>
                            <code>
                                <h5>{{ now()->format('H:i:s') }} UTC</h5>
                            </code>
                        </div>
                        @if (session()->has('message'))
                            <div wire:poll.4s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;">
                                {{ session('message') }} </div>
                        @endif
                        <div>
                            <input wire:model='keyWord' type="text" class="form-control" name="search"
                                id="search" placeholder="Search Companys">
                        </div>
                        <div class="btn btn-sm btn-info" data-toggle="modal" data-target="#createDataModal">
                            <i class="fa fa-plus"></i> Add Companys
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @include('livewire.companies.create')
                    @include('livewire.companies.update')
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead">
                                <tr>
                                    <td>#</td>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Manager</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <td>ACTIONS</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($companies as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->image }}</td>
                                        <td>{{ $row->manager }}</td>
                                        <td>{{ $row->email }}</td>
                                        <td>{{ $row->phone }}</td>
                                        <td width="90">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a data-toggle="modal" data-target="#updateModal"
                                                        class="dropdown-item" wire:click="edit({{ $row->id }})"><i
                                                            class="fa fa-edit"></i> Edit </a>
                                                    <a class="dropdown-item"
                                                        onclick="confirm('Confirm Delete Company id {{ $row->id }}? \nDeleted Companys cannot be recovered!')||event.stopImmediatePropagation()"
                                                        wire:click="destroy({{ $row->id }})"><i
                                                            class="fa fa-trash"></i> Delete </a>
                                                </div>
                                            </div>
                                        </td>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $companies->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}


<div>
    <style>
        .table td {
            vertical-align: middle;
        }

        .tr-link {
            cursor: pointer;
        }
    </style>
    <div class="row px-3">
        <div class="card w-100">
            <div class="card-body">
                {{-- <div>
                    <input wire:model='keyWord' type="text" class="form-control" name="search" id="search"
                        placeholder="Buscar">
                </div> --}}

                <div class="bg-white container mx-auto h-auto max-w-7xl grid md:grid-cols-2 p-3 gap-y-1">
                    <h1 class="text-2xl lg:text-4xl md:col-span-2 font-[600] md:font-[700] md:px-4 lg:px-32">MUESTRAS
                    </h1>
                    <div class="md:col-end-3 col-span-1 lg:px-12 lg:ml-40">
                        <label for="default-search"
                            class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            </div>
                            <input type="search"
                                class="border-2 lg:block border-gray-400 py-2 text-sm bg-white rounded-md pr-10 pl-2 focus:outline-none focus:bg-white focus:text-gray-900 w-full"
                                placeholder="Buscar..." autocomplete="off" name="busqueda" wire:model="search">
                            <span class="absolute inset-y-0 right-0 flex items-center pr-2">
                                <button type="submit" class="p-1 focus:outline-none focus:shadow-outline">
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6">
                                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </button>
                            </span>
                        </div>
                    </div>

                    <div class="relative overflow-x-auto md:col-span-2  lg:mx-32 lg:mt-2 ">
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
                                                    <button class="bg-primary text-white h-[50px] w-full px-2 ">VER
                                                        MUESTRA
                                                    </button>
                                                </a>
                                            </td>

                                        </tr>
                                    @endforeach
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
            </div>
        </div>
    </div>
</div>
