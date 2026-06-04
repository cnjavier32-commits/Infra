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
        Schema::create('materiales', function (Blueprint $table) {

            $table->id();

            /*
            IDENTIFICACIÓN
            */
            $table->string('codigo', 50)->unique();

            $table->string('nombre', 255);

            $table->text('descripcion')->nullable();

            /*
            CLASIFICACIÓN
            */
            $table->foreignId('categoria_id')
                ->constrained('categorias')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('marca', 100)
                ->nullable();

            $table->string('modelo', 150)
                ->nullable();

            /*
            INVENTARIO
            */
            $table->string('unidad', 50);

            $table->decimal('stock_actual', 12, 2)
                ->default(0);

            $table->decimal('stock_minimo', 12, 2)
                ->default(0);

            /*
            ADMINISTRACIÓN
            */
            $table->boolean('estado')
                ->default(true);

            $table->text('observaciones')
                ->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materiales');
    }
};
