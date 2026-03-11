<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario Administrador
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@helpdesk.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Usuario Técnico
        User::create([
            'name' => 'Técnico Soporte',
            'email' => 'tecnico@helpdesk.com',
            'password' => Hash::make('password'),
            'role' => 'tecnico',
        ]);

        // Usuario Cliente normal
        User::create([
            'name' => 'Cliente Ejemplo',
            'email' => 'cliente@helpdesk.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
