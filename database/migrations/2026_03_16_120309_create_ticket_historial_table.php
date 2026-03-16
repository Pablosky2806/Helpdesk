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
        Schema::create('ticket_historials', function (Blueprint $table) {
            $table->id();
            
            // Relación con el ticket
            $table->foreignId('ticket_id')
                  ->constrained('tickets')
                  ->onDelete('cascade');
            
            // Usuario que realizó el cambio
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            // Estados
            $table->string('estado_anterior')->nullable();
            $table->string('estado_nuevo');
            
            // Información adicional
            $table->text('comentarios')->nullable();
            $table->string('accion'); // 'cambio_estado', 'asignacion', 'comentario', etc.
            
            $table->timestamps();
            
            // Índices para búsquedas rápidas
            $table->index(['ticket_id', 'created_at']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_historials');
    }
};
