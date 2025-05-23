<?php

namespace Tests\Unit;

use Tests\TestCase;
use Modules\Ofertas\Models\tipo_oferta;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mockery as m;

class TipoOfertaTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }

    public function test_model_attributes()
    {
        $tipoOferta = new tipo_oferta([
            'nombre' => 'Descuento Especial',
            'descripcion' => 'Ofertas con descuentos especiales'
        ]);

        $this->assertEquals('Descuento Especial', $tipoOferta->nombre);
        $this->assertEquals('Ofertas con descuentos especiales', $tipoOferta->descripcion);
    }

    public function test_fillable_attributes()
    {
        $tipoOferta = new tipo_oferta();
        $expectedFillable = ['nombre', 'descripcion'];
        
        $this->assertEquals($expectedFillable, $tipoOferta->getFillable());
    }

    public function test_table_name()
    {
        $tipoOferta = new tipo_oferta();
        $this->assertEquals('tipo_ofertas', $tipoOferta->getTable());
    }

    public function test_ofertas_relation()
    {
        // 1. Crear mock del modelo tipo_oferta
        $tipoOferta = m::mock(tipo_oferta::class)->makePartial();
        
        // 2. Configurar mock para la relación hasMany
        $mockRelation = m::mock(HasMany::class);
        $mockRelation->shouldReceive('getResults')
            ->andReturn(new Collection([m::mock(Oferta::class)]));
        
        $tipoOferta->shouldReceive('hasMany')
            ->with(Oferta::class, 'tipo_oferta_id')
            ->once()
            ->andReturn($mockRelation);
        
        // 3. Ejecutar y verificar
        $relation = $tipoOferta->ofertas();
        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertInstanceOf(Collection::class, $relation->getResults());
        $this->assertCount(1, $relation->getResults());
    }

    public function test_has_factory_trait()
    {
        $tipoOferta = new tipo_oferta();
        $this->assertContains(HasFactory::class, class_uses($tipoOferta));
    }
}