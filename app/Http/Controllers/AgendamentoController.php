<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    public function index()
    {
        $agendamentos = Agendamento::with(['pet.cliente', 'veterinario'])
                                   ->orderBy('data_hora', 'desc')
                                   ->get();
                                   
        return view('agendamentos.index', compact('agendamentos'));
    }

    public function create()
    {
        $pets = Pet::with('cliente')->orderBy('nome', 'asc')->get();
        $veterinarios = User::where('perfil', 'Veterinário')->orderBy('name', 'asc')->get();
        
        return view('agendamentos.create', compact('pets', 'veterinarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'veterinario_id' => 'required|exists:users,id',
            'data_hora' => 'required|date',
            'tipo' => 'required|string',
            'observacoes' => 'nullable|string',
        ]);

        Agendamento::create($request->all());

        return redirect()->route('agendamentos.index')
                         ->with('success', 'Agendamento realizado com sucesso!');
    }

    // --- MÉTODOS NOVOS ABAIXO ---

    /**
     * Mostra o formulário de edição.
     */
    public function edit(Agendamento $agendamento)
    {
        $pets = Pet::with('cliente')->orderBy('nome', 'asc')->get();
        $veterinarios = User::where('perfil', 'Veterinário')->orderBy('name', 'asc')->get();

        return view('agendamentos.edit', compact('agendamento', 'pets', 'veterinarios'));
    }

    /**
     * Atualiza o agendamento.
     */
    public function update(Request $request, Agendamento $agendamento)
    {
        $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'veterinario_id' => 'required|exists:users,id',
            'data_hora' => 'required|date',
            'tipo' => 'required|string',
            'status' => 'required|string', // Permite editar status manualmente se precisar
            'observacoes' => 'nullable|string',
        ]);

        $agendamento->update($request->all());

        return redirect()->route('agendamentos.index')
                         ->with('success', 'Agendamento atualizado com sucesso!');
    }

    /**
     * Remove o agendamento.
     */
    public function destroy(Agendamento $agendamento)
    {
        $agendamento->delete();
        return redirect()->route('agendamentos.index')
                         ->with('success', 'Agendamento cancelado e removido!');
    }

    /**
     * Marca um agendamento como Concluído (Via botão rápido).
     */
    public function concluir(Agendamento $agendamento)
    {
        $agendamento->status = 'Concluído';
        $agendamento->save();

        return back()->with('success', 'Atendimento concluído! O histórico do pet foi atualizado.');
    }
}