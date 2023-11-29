@extends('layouts.cotizador')
@section('content')
    <div class="mx-auto">
        @livewire('proceso-muestra-component', ['idMuestra' => $id])
    </div>
@endsection()
