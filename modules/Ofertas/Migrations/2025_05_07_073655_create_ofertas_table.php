<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // id (PK)
        // nombre (nombre de la oferta)
        // precio_total (precio total después de descuento)
        // monto_total_productos (suma de precios de productos sin descuento)
        // porcentaje_descuento (porcentaje aplicado)
        // descripcion (descripción de la oferta)
        Schema::create('ofertas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('precio_total', 8, 2);
            $table->decimal('monto_total_productos', 8, 2);
            $table->decimal('porcentaje_descuento', 5, 2);
            $table->string('descripcion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ofertas');
    }
};
