@extends('layouts.cotizador')
@section('title', $product->name)
@section('content')
    <div class="container mx-auto max-w-7xl">
        <div class="grid grid-cols-1 md:grid-cols-2 px-10 py-10 gap-y-10 gap-x-20">
            @if ($product->precio_unico)
                @php
                    $priceProduct = $product->price;

                    if ($product->producto_promocion) {
                        $priceProduct = round($priceProduct - $priceProduct * ($product->descuento / 100), 2);
                    } else {
                        $priceProduct = round($priceProduct - $priceProduct * ($product->provider->discount / 100), 2);
                    }
                    $priceProduct = round($priceProduct / ((100 - $utilidad) / 100), 2);
                    $priceProduct = round($priceProduct / ((100 - config('settings.utility_aditional')) / 100), 2);
                @endphp
            @endif

            <div class="flex justify-center flex-col items-center px-5">
                <div class="bg-white h-auto max-w-full shadow-xl shadow-gray-300 flex justify-self-center">
                    <img id="imgBox" class="py-4 rounded"
                        src="{{ $product->firstImage ? $product->firstImage->image_url : asset('img/default.jpg') }}">
                </div>
                <div class="grid grid-cols-3 space-x-1">
                    @foreach ($product->images as $image)
                        <div class="flex flex-row h-auto max-w-full py-2 shadow-xl">
                            <img class="object-scale-down" src="{{ $image->image_url }}" alt="{{ $image->image_url }}"
                                onclick="cambiarImagen(this)">
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 grid grid-cols-1 w-full flex-col justify-center px-5 md:grid-cols-2">
                    @if (!$product->precio_unico)
                        <h5><strong>Precios</strong></h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Escala</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product->precios as $precio)
                                    @php
                                        $priceProduct = $product->price;
                                        if ($product->producto_promocion) {
                                            $priceProduct = round($priceProduct - $priceProduct * ($product->descuento / 100), 2);
                                        } else {
                                            $priceProduct = round($priceProduct - $priceProduct * ($product->provider->discount / 100), 2);
                                        }
                                    @endphp
                                    <tr>
                                        <td class="p-0">{{ $precio->escala }}</td>
                                        <td class="p-0">$ {{ $priceProduct }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    <div class="col-start-1 col-end-2">
                        @foreach ($product->productAttributes as $attr)
                            <p class="my-1">
                                <strong>{{ $attr->attribute }}:</strong> {{ $attr->value }}
                            </p>
                        @endforeach
                    </div>
                    <p><strong>Ultima Actualizacion: </strong>
                        {{ $product->updated_at->diffForHumans() }}
                    </p>
                </div>
            </div>
            <div
                class="bg-stone-50 product mt-2 px-5 py-7 h-auto max-w-full grid grid-cols-5 md:grid-cols-5 h-fit w-screen">

                <!-- <div class="col-span-1">
                        <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-5 h-5" style="display: inline">
                            <path fill-rule="evenodd"
                                d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z"
                                clip-rule="evenodd" />
                        </svg>
                    </div> -->
                <p class="text-3xl col-start-2 col-span-4 md:text-4xl hyphens-auto">
                    <strong>{{ $product->name }}</strong>
                </p>
                <div class="col-start-1 col-span-5 mt-4 space-y-2 px-6">
                    <p class="font-normal"> <strong>Precio Unitario: </strong>$
                        {{ $priceProduct }}</p>
                    <p class="font-normal"><strong>Descripcion:</strong></p>
                    <p class="font-normal">{{ $product->description }}</p>

                    <p class="font-normal"><strong>Stock:</strong> {{ $product->stock }} </p>

                    @if (count($product->productCategories) > 0)
                        <strong>Categorias</strong>
                        {{ $product->productCategories[0]->category->family }}
                    @endif
                    <p class="flex flex-grow text-lg grid-cols-1"><strong>Informacion de la cotizacion</strong></p>
                    @livewire('formulario-de-cotizacion', ['product' => $product])
                </div>
            </div>
        </div>
    </div>

    <style>
        .product-small-img img {
            width: 4%;
            border: 1px solid rgba(0, 0, 0, .2);
            /* padding: 8px; */
            /* margin: 10px 10px 15px; */
            cursor: pointer;
        }

        .product-small-img {
            display: flex;
            /* justify-content: center; */
            flex-direction: column;
            gap: 5px;
        }

        .img-container {
            border: 1px solid rgba(0, 0, 0, .2);
        }

        .img-container img {
            height: 20rem;
        }

        .img-container {
            padding: 10px;
            max-height: 400px;
        }
    </style>
    <script>
        function cambiarImagen(smallImg) {
            let fullImg = document.querySelector('#imgBox')
            console.log(fullImg);
            fullImg.src = smallImg.src
        }
    </script>
@endsection
