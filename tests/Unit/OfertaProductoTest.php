<?php

namespace Tests\Unit;

use Tests\TestCase;
use Modules\Ofertas\Models\OfertaProducto;
use Modules\Ofertas\Models\Oferta;
use App\Models\Product;
use Mockery as m;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfertaProductoTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }

    public function test_model_attributes()
    {
        $ofertaProducto = new OfertaProducto([
            'oferta_id' => 1,
            'producto_id' => 10
        ]);

        $this->assertEquals(1, $ofertaProducto->oferta_id);
        $this->assertEquals(10, $ofertaProducto->producto_id);
    }

    public function test_oferta_relation()
    {
        // 1. Crear mock del modelo OfertaProducto
        $ofertaProducto = m::mock(OfertaProducto::class)->makePartial();
        
        // 2. Configurar mock para la relación belongsTo
        $mockRelation = m::mock(BelongsTo::class);
        $ofertaProducto->shouldReceive('belongsTo')
            ->with(Oferta::class, 'oferta_id')
            ->once()
            ->andReturn($mockRelation);
        
        // 3. Ejecutar y verificar
        $relation = $ofertaProducto->oferta();
        $this->assertInstanceOf(BelongsTo::class, $relation);
    }

    public function test_producto_relation()
    {
        // 1. Crear mock del modelo OfertaProducto
        $ofertaProducto = m::mock(OfertaProducto::class)->makePartial();
        
        // 2. Configurar mock para la relación belongsTo
        $mockRelation = m::mock(BelongsTo::class);
        $ofertaProducto->shouldReceive('belongsTo')
            ->with(Product::class, 'producto_id')
            ->once()
            ->andReturn($mockRelation);
        
        // 3. Ejecutar y verificar
        $relation = $ofertaProducto->producto();
        $this->assertInstanceOf(BelongsTo::class, $relation);
    }

    public function test_fillable_attributes()
    {
        $fillable = ['oferta_id', 'producto_id'];
        $ofertaProducto = new OfertaProducto();

        $this->assertEquals($fillable, $ofertaProducto->getFillable());
    }

    public function test_table_name()
    {
        $ofertaProducto = new OfertaProducto();
        $this->assertEquals('oferta_productos', $ofertaProducto->getTable());
    }
}