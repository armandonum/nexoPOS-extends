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
                
                <form method="POST" action="{{ route('ofertas.guardarYRedirigir') }}">
                    @csrf
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
                                            <input type="checkbox" class="form-check-input product-checkbox" name="product_ids[]" value="{{ $product->id }}">
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
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-plus-circle me-2"></i> Crear
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"></script>
    @endpush
@endsection