<?php

namespace Modules\Ofertas\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TipoOferta extends Model
{
    use HasFactory;

    protected $table = 'tipo_ofertas';
    protected $fillable = [
        'nombre',
        'descripcion'
    ];

}
