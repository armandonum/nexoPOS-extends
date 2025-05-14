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
        
            Schema::create('ofertas', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');
                $table->decimal('precio_total', 8, 2);

                $table->unsignedBigInteger('tipo_oferta_id')->nullable();
                $table->foreign('tipo_oferta_id')->references('id')->on('tipo_ofertas');
                                //$table->date('fecha_inicio')->nullable();
                //$table->date('fecha_fin')->nullable();

                $table->decimal('monto_total_productos', 8, 2);
                $table->decimal('porcentaje_descuento', 5, 2);
                $table->string('descripcion');
                $table->boolean('estado')->default(true); // Activo por defect
                $table->date('fecha_inicio');
                $table->date('fecha_final');
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
