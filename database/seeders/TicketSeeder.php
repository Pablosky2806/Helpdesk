<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear ticket de prueba con token
        Ticket::create([
            'user_id' => 1,
            'token_acceso' => 'tk_demo_1234567890',
            'nombre' => 'Juan Pérez',
            'apellidos' => 'García López',
            'email' => 'juan.perez@ejemplo.com',
            'telefono' => '600123456',
            'empresa' => 'Tech Solutions SL',
            'tipo_dispositivo' => 'Laptop',
            'marca' => 'Dell',
            'modelo' => 'XPS 15',
            'numero_serie' => 'DELL-XPS15-2024',
            'titulo' => 'No enciende el portátil',
            'descripcion' => 'El portátil Dell XPS 15 no responde al presionar el botón de encendido. He intentado conectarlo a diferentes enchufes y no hay ninguna luz indicadora. El equipo tenía aproximadamente un 50% de batería la última vez que lo usé.',
            'categoria' => 'hardware',
            'prioridad' => 'alta',
            'estado' => 'en_proceso',
            'progreso' => 65,
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subHours(6),
        ]);

        // Crear otro ticket de prueba
        Ticket::create([
            'user_id' => 1,
            'token_acceso' => 'tk_demo_0987654321',
            'nombre' => 'María Rodríguez',
            'apellidos' => 'Sánchez Martín',
            'email' => 'maria.sanchez@ejemplo.com',
            'telefono' => '600987654',
            'empresa' => 'Digital Marketing Agency',
            'tipo_dispositivo' => 'PC Sobremesa',
            'marca' => 'HP',
            'modelo' => 'Pavilion',
            'numero_serie' => 'HP-PAV-2023',
            'titulo' => 'Problema con conexión WiFi',
            'descripcion' => 'El PC no detecta redes WiFi. He reiniciado el router y el equipo, pero sigue sin funcionar. El cable Ethernet funciona correctamente.',
            'categoria' => 'red',
            'prioridad' => 'media',
            'estado' => 'abierto',
            'progreso' => 15,
            'created_at' => now()->subHours(12),
            'updated_at' => now()->subHours(12),
        ]);

        // Crear ticket cerrado
        Ticket::create([
            'user_id' => 1,
            'token_acceso' => 'tk_demo_1122334455',
            'nombre' => 'Carlos Martínez',
            'apellidos' => 'Fernández Gómez',
            'email' => 'carlos.martinez@ejemplo.com',
            'telefono' => '600555666',
            'empresa' => 'Consultoría Integral',
            'tipo_dispositivo' => 'Impresora',
            'marca' => 'Canon',
            'modelo' => 'PIXMA',
            'numero_serie' => 'CAN-PIX-2024',
            'titulo' => 'Atascos de papel frecuentes',
            'descripcion' => 'La impresora se atasca constantemente incluso con poco papel. Ya he limpiado los rodillos.',
            'categoria' => 'hardware',
            'prioridad' => 'baja',
            'estado' => 'cerrado',
            'progreso' => 100,
            'created_at' => now()->subDays(5),
            'updated_at' => now()->subDays(3),
        ]);

        $this->command->info('✅ Tickets de prueba creados con éxito');
        $this->command->info('📋 Tokens de acceso:');
        $this->command->info('   tk_demo_1234567890 - En proceso (65%)');
        $this->command->info('   tk_demo_0987654321 - Abierto (15%)');
        $this->command->info('   tk_demo_1122334455 - Cerrado (100%)');
    }
}
