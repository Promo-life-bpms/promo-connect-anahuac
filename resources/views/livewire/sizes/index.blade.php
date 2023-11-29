@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-9">
                @livewire('size-material-techniques')
            </div>
            <div class="col-md-3">
                @livewire('sizes')
            </div>
        </div>
    </div>
@endsection
