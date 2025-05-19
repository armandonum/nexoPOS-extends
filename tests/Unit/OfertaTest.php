<?php

namespace Tests\Unit;

use Tests\TestCase;
use Modules\Ofertas\Models\Oferta;
use Mockery as m;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class OfertaTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
        Carbon::setTestNow();
    }

    public function test_oferta_attributes()
    {
        $oferta = new Oferta([
            'nombre' => 'Oferta Test',
            'estado' => true,
            'precio_total' => 100.50,
            'porcentaje_descuento' => 20.00
        ]);

        $this->assertEquals('Oferta Test', $oferta->nombre);
        $this->assertTrue($oferta->estado);
        $this->assertEquals(100.50, $oferta->precio_total);
        $this->assertEquals(20.00, $oferta->porcentaje_descuento);
    }

    public function test_scope_activas()
    {
        
        $query = m::mock(Builder::class);
        
        
        $query->shouldReceive('where')
            ->with('estado', true)
            ->once()
            ->andReturnSelf();
        
        
        $query->shouldReceive('where')
            ->with('fecha_inicio', '<=', m::type(Carbon::class))
            ->once()
            ->andReturnSelf();
            
        $query->shouldReceive('where')
            ->with('fecha_final', '>=', m::type(Carbon::class))
            ->once()
            ->andReturnSelf();

        $result = (new Oferta())->scopeActivas($query);
        $this->assertSame($query, $result);
    }
}