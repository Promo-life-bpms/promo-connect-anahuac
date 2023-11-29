@extends('layouts.cotizador')

@section('content')
    <!-- <div class="container mx-auto max-w-7xl">
        <div class="w-full bg-[#0047BB]">
            <div class="flex justify-center">
                <span class="text-center text-white">
                </span>
            </div>
        </div>
    </div> -->
    <div id="default-carousel" class="relative w-full text-center" data-carousel="slide" >
        <!-- Carousel wrapper -->
        <div class="relative h-80 overflow-hidden  md:h-[32rem] mx-auto max-w-7xl">
            @foreach ($banners as $item)
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="{{ asset('storage/banners/' . $item->url_banner) }}"
                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                </div>
            @endforeach
        </div>
        <!-- Slider indicators -->
        <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
            @for ($i = 0; $i < count($banners); $i++)
                <button type="button" class="w-3 h-3 rounded-full" aria-current="{{ $i == 0 ? 'true' : 'false' }}"
                    aria-label="Slide {{ $i + 1 }}" data-carousel-slide-to="{{ $i }}"></button>
            @endfor
        </div>
        <!-- Slider controls -->
        <button type="button"
            class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-prev>
            <span
                class="shadow-lg inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-slate-300/50 group-hover:bg-slate-300/70  group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                <svg aria-hidden="true" class=" w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button"
            class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-next>
            <span
                class="bg-slate-300/50 group-hover:bg-slate-300/70 shadow-lg inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg aria-hidden="true" class=" w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>
    <div class="container mx-auto max-w-7xl">
        <div class="w-full bg-primary">
            <div class="container mx-auto max-w-7xl py-1">
                <div class="flex justify-center">
                    <span class="text-center text-white">LOS MÁS VENDIDOS
                    </span>
                </div>
            </div>
        </div>
        <div class="container mx-auto max-w-7xl py-8 bg-white">
                <div class="flex flex-wrap justify-between">
                    @foreach ($latestProducts as $product)
                        <a href="{{ route('show.product', ['product' => $product->id]) }}" class="max-h-40 w-auto text-center">
                            <img src="{{ isset( $product->firstImage->image_url)? $product->firstImage->image_url: asset('/img/default.jpg') }}" alt="" srcset=""
                                class="max-h-40 w-auto ">
                        </a>
                    @endforeach
                 </div>
        </div>
        <div class="w-full bg-white">
            <div class="container mx-auto max-w-7xl py-1">
                <div class="flex justify-center bg-primary ">
                    <span class="text-center text-white p-1">CATEGORIAS
                    </span>
                </div>
            </div>
        </div>
        <div class="container mx-auto max-w-7xl py-8">
            <div class="flex flex-wrap justify-between">

                @foreach ($latestCategorias as $cat)
                    <div>
                        <div
                            class="border border-primary  bg-slate-50 hover:bg-slate-100 transition-colors rounded-full shadow-lg w-40 h-40 flex justify-center items-center text-center cursor-pointer">
                            <a href="{{ route('categoryfilter', ['category' => $cat->id]) }}"
                                class="bg-[#161B2F] font-bold text-white uppercase text-sm px-3 py-2 w-4/5">
                                {{ $cat->family }}
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
        <div class="w-full bg-primary">
            <div class="container mx-auto max-w-7xl py-1">
                <div class="flex justify-center">
                    <span class="text-center text-white">MAS PRODUCTOS
                    </span>
                </div>
            </div>
        </div>
        <div class="container mx-auto max-w-7xl pqy-8">
            <div class="flex flex-wrap justify-between">
                @foreach ($moreProducts as $product)
                    @if ($product->firstImage)
                        <a href="{{ route('show.product', ['product' => $product->id]) }}"
                            class="max-h-40 w-auto text-center">
                            <img src="{{ $product->firstImage->image_url }}" alt="" srcset=""
                                class="h-40 w-40 ">
                        </a>
                    @else
                        <img src="{{ asset('/img/default.jpg') }}" alt="" srcset="" class="max-h-40 w-auto">
                    @endif
                @endforeach
            </div>
        </div>
        <div class="container mx-auto max-w-7xl">
            <div class="relative overflow-hidden h-40 text-center">
                <img class="h-auto w-full" src="{{ asset('img/_d9b3498b-78d2-4d9e-98a7-993655d16f7c.jfif') }}"
                    alt="">
                <p class="absolute top-10 uppercase text-white text-5xl inset-x-8">Premium Brands</p>
            </div>
        </div>
    </div>
@endsection
