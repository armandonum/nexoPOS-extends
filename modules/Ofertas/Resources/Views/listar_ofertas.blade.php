@extends('layout.dashboard')

@section('layout.dashboard.with-header')
    @include('common.dashboard.title')

    <div class="container mx-auto px-4 py-10">
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden transition-all duration-300">
            <!-- <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white px-8 py-6 flex justify-between items-center">
                <h3 class="text-2xl font-bold tracking-tight">Listado de Ofertas</h3>
                <a href="{{ route('ofertas.crear') }}"
                   class="bg-white text-blue-700 hover:bg-blue-100 px-5 py-2.5 rounded-xl font-semibold flex items-center space-x-2 transition-all duration-200 hover:shadow-md">
                    <i class="bi bi-plus-circle text-lg"></i>
                    <span>Crear Nueva Oferta</span>
                </a>
            </div> -->

            <!-- Body -->
            <div class="p-8">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="bg-green-50 text-green-800 px-6 py-4 rounded-lg mb-6 flex items-center space-x-3 animate-fade-in">
                        <i class="bi bi-check-circle-fill text-green-600"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-50 text-red-800 px-6 py-4 rounded-lg mb-6 flex items-center space-x-3 animate-fade-in">
                        <i class="bi bi-exclamation-circle-fill text-red-600"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Table or Empty State -->
                @if ($ofertas->isEmpty())
                    <div class="text-center py-12">
                        <i class="bi bi-tags text-gray-400 text-6xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No hay ofertas registradas.</p>
                        <a href="{{ route('ofertas.crear') }}"
                           class="mt-4 inline-block text-blue-600 hover:text-blue-800 font-medium underline">Crea tu primera oferta</a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto text-left text-sm">
                            <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold tracking-wider">
                                <tr>
                                    <th class="px-6 py-4">Nombre</th>
                                    <th class="px-6 py-4">Tipo Oferta</th>
                                    <th class="px-6 py-4">Descuento</th>
                                    <th class="px-6 py-4">Fecha Inicio</th>
                                    <th class="px-6 py-4">Fecha Fin</th>
                                    <th class="px-6 py-4">Estado</th>
                                    <th class="px-6 py-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($ofertas as $oferta)
                                    <tr class="hover:bg-blue-50 transition-all duration-150">
                                        <td class="px-6 py-4 font-medium text-gray-800">{{ $oferta->nombre }}</td>
                                        <td class="px-6 py-4 text-gray-600">
                                            {{ $oferta->tipoOferta ? $oferta->tipoOferta->nombre : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-blue-100 text-blue-800 px-2.5 py-1 rounded-full text-xs font-medium">
                                                {{ number_format($oferta->porcentaje_descuento, 2) }}%
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">{{ $oferta->fecha_inicio->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 text-gray-600">{{ $oferta->fecha_final->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4">
                                            <form action="{{ route('ofertas.updateState', $oferta->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="estado" value="{{ $oferta->estado ? 0 : 1 }}">
                                                <button type="submit"
                                                        class="px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-200 {{ $oferta->estado ? 'bg-green-500 text-white hover:bg-green-600' : 'bg-gray-300 text-gray-800 hover:bg-gray-400' }}">
                                                    {{ $oferta->estado ? 'Activa' : 'Inactiva' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 flex space-x-3">
                                            <a href="{{ route('ofertas.editar', $oferta->id) }}"
                                               class="px-4 py-1.5 bg-yellow-100 text-yellow-800 hover:bg-yellow-200 rounded-full text-sm font-medium flex items-center space-x-1 transition-all duration-200">
                                                <i class="bi bi-pencil"></i>
                                                <span>Editar</span>
                                            </a>
                                            <form action="{{ route('ofertas.destroy', $oferta->id) }}" method="POST"
                                                  onsubmit="return confirm('¿Estás seguro de eliminar esta oferta?')"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="px-4 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-full text-sm font-medium flex items-center space-x-1 transition-all duration-200">
                                                    <i class="bi bi-trash"></i>
                                                    <span>Eliminar</span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                   
                @endif
            </div>
        </div>
    </div>

    <!-- Custom Animation Styles -->
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
@endsection