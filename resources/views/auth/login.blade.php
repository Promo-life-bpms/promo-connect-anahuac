@extends('layouts.guest')

@section('content')
   <style>
        body {
            background-image: url('{{ asset('img/bg-login.png') }}') !important;
            background-size: cover; /* Otra propiedad opcional para ajustar el tamaño de la imagen */
        }
   </style>

    <div class="flex items-center justify-center h-screen">
        <div style="width:70%;">
            

            <div class="container flex justify-center items-center">
                <div ></div>
                <div class="flex bg-orange-500 bg-opacity-50" style="width:1000px;">
                    <div class="flex-1 w-1/2 ml-10" >
                       
                        
                            <div class="max-w-full p-10 rounded  shadow-2xl bg-white -mt-10 -mb-10" >
                                <div class="separator mt-8"></div>
                                <div class="flex items-center justify-center">
                                    <h1 class="text-2xl font-bold text-primary">
                                        INICIAR SESIÓN
                                    </h1>
                                </div>
                    
                                <form class="w-full p-4" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    
                                    <label class="block text-gray-500 font-bold text-left mb-1 md:mb-0 pr-4 pb-2" for="inline-full-name">
                                        Correo
                                    </label>
                                    
                                    <div class="w-full">
                                        <input type="email" class="appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:bg-white focus:border-orange-500" name="email" value="{{ old('email') }}" placeholder="Ingrese su correo" required autocomplete="email" autofocus>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <p class="text-sm text-red-700 font-semibold">{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="separador mt-4"></div>
                                    <label class="block pb-2 text-gray-500 font-bold text-left mb-1 md:mb-0 pr-4" for="inline-password">
                                        Contraseña
                                    </label>
                                   
                                    <div class="w-full mb-4">
                                        <input id="password" type="password" class="appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:bg-white focus:border-orange-500" placeholder="Ingrese su contraseña" name="password" required autocomplete="current-password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <p class="text-sm text-red-700 font-semibold">{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="text-right">
                                        <a href="#" class="hover:text-orange-700">¿Olvidaste la contraseña?</a>
                                    </div>
                                    <br>
                                    <div class="md:flex md:items-center mt-4">
                                        <div class="w-full mb-2">
                                            <button type="submit" class="text-white bg-primary hover:bg-primary-dark inline-block w-full rounded px-7 pb-2.5 pt-3 text-sm font-medium uppercase leading-normal shadow-[0_4px_9px_-4px_#000000] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                                                INICIAR SESIÓN
                                            </button>
                                            
                                        </div>
                                    </div>
                                </form>
                                <div class="mx-4 -mt-6">
                                    <button type="submit" class="text-primary border border-primary bg-white inline-block w-full rounded px-7 pb-2.5 pt-3 text-sm font-medium uppercase leading-normal transition duration-150 ease-in-out">
                                        CREAR CUENTA
                                    </button>
                                </div>
                               
                                <div class="separator mt-8"></div>
                            </div>
                            
    
                    </div>
                    <div class="flex-1 w-1/2">
                        <div class="flex items-center justify-center" >
                            <img src="{{ asset('img/anahuac-logo.png') }}" alt="logo" style="width: 260px; height: 260px;" class="mt-20">
                        </div>
                    </div>
                </div>

                

            </div>

        </div>
        
    </div>
   
@endsection
