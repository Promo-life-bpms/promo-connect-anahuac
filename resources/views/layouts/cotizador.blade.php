<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title') |
        @endif {{ config('app.name', 'Laravel') }}
    </title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    {{-- <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css"> --}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet"> --}}
    @livewireStyles
</head>

<body class="h-screen" style="margin-top:70px;">
    <div class="h-full flex flex-col justify-between">  
        <div class="w-full bg-white">
            @include('layouts.components.navbar')
        </div>
        <div class="flex-grow w-full" style="margin-top:102px;">
            @yield('content')
        </div>
        <div class="py-5 w-full bg-white">
            
            <div class="w-full flex justify-between items-center text-primary mt-4 ">
                <div>
                    <p class="ml-4 mr-4 text-xl font-bold">CONTACTO: </p>
                    <p class="ml-4 mr-4 text-lg">Telefono: 55 62 69 00 17</p>
                    <p class="ml-4 mr-4 text-lg">Correo: ventas@promolife.com.mx</p>

                    <p class="ml-4 mr-4 text-xl font-bold mt-4">Redes Sociales:</p>
                    <div class="flex ml-4 ">
                        <a href="">
                            <svg fill="#FF5900" width="50px" height="50px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2.03998C6.5 2.03998 2 6.52998 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.84998C10.44 7.33998 11.93 5.95998 14.22 5.95998C15.31 5.95998 16.45 6.14998 16.45 6.14998V8.61998H15.19C13.95 8.61998 13.56 9.38998 13.56 10.18V12.06H16.34L15.89 14.96H13.56V21.96C15.9164 21.5878 18.0622 20.3855 19.6099 18.57C21.1576 16.7546 22.0054 14.4456 22 12.06C22 6.52998 17.5 2.03998 12 2.03998Z"/>
                            </svg>
                        </a>
                        
                        <a href="" class="ml-2">
                            <svg width="50px" height="50px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                <g fill="none" fill-rule="evenodd">
                                    <path d="m0 0h32v32h-32z"/>
                                    <path d="m17.0830929.03277248c8.1190907 0 14.7619831 6.64289236 14.7619831 14.76198302v2.3064326c0 8.1190906-6.6429288 14.761983-14.7619831 14.761983h-2.3064325c-8.11909069 0-14.76198306-6.6428924-14.76198306-14.761983v-2.3064326c0-8.11909066 6.64289237-14.76198302 14.76198306-14.76198302zm-.8630324 8.0002641-.2053832-.0002641c-1.7102378 0-3.4204757.05652851-3.4204757.05652851-2.4979736 0-4.52299562 2.02501761-4.52299562 4.52298561 0 0-.05191606 1.4685349-.05624239 3.0447858l-.00028625.2060969c0 1.7648596.05652864 3.590089.05652864 3.5900891 0 2.497968 2.02502202 4.5229856 4.52299562 4.5229856 0 0 1.5990132.0565285 3.2508899.0565285 1.7648634 0 3.6466255-.0565285 3.6466255-.0565285 2.4979736 0 4.4664317-1.9684539 4.4664317-4.4664219 0 0 .0565286-1.8046833.0565286-3.5335605l-.0010281-.4057303c-.0076601-1.5511586-.0555357-3.0148084-.0555357-3.0148084 0-2.4979681-1.9684582-4.46642191-4.4664317-4.46642191 0 0-1.6282521-.05209668-3.2716213-.05626441zm-.2053831 1.43969747c1.4024317 0 3.2005639.04637875 3.2005638.04637875 2.0483524 0 3.3130573 1.2647021 3.3130573 3.31305 0 0 .0463789 1.7674322.0463789 3.1541781 0 1.4176885-.0463789 3.2469355-.0463789 3.2469355 0 2.048348-1.2647049 3.31305-3.3130573 3.31305 0 0-1.5901757.0389711-2.9699093.0454662l-.3697206.0009126c-1.3545375 0-3.0049692-.0463788-3.0049692-.0463788-2.0483172 0-3.36958592-1.321301-3.36958592-3.3695785 0 0-.04637885-1.8359078-.04637885-3.2830941 0-1.3545344.04637885-3.061491.04637885-3.061491 0-2.0483479 1.32130402-3.31305 3.36958592-3.31305 0 0 1.7416035-.04637875 3.1440353-.04637875zm-.0000353 2.46195055c-2.2632951 0-4.0980441 1.8347448-4.0980441 4.098035s1.8347489 4.098035 4.0980441 4.098035 4.0980441-1.8347448 4.0980441-4.098035c0-2.2632901-1.8347489-4.098035-4.0980441-4.098035zm0 1.4313625c1.4727754 0 2.6666784 1.1939004 2.6666784 2.6666725s-1.193903 2.6666726-2.6666784 2.6666726c-1.4727401 0-2.6666784-1.1939005-2.6666784-2.6666726s1.1939031-2.6666725 2.6666784-2.6666725zm4.2941322-2.5685935c-.5468547 0-.9902027.4455321-.9902027.9950991 0 .5495671.443348.9950639.9902027.9950639.5468546 0 .9901674-.4454968.9901674-.9950639 0-.5496023-.4433128-.9950991-.9901674-.9950991z" fill="#FF5900" fill-rule="nonzero"/>
                                </g>
                            </svg>
                        </a>
                       
                        <a href="" class="ml-3">
                            <svg fill="#FF5900" height="50px" width="50px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                            viewBox="-143 145 512 512" xml:space="preserve">
                                <path d="M113,145c-141.4,0-256,114.6-256,256s114.6,256,256,256s256-114.6,256-256S254.4,145,113,145z M215.2,361.2
                                    c0.1,2.2,0.1,4.5,0.1,6.8c0,69.5-52.9,149.7-149.7,149.7c-29.7,0-57.4-8.7-80.6-23.6c4.1,0.5,8.3,0.7,12.6,0.7
                                    c24.6,0,47.3-8.4,65.3-22.5c-23-0.4-42.5-15.6-49.1-36.5c3.2,0.6,6.5,0.9,9.9,0.9c4.8,0,9.5-0.6,13.9-1.9
                                    C13.5,430-4.6,408.7-4.6,383.2v-0.6c7.1,3.9,15.2,6.3,23.8,6.6c-14.1-9.4-23.4-25.6-23.4-43.8c0-9.6,2.6-18.7,7.1-26.5
                                    c26,31.9,64.7,52.8,108.4,55c-0.9-3.8-1.4-7.8-1.4-12c0-29,23.6-52.6,52.6-52.6c15.1,0,28.8,6.4,38.4,16.6
                                    c12-2.4,23.2-6.7,33.4-12.8c-3.9,12.3-12.3,22.6-23.1,29.1c10.6-1.3,20.8-4.1,30.2-8.3C234.4,344.5,225.5,353.7,215.2,361.2z"/>
                            </svg>
                        </a>

                        <div class="mb-10"></div>
                        
                    </div>

                    <div class="absolute flex h-1 bg-primary ml-4 mr-4 mt-4 overflow-hidden" style="width: 98%;"></div>
                    <p class="ml-4 mr-4 mt-6 text-black">Términos y condiciones</p>

                </div>
                <div class="flex flex-col items-end">
                    <a href="#" class="ml-4 mr-8" onclick="scrollToFirstSection()">
                        <svg width="50px" height="50px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" id="up-circle">
                            <path d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm3.71,11.71a1,1,0,0,1-1.42,0L12,11.41l-2.29,2.3a1,1,0,0,1-1.42-1.42l3-3a1,1,0,0,1,1.42,0l3,3A1,1,0,0,1,15.71,13.71Z" style="fill:#FF5900"></path>
                        </svg>
                    </a>
                    
                    <script>
                        function scrollToFirstSection() {
                            var firstSection = document.querySelector('body > *');
                    
                            if (firstSection) {
                                firstSection.scrollIntoView({ behavior: 'smooth' });
                            }
                        }
                    </script>
                    <img src="{{asset('img/anahuac.png') }}" alt="logo" style="height:60px;" class="ml-4 mr-8">
                    <p class="ml-4 mr-8 mt-2">Politicas de privacidad / Garantía PromoLife</p>
                    <p class="text-black ml-4 mr-8 mt-8 ">© Copyright 2023 Promo Life ®</p>
                    <div class="flex ml-4 mr-4 mt-4">
                        <p  class="text-black mr-2">Formas de pago</p> 
                        <img src="{{asset('img/pago1.png') }}" alt="tarjeta1" style="width: 30px; height:20px;" class="mt-2 ml-1">
                        <img src="{{asset('img/pago2.png') }}" alt="tarjeta2" style="width: 30px; height:20px;" class="mt-2 ml-1">
                        <img src="{{asset('img/pago3.png') }}" alt="tarjeta3" style="width: 30px; height:20px;" class="mt-2 ml-1">
                        <img src="{{asset('img/pago4.png') }}" alt="tarjeta4" style="width: 30px; height:20px;" class="mt-2 ml-1">
                    </div>
                </div>
            </div>
            
        </div>
        @role(['buyers-manager', 'buyer'])
            @livewire('soporte-component')
        @endrole
    </div>
    @livewireScripts
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
</body>

</html>
