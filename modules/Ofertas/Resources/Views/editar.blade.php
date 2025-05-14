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

        <div class="card shadow-lg rounded-lg border-0" style="background-color: rgb(var(--box-background));">
            <div class="card-body p-6">
                <p class="p-4 text-gray-600">Selecciona los productos que deseas incluir en la oferta.</p>

                <form method="POST" action="{{ route('ofertas.update', $oferta->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="w-full md:w-1/2 p-4">
                            <div class="overflow-x-auto rounded-lg shadow-md bg-white p-4 border-gray-200">
                                <table class="w-3/4 divide-y divide-gray-300">
                                    <thead class="bg-gray-100 p-4">
                                        <tr>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <div class="flex items-center space-x-2 p-4">
                                                    <span>Seleccionar</span>
                                                </div>
                                            </th>
                                            <th class="px-6 p-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Nombre
                                            </th>
                                            <th class="px-6 py-3 p-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Precio
                                            </th>
                                            <th class="px-6 py-3 p-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Descripcion
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($products as $product)
                                            <tr>
                                                <td class="px-6 p-4 whitespace-nowrap text-sm text-gray-500">
                                                    <div class="flex items-center space-x-2">
                                                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600 border-gray-400 rounded focus:ring-blue-500 focus:ring-2 product-checkbox pl-10" name="productos_seleccionados[]" value="{{ $product->id }}" data-precio="{{ $product->tax_value }}" @if(in_array($product->id, $selectedProducts)) checked @endif>
                                                    </div>
                                                </td>
                                                <td class="px-6 p-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                                </td>
                                                @php $unidad = $product->unit_quantities->first(); @endphp
                                                <td class="px-6 p-4 whitespace-nowrap">
                                                    <div class="text-sm text-green-600">
                                                        ${{ $unidad ? number_format($unidad->sale_price, 2) : 'N/A' }}
                                                    </div>
                                                </td>
                                                <td class="px-6 p-4 whitespace-nowrap">
                                                    <div class="text-sm text-indigo-600">{{ $product->description }}</div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="w-full md:w-1/2 p-4">
                            <div class="space-y-6 bg-white p-4 rounded-lg shadow-md">
                                <h1 class="text-xl font-bold text-blue-900">Detalles de la Oferta</h1>

                                <div class="space-y-4">
                                    <div class="p-4">
                                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                                        <input type="text" name="nombre" id="nombre" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white" value="{{ old('nombre', $oferta->nombre) }}" required>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="p-4">
                                            <label for="precioTotalCalculado" class="block text-sm font-medium text-gray-700">Suma Productos ($)</label>
                                            <input type="number" id="precioTotalCalculado" readonly class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none bg-gray-100">
                                        </div>
                                        <div class="p-4">
                                            <label for="porcentaje_descuento" class="block text-sm font-medium text-gray-700">Descuento (%)</label>
                                            <input type="number" name="porcentaje_descuento" id="descuento" step="0.01" min="0" max="100" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('porcentaje_descuento', $oferta->porcentaje_descuento) }}" required>
                                        </div>
                                    </div>

                                    <div class="p-4">
                                        <label for="precio_total_oferta" class="block text-sm font-medium text-gray-700">Precio Final Oferta ($)</label>
                                        <input type="number" name="precio_total" id="precioFinalOferta" readonly class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none bg-gray-100">
                                    </div>

                                    <input type="hidden" name="monto_total_productos_sin_descuento" id="montoTotalProductosSinDescuento">

                                    <div class="p-4">
                                        <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                                        <textarea name="descripcion" id="descripcion" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('descripcion', $oferta->descripcion) }}</textarea>
                                    </div>

                                    <div class="p-4 grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
                                            <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio', $oferta->fecha_inicio->format('Y-m-d')) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none">
                                        </div>
                                        <div>
                                            <label for="fecha_final" class="block text-sm font-medium text-gray-700">Fecha Final</label>
                                            <input type="date" name="fecha_final" value="{{ old('fecha_final', $oferta->fecha_final->format('Y-m-d')) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none">
                                        </div>
                                    </div>

                                    <div class="p-4">
                                        <label for="tipo_oferta_id" class="block text-sm font-medium text-gray-700">Tipo de Oferta</label>
                                        <select name="tipo_oferta_id" id="tipo_oferta_id" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-black bg-white" required>
                                            @foreach($tipo_ofertas as $tipo)
                                                <option value="{{ $tipo->id }}" {{ old('tipo_oferta_id', $oferta->tipo_oferta_id) == $tipo->id ? 'selected' : '' }}>{{ $tipo->nombre }} - {{ $tipo->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="p-4">
                                        <h2 class="text-lg font-semibold text-blue-900 mt-3">Productos Seleccionados</h2>
                                        <ul id="productosSeleccionadosLista" class="list-disc pl-5 text-gray-700 max-h-32 overflow-y-auto"></ul>
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-md text-sm whitespace-nowrap">
                                        Actualizar Oferta
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div id="hidden-product-inputs-container"></div>
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
                        hiddenInput.name = 'productos[]'; // Nombre para el array en el backend
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

                calcularTotales(); 
            });
        </script>
    @endpush
@endsection
