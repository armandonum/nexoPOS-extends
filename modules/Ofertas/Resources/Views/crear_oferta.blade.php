@extends('layout.dashboard')

@section('layout.dashboard.with-header')
    @include('common.dashboard.title')

    <div class="container mx-auto my-5">
        {{-- Sección para mostrar mensajes flash de sesión --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Éxito!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="card bg-blue-100 shadow-lg rounded-lg border-0">
            <div class="card-header bg-blue-900 text-white text-center p-4">
                <h3 class="mb-0 text-xl font-semibold">Crear Nueva Oferta</h3>
            </div>
            <div class="card-body p-6">
                <p class="text-gray-600 mb-6">Selecciona los productos que deseas incluir en la oferta.</p>

                <form method="POST" action="{{ route('ofertas.store') }}" class="space-y-6">
                    @csrf

                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="w-full md:w-1/2">
                            <div class="overflow-x-auto rounded-lg shadow-md bg-white">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <div class="flex items-center space-x-2">
                                                    <span>Seleccionar</span>
                                                </div>
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Nombre
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Precio
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Tipo
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($products as $product)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <div class="flex items-center space-x-2">
                                                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600 border-gray-400 rounded focus:ring-blue-500 focus:ring-2 product-checkbox pl-10" name="productos_seleccionados[]" value="{{ $product->id }}" data-precio="{{ $product->tax_value }}" @if(is_array(old('productos_seleccionados')) && in_array($product->id, old('productos_seleccionados'))) checked @elseif(isset($selectedProducts) && in_array($product->id, $selectedProducts)) checked @endif>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                                </td>
                                                @php
                                                    $unidad = $product->unit_quantities->first();
                                                @endphp
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-green-600">
                                                    ${{ $unidad ? number_format($unidad->sale_price, 2) : 'N/A' }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-indigo-600">{{ $product->type }}</div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="w-full md:w-1/2">
                            <div class="space-y-6 bg-white p-4 rounded-lg shadow-md">
                                <h1 class="text-xl font-bold text-blue-900">Detalles de la Oferta</h1>

                                <div class="space-y-4">
                                    <div>
                                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                                        <input type="text" name="nombre" id="nombre" placeholder="Nombre de la oferta" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white" value="{{ old('nombre') }}" required>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="precioTotalCalculado" class="block text-sm font-medium text-gray-700">Suma Productos ($)</label>
                                            <input type="number" id="precioTotalCalculado" readonly class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none bg-gray-100">
                                        </div>
                                        <div>
                                            <label for="porcentaje_descuento" class="block text-sm font-medium text-gray-700">Descuento (%)</label>
                                            <input type="number" name="porcentaje_descuento" id="descuento" placeholder="0.00" step="0.01" min="0" max="100" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('porcentaje_descuento', 0) }}" required>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="precio_total_oferta" class="block text-sm font-medium text-gray-700">Precio Final Oferta ($)</label>
                                        <input type="number" name="precio_total_oferta" id="precioFinalOferta" readonly class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none bg-gray-100">
                                    </div>
                                    
                                    {{-- Hidden input para el monto total de productos sin descuento, si es necesario para el backend --}}
                                    <input type="hidden" name="monto_total_productos_sin_descuento" id="montoTotalProductosSinDescuento">


                                    <div>
                                        <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                                        <textarea name="descripcion" id="descripcion" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('descripcion') }}</textarea>
                                    </div>

                                    <div>
                                        <label for="tipo_oferta_id" class="block text-sm font-medium text-gray-700">Tipo de Oferta</label>
                                        <div class="flex items-center space-x-2">
                                            <select
                                                name="tipo_oferta_id"
                                                id="tipo_oferta_id"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-black hover:text-black bg-white hover:bg-white"
                                                required
                                            >
                                                <option value="" disabled {{ old('tipo_oferta_id') ? '' : 'selected' }}>Seleccione un tipo</option>
                                                @if($tipo_ofertas->isNotEmpty())
                                                    @foreach($tipo_ofertas as $tipo)
                                                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }} - {{ $tipo->descripcion }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="" disabled>No hay tipos de oferta disponibles</option>
                                                @endif
                                            </select>
                                            <a href="{{ route('tipo_ofertas.crear') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-md text-sm whitespace-nowrap">
                                                Agregar
                                            </a>
                                        </div>
                                    </div>

                                    <div>
                                        <h2 class="text-lg font-semibold text-blue-900 mt-3">Productos Seleccionados</h2>
                                        <ul id="productosSeleccionadosLista" class="list-disc pl-5 text-gray-700 max-h-32 overflow-y-auto">
                                            {{-- Los productos se listarán aquí por JS --}}
                                        </ul>
                                    </div>
                                </div>

                               <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-success d-inline-flex align-items-center px-4 py-2">
                                        Crear Oferta
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                     {{-- Inputs hidden para los IDs de los productos seleccionados se añadirán aquí por JS --}}
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const checkboxes = document.querySelectorAll('.product-checkbox');
                const descuentoInput = document.getElementById('descuento');
                const precioTotalCalculadoInput = document.getElementById('precioTotalCalculado');
                const precioFinalOfertaInput = document.getElementById('precioFinalOferta');
                const montoTotalProductosSinDescuentoInput = document.getElementById('montoTotalProductosSinDescuento');

                const productosSeleccionadosList = document.getElementById('productosSeleccionadosLista');
                const form = document.querySelector('form');
                let hiddenProductInputsContainer = document.getElementById('hidden-product-inputs-container');
                if (!hiddenProductInputsContainer) {
                    hiddenProductInputsContainer = document.createElement('div');
                    hiddenProductInputsContainer.id = 'hidden-product-inputs-container';
                    form.appendChild(hiddenProductInputsContainer);
                }


                function calcularTotales() {
                    let sumaPreciosProductos = 0;
                    let productosParaLista = [];
                    let idsProductosSeleccionados = [];

                    checkboxes.forEach(cb => {
                        if (cb.checked) {
                            const precioAttr = cb.getAttribute('data-precio');
                            // Encontrar el precio de la columna 'Precio' de la fila actual
                            const fila = cb.closest('tr');
                            const celdaPrecio = fila.querySelector('td:nth-child(3) div'); // Asumiendo que el precio está en la 3ra celda (td)
                            
                            let precioProducto = 0;
                            if (celdaPrecio && celdaPrecio.textContent) {
                                const textoPrecio = celdaPrecio.textContent.replace('$', '').trim();
                                precioProducto = parseFloat(textoPrecio) || 0;
                            } else {
                                // Fallback si la estructura es diferente o el precio no se encuentra
                                precioProducto = parseFloat(precioAttr) || 0; 
                            }
                            
                            sumaPreciosProductos += precioProducto;
                            productosParaLista.push(cb.closest('tr').querySelector('td:nth-child(2) div').textContent.trim());
                            idsProductosSeleccionados.push(cb.value);
                        }
                    });

                    const descuentoPorcentaje = parseFloat(descuentoInput.value) || 0;
                    const montoDescuento = sumaPreciosProductos * (descuentoPorcentaje / 100);
                    const precioFinalConDescuento = sumaPreciosProductos - montoDescuento;

                    precioTotalCalculadoInput.value = sumaPreciosProductos.toFixed(2);
                    precioFinalOfertaInput.value = precioFinalConDescuento.toFixed(2);
                    montoTotalProductosSinDescuentoInput.value = sumaPreciosProductos.toFixed(2);


                    actualizarListaVisual(productosParaLista);
                    actualizarHiddenInputsProductos(idsProductosSeleccionados);
                }

                function actualizarListaVisual(productosNombres) {
                    productosSeleccionadosList.innerHTML = '';
                    if (productosNombres.length === 0) {
                        const li = document.createElement('li');
                        li.textContent = 'Ningún producto seleccionado.';
                        li.className = 'text-gray-500 italic';
                        productosSeleccionadosList.appendChild(li);
                    } else {
                        productosNombres.forEach(nombre => {
                            const li = document.createElement('li');
                            li.textContent = nombre;
                            productosSeleccionadosList.appendChild(li);
                        });
                    }
                }
                
                function actualizarHiddenInputsProductos(idsProductos) {
                    // Limpiar inputs anteriores
                    hiddenProductInputsContainer.innerHTML = '';

                    idsProductos.forEach(id => {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'productos_seleccionados_ids[]'; // Nombre para el array en el backend
                        hiddenInput.value = id;
                        hiddenProductInputsContainer.appendChild(hiddenInput);
                    });
                }

                checkboxes.forEach(cb => {
                    cb.addEventListener('change', calcularTotales);
                });

                if(descuentoInput) {
                    descuentoInput.addEventListener('input', calcularTotales);
                }

                calcularTotales(); // Calcular al cargar la página
            });
        </script>
    @endpush
@endsection