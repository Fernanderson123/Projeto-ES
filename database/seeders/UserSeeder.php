<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Limpa a tabela para evitar duplicados
        User::truncate();

        // Admin
        User::factory()->perfil('Admin')->create([
            'name' => 'Admin Teste',
            'email' => 'admin@email.com',
            'password' => Hash::make('123456')
        ]);

        // Recepcionista
        User::factory()->perfil('Recepcionista')->create([
            'name' => 'Recepcionista Teste',
            'email' => 'recepcionista@email.com',
            'password' => Hash::make('123456')
        ]);

        // Veterinário
        User::factory()->perfil('Veterinário')->create([
            'name' => 'Veterinário Teste',
            'email' => 'veterinario@email.com',
            'password' => Hash::make('123456')
        ]);

        // Investidor
        User::factory()->perfil('Investidor')->create([
            'name' => 'Investidor Teste',
            'email' => 'investidor@email.com',
            'password' => Hash::make('123456')
        ]);

         // Cliente
         User::factory()->perfil('Cliente')->create([
            'name' => 'Cliente Teste',
            'email' => 'cliente@email.com',
            'password' => Hash::make('123456')
        ]);
    }
}