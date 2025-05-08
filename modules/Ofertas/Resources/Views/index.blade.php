@extends('layout.dashboard')

@section('layout.dashboard.with-header')
    @include('common.dashboard.title')

    <div class="container d-flex justify-content-center align-items-center" style="height: 75vh;">
        <div class="card text-center shadow-lg border-0 p-5" style="max-width: 600px;">
            <div class="mb-4">
                <i class="bi bi-stars text-primary" style="font-size: 5rem;"></i>
            </div>
            <h2 class="mb-3 text-dark">¡Bienvenido al Módulo de Ofertas!</h2>
            <p class="text-muted fs-5">Aquí puedes gestionar promociones y descuentos especiales para tus productos.</p>
            <a href="{{ route('ofertas.crear') }}" class="btn btn-lg btn-outline-success mt-4">
                <i class="bi bi-plus-circle me-2"></i> Crear Oferta
            </a>
        </div>
    </div>
@endsection
