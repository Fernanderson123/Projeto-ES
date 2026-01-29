<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Pet;
use App\Models\Cliente;
use App\Models\Agendamento;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModelLogicTest extends TestCase
{
    // Limpa o banco de dados em memória a cada teste para garantir isolamento
    use RefreshDatabase;

    /**
     * Teste 1: Verifica se o método helper isAdmin() retorna true apenas para Admin.
     */
    public function test_verifica_se_usuario_e_admin(): void
    {
        // Cenário A: Usuário é Admin
        $admin = new User(['perfil' => 'Admin']);
        $this->assertTrue($admin->isAdmin(), 'Erro: Usuário com perfil Admin deve retornar true');

        // Cenário B: Usuário é Cliente
        $cliente = new User(['perfil' => 'Cliente']);
        $this->assertFalse($cliente->isAdmin(), 'Erro: Usuário com perfil Cliente deve retornar false para isAdmin');
    }

    /**
     * Teste 2: Verifica se o método helper isVeterinario() funciona corretamente.
     */
    public function test_verifica_se_usuario_e_veterinario(): void
    {
        // Cenário A: Usuário é Veterinário
        $vet = new User(['perfil' => 'Veterinário']);
        $this->assertTrue($vet->isVeterinario(), 'Erro: Perfil Veterinário não foi reconhecido');
        
        // Cenário B: Usuário é Admin
        $admin = new User(['perfil' => 'Admin']);
        $this->assertFalse($admin->isVeterinario(), 'Erro: Admin não deve ser reconhecido como Veterinário');
    }

    /**
     * Teste 3: Verifica a lógica complexa do "Último Atendimento".
     * O método deve retornar o agendamento CONCLUÍDO mais recente,
     * ignorando agendamentos futuros ou cancelados.
     */
    public function test_logica_ultimo_atendimento_do_pet(): void
    {
        // 1. Preparação (Arrange)
        // Criamos os dados necessários no banco em memória
        $user = User::factory()->create(['perfil' => 'Cliente']);
        
        $cliente = Cliente::create([
            'user_id' => $user->id,
            'nome_completo' => 'Teste Unitário',
            'cpf' => '00000000000'
        ]);
        
        $pet = Pet::create([
            'cliente_id' => $cliente->id,
            'nome' => 'RexUnit',
            'especie' => 'Cachorro'
        ]);

        // Agendamento Antigo Concluído (Alvo esperado)
        Agendamento::create([
            'pet_id' => $pet->id,
            'veterinario_id' => $user->id,
            'data_hora' => now()->subDays(10),
            'tipo' => 'Vacina',
            'status' => 'Concluído'
        ]);

        // Agendamento Futuro Agendado (Deve ser ignorado)
        Agendamento::create([
            'pet_id' => $pet->id,
            'veterinario_id' => $user->id,
            'data_hora' => now()->addDays(5),
            'tipo' => 'Cirurgia',
            'status' => 'Agendado'
        ]);

        // 2. Ação (Act)
        // Recarrega o pet para pegar a relação dinâmica
        $petAtualizado = Pet::with('ultimoAtendimento')->find($pet->id);
        $ultimo = $petAtualizado->ultimoAtendimento;

        // 3. Verificação (Assert)
        $this->assertNotNull($ultimo, 'Deveria existir um último atendimento');
        $this->assertEquals('Vacina', $ultimo->tipo, 'O sistema pegou o agendamento errado (futuro) em vez do concluído.');
    }
}