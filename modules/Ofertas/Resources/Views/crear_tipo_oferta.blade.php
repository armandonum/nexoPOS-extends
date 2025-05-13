@extends('layout.dashboard')

@section('layout.dashboard.with-header')
    @include('common.dashboard.title')
    <form id="form-nuevo-tipo" action="{{ route('tipo_ofertas.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" name="nombre" class="w-full border px-3 py-2 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Descripción</label>
            <textarea name="descripcion" class="w-full border px-3 py-2 rounded" required></textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition duration-200">Guardar</button>
        </div>
    </form>
@endsection