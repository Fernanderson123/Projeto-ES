<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Pet;
use App\Models\Produto;
use App\Models\Agendamento;
use App\Models\Prontuario;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Desabilita chaves estrangeiras para limpar tudo sem erro
        Schema::disableForeignKeyConstraints();

        // 2. Limpa todas as tabelas
        Prontuario::truncate();
        Agendamento::truncate();
        Pet::truncate();
        Produto::truncate();
        Cliente::truncate();
        User::truncate();

        Schema::enableForeignKeyConstraints();

        // --- CRIAÇÃO DOS USUÁRIOS ---

        User::factory()->perfil('Admin')->create([
            'name' => 'Admin Teste',
            'email' => 'admin@email.com',
            'password' => Hash::make('123456')
        ]);

        $vet = User::factory()->perfil('Veterinário')->create([
            'name' => 'Dr. Veterinário',
            'email' => 'veterinario@email.com',
            'password' => Hash::make('123456')
        ]);

        User::factory()->perfil('Recepcionista')->create([
            'name' => 'Recepcionista Teste',
            'email' => 'recepcionista@email.com',
            'password' => Hash::make('123456')
        ]);

        User::factory()->perfil('Investidor')->create([
            'name' => 'Investidor Teste',
            'email' => 'investidor@email.com',
            'password' => Hash::make('123456')
        ]);

         // Usuário Cliente (Login)
         $userCliente = User::factory()->perfil('Cliente')->create([
            'name' => 'Cliente Teste',
            'email' => 'cliente@email.com',
            'password' => Hash::make('123456')
        ]);

        // --- DADOS DE NEGÓCIO ---

        // 1. Cria o cadastro do Cliente
        $cliente = Cliente::create([
            'user_id' => $userCliente->id,
            'nome_completo' => $userCliente->name,
            'email' => $userCliente->email,
            'cpf' => '123.456.789-00',
            'telefone' => '(11) 99999-8888',
            'endereco_cidade' => 'São Paulo',
            'endereco_estado' => 'SP'
        ]);

        // 2. Cria um Pet para esse cliente
        $pet = Pet::create([
            'cliente_id' => $cliente->id,
            'nome' => 'Rex',
            'especie' => 'Cachorro',
            'raca' => 'Labrador',
            'peso' => 28.50,
            'data_nascimento' => '2020-05-15',
        ]);

        // 3. Cria um Produto (Vacina)
        Produto::create([
            'nome' => 'Vacina V10',
            'marca' => 'Zoetis',
            'unidade' => 'fr',
            'estoque' => 50,
            'preco_custo' => 45.00,
            'preco_venda' => 90.00,
            'validade' => '2026-12-31',
            'descricao' => 'Vacina múltipla para cães.'
        ]);

        // 4. Cria um Agendamento CONCLUÍDO (Passado)
        $agendamentoPassado = Agendamento::create([
            'pet_id' => $pet->id,
            'veterinario_id' => $vet->id,
            'data_hora' => now()->subDays(7)->setHour(14)->setMinute(0), // 7 dias atrás
            'tipo' => 'Consulta',
            'status' => 'Concluído',
            'observacoes' => 'Animal apresentava coceira na orelha.'
        ]);

        // 5. Cria um Prontuário vinculado ao agendamento passado
        Prontuario::create([
            'pet_id' => $pet->id,
            'veterinario_id' => $vet->id,
            'agendamento_id' => $agendamentoPassado->id,
            'data_atendimento' => $agendamentoPassado->data_hora,
            'sintomas' => 'Prurido intenso e eritema em pavilhão auricular direito.',
            'diagnostico' => 'Otite externa bacteriana.',
            'tratamento' => 'Limpeza local e aplicação de gotas otológicas por 7 dias.',
            'observacoes' => 'Retorno sugerido em 1 semana.'
        ]);

        // 6. Cria um Agendamento FUTURO (Agendado)
        Agendamento::create([
            'pet_id' => $pet->id,
            'veterinario_id' => $vet->id,
            'data_hora' => now()->addDays(2)->setHour(10)->setMinute(30), // Daqui a 2 dias
            'tipo' => 'Retorno',
            'status' => 'Agendado',
            'observacoes' => 'Acompanhamento da otite.'
        ]);
    }
}