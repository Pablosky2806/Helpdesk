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
    Schema::create('tickets', function (Blueprint $table) {
        $table->id();

        // Usuario que crea el ticket
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        // Datos del cliente
        $table->string('nombre');
        $table->string('apellidos');
        $table->string('email');
        $table->string('telefono')->nullable();
        $table->string('empresa')->nullable();

        // Información del dispositivo
        $table->string('tipo_dispositivo');
        $table->string('marca');
        $table->string('modelo');
        $table->string('numero_serie')->nullable();

        // Información del problema
        $table->string('titulo');
        $table->text('descripcion');
        $table->string('categoria');
        $table->enum('prioridad', ['baja', 'media', 'alta'])->default('media');
        $table->enum('estado', ['abierto', 'en_proceso', 'cerrado'])->default('abierto');

        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
