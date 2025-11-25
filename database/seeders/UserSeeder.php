<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema; // <--- Importação Essencial
use App\Models\User;
use App\Models\Cliente;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Desabilita chaves estrangeiras (Funciona em SQLite e MySQL)
        Schema::disableForeignKeyConstraints();

        // 2. Limpa as tabelas para evitar duplicados
        Cliente::truncate();
        User::truncate();

        // 3. Reabilita chaves estrangeiras
        Schema::enableForeignKeyConstraints();

        // --- CRIAÇÃO DOS USUÁRIOS ---

        // 1. Admin
        User::factory()->perfil('Admin')->create([
            'name' => 'Admin Teste',
            'email' => 'admin@email.com',
            'password' => Hash::make('123456')
        ]);

        // 2. Recepcionista
        User::factory()->perfil('Recepcionista')->create([
            'name' => 'Recepcionista Teste',
            'email' => 'recepcionista@email.com',
            'password' => Hash::make('123456')
        ]);

        // 3. Veterinário
        User::factory()->perfil('Veterinário')->create([
            'name' => 'Veterinário Teste',
            'email' => 'veterinario@email.com',
            'password' => Hash::make('123456')
        ]);

        // 4. Investidor
        User::factory()->perfil('Investidor')->create([
            'name' => 'Investidor Teste',
            'email' => 'investidor@email.com',
            'password' => Hash::make('123456')
        ]);

         // 5. Cliente (Usuário de Login + Registro na Tabela Clientes)
         $userCliente = User::factory()->perfil('Cliente')->create([
            'name' => 'Cliente Teste',
            'email' => 'cliente@email.com',
            'password' => Hash::make('123456')
        ]);

        // Cria automaticamente o vínculo na tabela 'clientes'
        Cliente::create([
            'user_id' => $userCliente->id,
            'nome_completo' => $userCliente->name,
            'email' => $userCliente->email,
            'cpf' => '000.000.000-00',
            'telefone' => '(00) 00000-0000'
        ]);
    }
}