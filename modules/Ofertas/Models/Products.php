<?php

namespace Modules\Ofertas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'price',
        'size',
        // 'category_id'
    ];

    // Especificar el factory correcto
    protected static function newFactory()
    {
        return \Modules\Ofertas\Database\Factories\ProductsFactory::new();
    }
}