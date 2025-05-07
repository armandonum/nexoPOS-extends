@extends('layout.dashboard')

@section('layout.dashboard.with-header')
    @include('common.dashboard.title')

    <div class="container my-5">
        <div class="card shadow border-0">
            <div class="card-header bg-info text-white text-center">
                <h4>Productos Seleccionados</h4>
            </div>
            <div class="card-body">
                @include('Ofertas::components.productos_seleccionados', ['productos' => $selectedProducts])
            </div>
        </div>
    </div>
@endsection
