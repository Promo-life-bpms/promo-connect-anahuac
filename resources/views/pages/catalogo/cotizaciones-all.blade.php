@extends('layouts.app')

@section('title', 'Mis Cotizaciones')
@section('content')
    <div class="container-fluid">
        @livewire('all-quotes-component')
    </div>
@endsection
