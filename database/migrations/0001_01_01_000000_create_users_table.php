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
        Schema::create('users', function (Blueprint $table) {

            $table->id();

            // Datos personales
            $table->string('name', 100);
            $table->string('last_name', 150)->nullable();

            // Documento
            $table->string('dni', 20)->unique()->nullable();

            // Contacto
            $table->string('email')->unique();
            $table->string('phone', 20)->nullable();
            $table->string('address', 255)->nullable();

            // Perfil
            $table->string('photo')->nullable();

            // Control de acceso
            $table->string('role', 50)->default('user');
            $table->boolean('active')->default(true);

            // Auditoría básica
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 45)->nullable();

            // Laravel
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
