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
        Schema::create('movimientos', function (Blueprint $table) {

            $table->id();

            $table->foreignId('material_id')
                ->constrained('materiales')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->enum('tipo', [
                'INGRESO',
                'SALIDA',
            ]);

            $table->decimal('cantidad', 12, 2);

            $table->decimal('stock_anterior', 12, 2);

            $table->decimal('stock_nuevo', 12, 2);

            $table->text('descripcion')
                ->nullable();

            $table->timestamp('fecha_movimiento');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
