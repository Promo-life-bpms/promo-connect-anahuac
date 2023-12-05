@extends('layouts.cotizador')
@section('title', 'Cotizacion Actual')
@section('content')
    @if (count($cotizacionActual) > 0)
        @livewire('current-quote-component', ['cotizacion'])
    @else
        <div class="flex w-100 justify-center">
            <p class="text-center m-0 my-5">
                <strong>No tienes productos agregados a tu carrito </strong>
                <br>
                <b><a class="underline" href="{{ route('misCotizaciones') }}">Ver mis cotizaciones</a></b>
                
            </p>
            <br>
            
        </div>
    @endif
@endsection
