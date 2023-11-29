@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-9">
                @livewire('materials')
            </div>
            <div class="col-md-3">
                @livewire('techniques')
            </div>
        </div>
    </div>
@endsection
