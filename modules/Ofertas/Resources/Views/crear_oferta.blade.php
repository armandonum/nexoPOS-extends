@extends('layout.dashboard')

@section('layout.dashboard.with-header')
    @include('common.dashboard.title')

    <div class="container mx-auto my-5">
        <div class="card bg-blue-100 shadow-lg rounded-lg border-0">
            <div class="card-header bg-blue-900 text-white text-center p-4">
                <h3 class="mb-0 text-xl font-semibold">Crear Nueva Oferta</h3>
            </div>
            <div class="card-body p-6">
                <p class="text-gray-600 mb-6">Selecciona los productos que deseas incluir en la oferta.</p>

                <form method="POST" action="{{ route('ofertas.store') }}" class="space-y-6">
                    @csrf

                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Tabla de Productos -->
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
                                            <tr class="animate__animated animate__fadeIn">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <div class="flex items-center space-x-2">
                                                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600 border-gray-400 rounded focus:ring-blue-500 focus:ring-2 product-checkbox pl-10" name="productos[]" value="{{ $product->id }}" data-precio="{{ $product->tax_value }}" @if(in_array($product->id, $selectedProducts)) checked @endif>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                                </td>
                                                <!-- <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-green-600">$ {{ number_format($product->tax_value, 2) }}</div>
                                                </td> -->
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

                        <!-- Detalles de la Oferta -->
                        <div class="w-full md:w-1/2">
                            <div class="space-y-6 bg-white p-4 rounded-lg shadow-md">
                                <h1 class="text-xl font-bold text-blue-900">Detalles de la Oferta</h1>

                                <div class="space-y-4">
                                    <div>
                                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                                        <input type="text" name="nombre" id="nombre" placeholder="Nombre" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="precio_total" class="block text-sm font-medium text-gray-700">Precio Total de la Oferta</label>
                                            <input type="number" name="precio_total" id="precioTotal" readonly class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-100">
                                        </div>
                                        <div>
                                            <label for="porcentaje_descuento" class="block text-sm font-medium text-gray-700">Porcentaje de Descuento</label>
                                            <input type="number" name="porcentaje_descuento" id="descuento" placeholder="0.00" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" oninput="calcularTotales()">
                                        </div>
                                    </div>

                                    <div>
                                        <label for="total_pagar" class="block text-sm font-medium text-gray-700">Monto Total de los Productos</label>
                                        <input type="number" name="monto_total_productos" id="montoTotal" readonly class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-100">
                                    </div>

                                    <div>
                                        <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                                        <textarea name="descripcion" id="descripcion" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                    </div>

                                    <div>
                                        <h1 class="text-xl font-bold text-blue-900">Lista de Productos Seleccionados</h1>
                                        <ul id="productosSeleccionados" class="list-disc pl-5 text-gray-700"></ul>
                                    </div>
                                </div>

                                <div class="text-center mt-6">
                                    <button type="submit" class="btn btn-success inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-black bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" />
                                        </svg>
                                        Crear Oferta
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const checkboxes = document.querySelectorAll('.product-checkbox');
                const descuentoInput = document.getElementById('descuento');
                const precioTotalInput = document.getElementById('precioTotal');
                const montoTotalInput = document.getElementById('montoTotal');
                const productosSeleccionadosList = document.getElementById('productosSeleccionados');
                const form = document.querySelector('form');

                function calcularTotales() {
                    let montoTotal = 0;
                    let productosSeleccionados = [];

                    checkboxes.forEach(cb => {
                        if (cb.checked) {
                            const precio = parseFloat(cb.getAttribute('data-precio')) || 0;
                            montoTotal += precio;
                            productosSeleccionados.push({
                                id: cb.value,
                                name: cb.closest('tr').querySelector('td:nth-child(2) div').textContent.trim()
                            });
                        }
                    });

                    const descuento = parseFloat(descuentoInput.value) || 0;
                    const precioTotal = montoTotal * (1 - descuento / 100);

                    precioTotalInput.value = montoTotal.toFixed(2);
                    montoTotalInput.value = precioTotal.toFixed(2);
                    actualizarLista(productosSeleccionados);

                    const hiddenInputs = document.querySelectorAll('input[name="productos[]"][type="hidden"]');
                    hiddenInputs.forEach(input => input.remove());

                    const uniqueProductIds = [...new Set(productosSeleccionados.map(prod => prod.id))];
                    uniqueProductIds.forEach(productId => {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'productos[]';
                        hiddenInput.value = productId;
                        form.appendChild(hiddenInput);
                    });
                }

                function actualizarLista(productos) {
                    productosSeleccionadosList.innerHTML = '';
                    productos.forEach(prod => {
                        const li = document.createElement('li');
                        li.textContent = `${prod.name}`;
                        productosSeleccionadosList.appendChild(li);
                    });
                }

                checkboxes.forEach(cb => {
                    cb.addEventListener('change', calcularTotales);
                });
                descuentoInput.addEventListener('input', calcularTotales);

                calcularTotales();
            });
        </script>
    @endpush
@endsection