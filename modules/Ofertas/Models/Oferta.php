<?php

namespace Modules\Ofertas\Models;
use Modules\Ofertas\Models\OfertaProducto;
use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Oferta extends Model
{
    /** @use HasFactory<\Database\Factories\OfertaFactory> */
    use HasFactory;

    protected $table = 'ofertas';
    protected $fillable = [
        'nombre',
        'precio_total',
        'tipo_de_oferta_id',
        'fecha_inicio',
        'fecha_fin',
        'monto_total_productos',
        'porcentaje_descuento',
        'descripcion'
    ];


    //! Relacion con la tabla productos 
    public function products(){
        return $this->belongsToMany(Product::class, 'oferta_productos', 'oferta_id', 'producto_id')->withTimestamps();
    }

}
