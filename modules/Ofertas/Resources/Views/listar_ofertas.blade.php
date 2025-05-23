@extends('layout.dashboard')

@section('layout.dashboard.with-header')
    @include('common.dashboard.title')

    <div class="container mx-auto px-4 py-10">
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden transition-all duration-300">
            <div id="crud-table-header" class="p-2 border-b flex flex-col md:flex-row justify-between flex-wrap">

                <!-- Search & Create -->
                <div id="crud-search-box" class="w-full md:w-auto -mx-2 mb-2 md:mb-0 flex items-center flex-wrap">
                    <div class="px-2">
                        <a href="{{ route('ofertas.crear') }}"
                           class="rounded-full ns-crud-button text-sm h-10 flex items-center justify-center cursor-pointer px-3 outline-none border">
                            <i class="las la-plus"></i>
                        </a>
                    </div>

                    <div class="px-2">
                        <div class="rounded-full p-1 ns-crud-input flex">
                            <form action="{{ route('ofertas.index') }}" method="GET" class="relative">
                                <input 
                                    type="text" 
                                    name="search" 
                                    value="{{ request('search') }}"
                                    placeholder="Buscar..."
                                    class="w-36 md:w-auto bg-transparent outline-none px-2"
                                />
                                <button class="rounded-full w-8 h-8 outline-none ns-crud-input-button">
                                    <i class="las la-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @if (request('search'))
                        <div class="px-2 mt-2 md:mt-0">
                            <a href="{{ route('ofertas.index') }}"
                               class="px-4 py-2.5 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg text-sm font-medium flex items-center space-x-1 transition-all duration-200">
                                <i class="bi bi-x-circle"></i>
                                <span>Limpiar filtro</span>
                            </a>
                        </div>
                    @endif
                    <div class="px-2 flex items-center justify-center">
                        <button class="rounded-full text-sm h-10 px-3 outline-none border ns-crud-button">
                            <a href="{{ route('ofertas.index') }}"
                            class="outline-none rounded-full w-24 text-sm p-1 text-center">
                                <i class="las la-sync"></i>
                            </a>                            
                        </button>
                    

                    </div>
                    <div id="crud-buttons" class="-mx-1 flex flex-wrap w-full md:w-auto">
                        <div class="px-1 flex items-center ml-auto">
                            <button class="flex justify-center items-center rounded-full text-sm h-10 px-3 ns-crud-button border outline-none">
                                <i class="las la-download"></i>
                                <span class="ml-1">Descargar</span>
                            </button>
                        </div>
                    </div>


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
            </div>

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
                                    <div class="w-6 h-6 bg-input-background border-input-edge border-2"></div>
                                </th>
                                <th class="border px-2 py-2">Nombre</th>
                                <th class="border px-2 py-2">Tipo Oferta</th>
                                <th class="border px-2 py-2">Descuento</th>
                                <th class="border px-2 py-2">Fecha Inicio</th>
                                <th class="border px-2 py-2">Fecha Fin</th>
                                <th class="border px-2 py-2">Estado</th>
                                <th class="border px-2 py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ofertas as $oferta)
                                <tr class="border text-sm">
                                    <td class="text-center px-2 py-2">
                                        <div class="w-6 h-6 border-input-edge">
                                            <input 
                                            type="checkbox" 
                                            name="ofertas_seleccionadas[]" 
                                            value="{{ $oferta->id }}" 
                                            class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                                            />
                                        </div>
                                    </td>
                                    <td class="p-2">{{ $oferta->nombre }}</td>
                                    <td class="p-2">{{ $oferta->tipoOferta ? $oferta->tipoOferta->nombre : 'N/A' }}</td>
                                    <td class="p-2">{{ number_format($oferta->porcentaje_descuento, 2) }}%</td>
                                    <td class="p-2">{{ $oferta->fecha_inicio->format('d/m/Y') }}</td>
                                    <td class="p-2">{{ $oferta->fecha_final->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('ofertas.updateState', $oferta->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="estado" value="{{ $oferta->estado ? 0 : 1 }}">
                                            <button type="submit"
                                                    class="px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-200 {{ $oferta->estado ? 'bg-green-500 text-white hover:bg-green-600' : 'bg-gray-300 text-gray-800 hover:bg-gray-400' }}">
                                                {{ $oferta->estado ? 'Activa' : 'Inactiva' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="p-2 relative">
                                        <div>
                                            <button class="ns-inset-button options-button outline-none rounded-full w-24 text-sm p-1 border flex items-center justify-center space-x-1 hover:bg-gray-50 transition-colors duration-200" data-offer-id="{{ $oferta->id }}">
                                                <i class="las la-ellipsis-h"></i>
                                                <span>Opciones</span>
                                            </button>
                                        </div>
                                        <div class="options-menu hidden absolute right-0 mt-1 w-48 bg-white rounded-md shadow-lg z-50 border divide-y">
                                            <div class="py-1" role="menu">
                                                <a href="{{ route('ofertas.editar', $oferta->id) }}"
                                                   class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 flex items-center space-x-2">
                                                    <i class="bi bi-pencil text-yellow-500"></i>
                                                    <span>Editar</span>
                                                </a>

                                                <form action="{{ route('ofertas.duplicate', $oferta->id) }}" method="POST" class="block w-full">
                                                    @csrf
                                                    <button type="submit"
                                                            class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 flex items-center space-x-2">
                                                        <i class="bi bi-files text-blue-500"></i>
                                                        <span>Duplicar</span>
                                                    </button>
                                                </form>

                                                <form action="{{ route('ofertas.destroy', $oferta->id) }}" method="POST" class="block w-full">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            onclick="return confirm('¿Estás seguro de eliminar esta oferta?')"
                                                            class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 flex items-center space-x-2">
                                                        <i class="bi bi-trash text-red-500"></i>
                                                        <span>Eliminar</span>
                                                    </button>
                                                </form>
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

    <script>
        // Mostrar/Ocultar menú de opciones
        document.querySelectorAll('.options-button').forEach(button => {
            button.addEventListener('click', function () {
                const menu = this.closest('td').querySelector('.options-menu');
                menu.classList.toggle('hidden');
            });
        });
        document.addEventListener('click', function (event) {
            document.querySelectorAll('.options-menu').forEach(menu => {
                if (!menu.contains(event.target) && !menu.previousElementSibling.contains(event.target)) {
                    menu.classList.add('hidden');
                }
            });
        });
    </script>
@endsection
