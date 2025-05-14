@extends('layout.dashboard')

@section('layout.dashboard.with-header')
    @include('common.dashboard.title')

    <div class="container mx-auto py-10 grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Tarjeta: Crear Oferta --}}
        <div class="bg-gradient-to-r from-green-400 to-emerald-600 text-white rounded-2xl shadow-2xl p-8 flex flex-col items-center justify-center transition-transform hover:scale-105 duration-300">
            <div class="mb-4">
                <i class="bi bi-stars" style="font-size: 4rem;"></i>
            </div>
            <h2 class="text-2xl font-bold mb-2 text-white">¡Crea una Nueva Oferta!</h2>
            <p class="text-white text-md text-center mb-4">Diseña promociones irresistibles y atrae más clientes con ofertas exclusivas.</p>
            <a href="{{ route('ofertas.crear') }}" class="bg-white text-green-600 hover:bg-gray-100 px-6 py-3 rounded-md font-semibold shadow">
                <i class="bi bi-plus-circle me-2"></i> Crear Oferta
            </a>
        </div>

        {{-- Tarjeta: Gestionar Ofertas --}}
        <div class="bg-gradient-to-r from-green-400 to-emerald-600 text-white rounded-2xl shadow-2xl p-8 flex flex-col items-center justify-center transition-transform hover:scale-105 duration-300">
                <div class="mb-4">
                <i class="bi bi-clipboard-data" style="font-size: 4rem;"></i>
            </div>
            <h2 class="text-2xl font-bold mb-2 text-white">Gestionar Ofertas</h2>
            <p class="text-white text-md text-center mb-4">Consulta, edita y controla el estado de tus promociones activas e inactivas.</p>
            <a href="{{ route('ofertas.index') }}" class="bg-white text-green-600 hover:bg-gray-100 px-6 py-3 rounded-md font-semibold shadow">
                <i class="bi bi-plus-circle me-2"></i> Ver Lista de Ofertas
            </a>
        </div>
    </div>
@endsection
