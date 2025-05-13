<?php

namespace Modules\Ofertas\Models;

use Modules\Ofertas\Models\OfertaProducto;
use App\Models\Product;
// use App\Models\tipo_oferta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Ofertas\Models\tipo_oferta;


class Oferta extends Model
{
    /** @use HasFactory<\Database\Factories\OfertaFactory> */
    use HasFactory;


    protected $table = 'ofertas';
    protected $fillable = [
        'nombre',
        'precio_total',
        'monto_total_productos',
        'porcentaje_descuento',
        'descripcion',
        'estado',
        'tipo_oferta_id',
        'fecha_inicio',
        'fecha_final',
    ];


    //! Relacion con la tabla productos 
    public function products()
    {
        return $this->belongsToMany(Product::class, 'oferta_productos', 'oferta_id', 'producto_id')->withTimestamps();
    }

    //! Relacion con la tabla tipo_ofertas
    public function tipoOferta()
    {
        return $this->belongsTo(tipo_oferta::class, 'tipo_oferta_id');
    }

    // Agregar este scope
    public function scopeActivas($query)
    {
        return $query->where('estado', true)
            ->where('fecha_inicio', '<=', now())
            ->where('fecha_final', '>=', now());
    }

    protected $casts = [
        'estado' => 'boolean',
        'fecha_inicio' => 'date',
        'fecha_final' => 'date',
        'porcentaje_descuento' => 'decimal:2'
    ];

    protected $with = ['products', 'tipoOferta'];
}
