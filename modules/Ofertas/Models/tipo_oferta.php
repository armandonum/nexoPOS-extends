<?php

namespace Modules\Ofertas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipo_oferta extends Model
{
    /** @use HasFactory<\Database\Factories\TipoOfertaFactory> */
    use HasFactory;

    protected $table = 'tipo_ofertas';
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    //! Relacion con la tabla ofertas
    public function ofertas(){
        return $this->hasMany(Oferta::class, 'tipo_oferta_id');
    }
}
