@extends('layouts.cotizador')
@section('content')
    @livewire('catalogo-personal')
@endsection()

@section('styles')
    <link href="{{ asset('assets/css/components/cards/card.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/elements/custom-pagination.css') }}" rel="stylesheet" type="text/css" />
@endsection
