<?php

namespace App\Http\Controllers;

use App\Models\Prontuario;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProntuarioController extends Controller
{
    /**
     * Lista todos os prontuários.
     */
    public function index()
    {
        $prontuarios = Prontuario::with(['pet.cliente', 'veterinario'])
                                 ->orderBy('data_atendimento', 'desc')
                                 ->get();
                                 
        return view('prontuario.index', compact('prontuarios'));
    }

    /**
     * Mostra o formulário de cadastro.
     */
    /**
     * Mostra o formulário de novo atendimento.
     * AGORA EXIGE UM AGENDAMENTO PRÉVIO.
     */
    public function create(Request $request)
    {
        // Verifica se veio um ID de agendamento na URL (ex: ?agendamento_id=1)
        $agendamentoId = $request->query('agendamento_id');

        if (!$agendamentoId) {
            return redirect()->route('agendamentos.index')
                             ->with('error', 'Para criar um prontuário, inicie o atendimento pela Agenda.');
        }

        // Busca o agendamento para preencher os dados
        $agendamento = \App\Models\Agendamento::with('pet.cliente')->findOrFail($agendamentoId);

        // Se o agendamento já estiver concluído ou cancelado, avisa
        if ($agendamento->status !== 'Agendado' && $agendamento->status !== 'Em Andamento') {
             // Opcional: Permitir editar se já existir, mas aqui vamos bloquear novo
        }

        // Prepara os dados para a view
        // Note que não precisamos mais carregar todos os pets, pois o pet vem do agendamento
        return view('prontuario.create', compact('agendamento'));
    }

    /**
     * Salva o prontuário.
     */
    public function store(Request $request)
    {
        $request->validate([
            'agendamento_id' => 'required|exists:agendamentos,id', // Valida o agendamento
            'pet_id' => 'required|exists:pets,id',
            'data_atendimento' => 'required|date',
            'sintomas' => 'required|string',
            'diagnostico' => 'nullable|string',
            'tratamento' => 'nullable|string',
            'observacoes' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['veterinario_id'] = Auth::id();

        Prontuario::create($data);

        // ATUALIZA O STATUS DO AGENDAMENTO PARA CONCLUÍDO
        $agendamento = \App\Models\Agendamento::find($request->agendamento_id);
        $agendamento->status = 'Concluído';
        if (!$agendamento->veterinario_id) {
            $agendamento->veterinario_id = Auth::id();
        }
        $agendamento->save();

        return redirect()->route('prontuario.index')
                         ->with('success', 'Atendimento finalizado e prontuário salvo!');
    }
    
    /**
     * Mostra o formulário de edição.
     */
    public function edit(Prontuario $prontuario)
    {
        $pets = Pet::with('cliente')->orderBy('nome', 'asc')->get();
        return view('prontuario.edit', compact('prontuario', 'pets'));
    }

    /**
     * Atualiza o prontuário.
     */
    public function update(Request $request, Prontuario $prontuario)
    {
        $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'data_atendimento' => 'required|date',
            'sintomas' => 'required|string',
        ]);

        $prontuario->update($request->all());

        return redirect()->route('prontuario.index')
                         ->with('success', 'Prontuário atualizado com sucesso!');
    }

    /**
     * Remove o registro.
     */
    public function destroy(Prontuario $prontuario)
    {
        $prontuario->delete();
        return redirect()->route('prontuario.index')
                         ->with('success', 'Registro removido do histórico.');
    }
}