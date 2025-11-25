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
        // Traz agendamentos ordenados por data (mais recentes primeiro)
        $agendamentos = Agendamento::with(['pet.cliente', 'veterinario'])
                                   ->orderBy('data_hora', 'desc')
                                   ->get();
                                   
        return view('agendamentos.index', compact('agendamentos'));
    }

    public function create()
    {
        // Lista todos os pets (com donos) e todos os veterinários
        $pets = Pet::with('cliente')->orderBy('nome', 'asc')->get();
        $veterinarios = User::where('perfil', 'Veterinário')->orderBy('name', 'asc')->get();
        
        return view('agendamentos.create', compact('pets', 'veterinarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'veterinario_id' => 'required|exists:users,id',
            'data_hora' => 'required|date|after:now', // Não pode agendar no passado
            'tipo' => 'required|string',
            'observacoes' => 'nullable|string',
        ]);

        Agendamento::create($request->all());

        return redirect()->route('agendamentos.index')
                         ->with('success', 'Agendamento realizado com sucesso!');
    }

    // Implementaremos edit/update/destroy na próxima etapa
}