@extends('layout.dashboard')

@section('layout.dashboard.with-header')
    @include('common.dashboard.title')

    <div class="container my-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white text-center">
                <h3 class="mb-0">Crear Nueva Oferta</h3>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">Selecciona los productos que deseas incluir en la oferta.</p>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="text-center">Seleccionar</th>
                                <th scope="col" class="text-center">Nombre</th>
                                <th scope="col" class="text-center">Precio</th>
                                <th scope="col" class="text-center">Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr class="animate__animated animate__fadeIn">
                                    <td class="text-center">
                                        <input type="checkbox" class="form-check-input product-checkbox" value="{{ $product->id }}" data-id="{{ $product->id }}">
                                    </td>
                                    <td class="text-center fw-bold text-primary">{{ $product->name }}</td>
                                    <td class="text-center text-success">$ {{ number_format($product->tax_value, 2) }}</td>
                                    <td class="text-center text-info">{{ $product->type }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-center mt-4">
                    <button type="button" id="crear-oferta" class="btn btn-success btn-lg">
                        <i class="bi bi-plus-circle me-2"></i> Crear
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"></script>
        <script>
            document.getElementById('crear-oferta').addEventListener('click', function() {
                const selectedProducts = [];
                const checkboxes = document.querySelectorAll('.product-checkbox:checked');
                
                checkboxes.forEach(checkbox => {
                    selectedProducts.push(checkbox.getAttribute('data-id'));
                });

                if (selectedProducts.length === 0) {
                    alert('Por favor, selecciona al menos un producto.');
                    return;
                }

                // Send the selected product IDs to the controller via AJAX
                fetch('{{ route('ofertas.guardarSeleccion') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ product_ids: selectedProducts })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Productos seleccionados guardados correctamente.');
                    } else {
                        alert('Error al guardar los productos.');
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        </script>
    @endpush
@endsection