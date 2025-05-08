<?php

namespace Modules\Ofertas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Ofertas\Models\Oferta;
// use App\Models\Oferta;
// Modules\Ofertas\Models\OfertaProducto; 
use App\Models\Product; // Ajusta si Product está en otro namespace

class OfertaProducto extends Model
{
    use HasFactory;

    protected $table = 'oferta_productos';
    protected $fillable = [
        'oferta_id',
        'producto_id'
    ];

    public function oferta()
    {
        return $this->belongsTo(Oferta::class, 'oferta_id');
    }

    public function producto()
    {
        return $this->belongsTo(Product::class, 'producto_id');
    }
}