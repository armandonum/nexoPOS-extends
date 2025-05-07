<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th class="text-center">Nombre</th>
            <th class="text-center">Precio</th>
            <th class="text-center">Tipo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($productos as $producto)
            <tr>
                <td class="text-center">{{ $producto->name }}</td>
                <td class="text-center">$ {{ number_format($producto->tax_value, 2) }}</td>
                <td class="text-center">{{ $producto->type }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
