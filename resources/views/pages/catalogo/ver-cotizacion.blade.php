@extends('layouts.cotizador')

@section('content')
    <div class="mx-auto">
        @livewire('ver-cotizacion-component', ['quote' => $quote])
    </div>
@endsection
