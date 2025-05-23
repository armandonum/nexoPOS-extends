@extends('layout.dashboard')

@section('layout.dashboard.with-header')
    @include('common.dashboard.title')


    <div class="container mx-auto px-4 py-10">
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden transition-all duration-300">
            <div class="p-8">
                <!-- Search Form -->
                <div class=" w-full md:w-auto -mx-2 mb-2 md:mb-0 flex">
    <form action="{{ route('ofertas.index') }}" method="GET" class="flex-1">
        <div class="bg-gray-200 rounded-full p-1 ns-crud-input flex">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Buscar ofertas por nombre..."
                   class="w-56  bg-transparent outline-none px-2"
                   id="search-input">
            <span class="absolute inset-y-0 right-3 flex items-center text-gray-400">
                <i class="bi bi-search"></i>
            </span>
        </div>
    </form>
    @if (request('search'))
        <a href="{{ route('ofertas.index') }}"
           class="px-4 py-2.5 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg text-sm font-medium flex items-center space-x-1 transition-all duration-200">
            <i class="bi bi-x-circle"></i>
            <span>Limpiar filtro</span>
        </a>
    @endif
</div>

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
                        <p class="text-gray-500 text-lg">
                            {{ request('search') ? 'No se encontraron ofertas para la búsqueda.' : 'No hay ofertas registradas.' }}
                        </p>
                        <a href="{{ route('ofertas.crear') }}"
                           class="mt-4 inline-block text-blue-600 hover:text-blue-800 font-medium underline">Crea tu primera oferta</a>
                    </div>
                @else

                    <div class="flex p-2 overflow-x-auto flex-auto">
                        <table class="table ns-table w-full">
                            <thead>

                                <tr>
                                    <th class="text-center px-2 border w-16 py-2">
                                        <div class="flex ns-checkbox cursor-pointer mb-2">
                                            <div class="w-6 h-6 flex bg-input-background border-input-edge border-2 items-center justify-center cursor-pointer">
                                            </div>
                                        </div>
                                    </th>
                                    <th class="cursor-pointer w-40 border text-left px-2 py-2">
                                        <div class="w-full flex justify-between items-center">
                                            <span>Nombre</span>
                                            <span class="h-6 w-6 flex justify-center items-center"></span>
                                        </div>
                                    </th>
                                    <th class="cursor-pointer w-40 border text-left px-2 py-2">
                                        <div class="w-full flex justify-between items-center">
                                            <span>Tipo Oferta</span>
                                            <span class="h-6 w-6 flex justify-center items-center"></span>
                                        </div>
                                    </th>
                                    <th class="cursor-pointer w-40 border text-left px-2 py-2">
                                        <div class="w-full flex justify-between items-center">
                                            <span>Descuento</span>
                                            <span class="h-6 w-6 flex justify-center items-center"></span>
                                        </div>
                                    </th>
                                    <th class="cursor-pointer w-40 border text-left px-2 py-2">
                                        <div class="w-full flex justify-between items-center">
                                            <span>Fecha Inicio</span>
                                            <span class="h-6 w-6 flex justify-center items-center"></span>
                                        </div>
                                    </th>
                                    <th class="cursor-pointer w-40 border text-left px-2 py-2">
                                        <div class="w-full flex justify-between items-center">
                                            <span>Fecha Fin</span>
                                            <span class="h-6 w-6 flex justify-center items-center"></span>
                                        </div>
                                    </th>
                                    <th class="cursor-pointer w-40 border text-left px-2 py-2">
                                        <div class="w-full flex justify-between items-center">
                                            <span>Estado</span>
                                            <span class="h-6 w-6 flex justify-center items-center"></span>
                                        </div>
                                    </th>
                                    <th class="cursor-pointer w-40 border text-left px-2 py-2">
                                        <div class="w-full flex justify-between items-center">
                                            <span>Acciones</span>
                                            <span class="h-6 w-6 flex justify-center items-center"></span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($ofertas as $oferta)
                                    <tr class="ns-table-row border text-sm">
                                        <th class="text-center px-2 border w-16 py-2">
                                            <div class="flex ns-checkbox cursor-pointer mb-2">
                                                <div class="w-6 h-6 flex bg-input-background border-input-edge border-2 items-center justify-center cursor-pointer">
                                                </div>
                                            </div>
                                        </th>
                                        <td class="font-sans p-2">{{ $oferta->nombre }}</td>
                                        <td class="font-sans p-2">{{ $oferta->tipoOferta ? $oferta->tipoOferta->nombre : 'N/A' }}</td>
                                        <td class="font-sans p-2">{{ number_format($oferta->porcentaje_descuento, 2) }}%</td>
                                        <td class="font-sans p-2">{{ $oferta->fecha_inicio->format('d/m/Y') }}</td>
                                        <td class="font-sans p-2">{{ $oferta->fecha_final->format('d/m/Y') }}</td>
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
                                        <td class="font-sans p-2 relative">
                                            <div>
                                                <button class="ns-inset-button options-button outline-none rounded-full w-24 text-sm p-1 border flex items-center justify-center space-x-1 hover:bg-gray-50 transition-colors duration-200" data-offer-id="{{ $oferta->id }}">
                                                    <i class="las la-ellipsis-h"></i>
                                                    <span>Opciones</span>

                                                </button>
                                            </div>
                                            
                                            <div class="options-menu hidden absolute right-0 mt-1 w-48 bg-white rounded-md shadow-lg z-50 border border-gray-200 divide-y divide-gray-100 ">
                                                <div class="rounded-md shadow-xs">
                                                <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                                    <!-- Opción Editar -->
                                                    <a href="{{ route('ofertas.editar', $oferta->id) }}"
                                                    class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 flex items-center space-x-2 transition-colors duration-150 ns-action-button block px-4 py-2.5 hover:bg-gray-50 py-2 leading-5"
                                                    target="_self" role="menuitem">
                                                        <i class="bi bi-pencil text-yellow-500"></i>
                                                        <span>Editar</span>
                                                    </a>


                                                    <!-- Opción Duplicar -->
                                                    <form action="{{ route('ofertas.duplicate', $oferta->id) }}" method="POST" class="block w-full">
                                                        @csrf
                                                        <button type="submit"
                                                                class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 flex items-center space-x-2 transition-colors duration-150 ns-action-button block px-4 py-2.5 hover:bg-gray-50 py-2 leading-5"
                                                                target="_self" role="menuitem">
                                                            <i class="bi bi-files text-blue-500"></i>
                                                            <span>Duplicar</span>
                                                        </button>
                                                    </form>

                                                    <!-- Opción Eliminar -->
                                                    <form action="{{ route('ofertas.destroy', $oferta->id) }}" method="POST" class="block w-full">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                onclick="return confirm('¿Estás seguro de eliminar esta oferta?')"
                                                                class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 flex items-center space-x-2 transition-colors duration-150 ns-action-button block px-4 py-2.5 hover:bg-gray-50 py-2 leading-5"
                                                                target="_self" role="menuitem">
                                                            <i class="bi bi-trash text-red-500"></i>
                                                            <span>Eliminar</span>
                                                        </button>
                                                    </form>
                                                </div>

                                                </div>
                                            </div>

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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cerrar menús al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.options-button') && !e.target.closest('.options-menu')) {
            document.querySelectorAll('.options-menu').forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    });

    // Manejar clic en botones de opciones
    document.querySelectorAll('.options-button').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const menu = this.closest('td').querySelector('.options-menu');
            
            // Cerrar otros menús abiertos
            document.querySelectorAll('.options-menu').forEach(m => {
                if (m !== menu) m.classList.add('hidden');
            });
            
            // Alternar menú actual
            menu.classList.toggle('hidden');
        });
    });
});
</script>
@endpush


    <script>
        document.getElementById('search-input').addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.oferta-row');

            rows.forEach(row => {
                const name = row.dataset.name;
                row.style.display = name.includes(searchTerm) ? '' : 'none';
            });
        });
    </script>


