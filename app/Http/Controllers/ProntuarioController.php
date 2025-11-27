<?php

namespace App\Http\Controllers;

use App\Models\Prontuario;
use App\Models\Agendamento;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProntuarioController extends Controller
{
    public function index()
    {
        $prontuarios = Prontuario::with(['pet.cliente', 'veterinario'])
                                 ->orderBy('data_atendimento', 'desc')
                                 ->get();
        return view('prontuario.index', compact('prontuarios'));
    }

    /**
     * Mostra o formulário. AGORA EXIGE UM AGENDAMENTO NA URL.
     */
    public function create(Request $request)
    {
        $agendamentoId = $request->query('agendamento_id');

        // Regra 1: Não permite criar prontuário solto
        if (!$agendamentoId) {
            return redirect()->route('agendamentos.index')
                             ->with('error', 'Inicie o atendimento pela Agenda para criar um prontuário.');
        }

        $agendamento = Agendamento::with(['pet.cliente'])->findOrFail($agendamentoId);

        return view('prontuario.create', compact('agendamento'));
    }

    /**
     * Salva o prontuário e Finaliza o Agendamento.
     */
    public function store(Request $request)
    {
        $request->validate([
            'agendamento_id' => 'required|exists:agendamentos,id',
            'pet_id' => 'required|exists:pets,id',
            'data_atendimento' => 'required|date',
            'sintomas' => 'required|string',
            'diagnostico' => 'nullable|string',
            'tratamento' => 'nullable|string',
            'observacoes' => 'nullable|string',
        ]);

        // 1. Cria o Prontuário
        $data = $request->all();
        $data['veterinario_id'] = Auth::id();
        Prontuario::create($data);

        // 2. Atualiza o Agendamento para CONCLUÍDO
        // (Isso aciona a atualização da "Última Ação" na lista de Pets)
        $agendamento = Agendamento::find($request->agendamento_id);
        $agendamento->status = 'Concluído';
        
        // Garante que o veterinário logado fique responsável se não houver um definido
        if (!$agendamento->veterinario_id) {
            $agendamento->veterinario_id = Auth::id();
        }
        $agendamento->save();

        return redirect()->route('agendamentos.index')
                         ->with('success', 'Consulta finalizada e prontuário salvo com sucesso!');
    }

    public function edit(Prontuario $prontuario)
    {
        // Para edição, carregamos todos os pets caso precise corrigir o vínculo
        $pets = Pet::with('cliente')->orderBy('nome', 'asc')->get();
        return view('prontuario.edit', compact('prontuario', 'pets'));
    }

    public function update(Request $request, Prontuario $prontuario)
    {
        $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'data_atendimento' => 'required|date',
            'sintomas' => 'required|string',
        ]);

        $prontuario->update($request->all());

        return redirect()->route('prontuario.index')->with('success', 'Prontuário atualizado!');
    }

    public function destroy(Prontuario $prontuario)
    {
        $prontuario->delete();
        return redirect()->route('prontuario.index')->with('success', 'Registro removido.');
    }
}