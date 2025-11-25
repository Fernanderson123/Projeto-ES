<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Cliente; // Importante para listar os donos
use Illuminate\Http\Request;

class PetController extends Controller
{
    /**
     * Lista todos os pets.
     */
    public function index()
    {
        // Traz os pets junto com os dados do cliente (dono) para otimizar
        $pets = Pet::with('cliente')->orderBy('nome', 'asc')->get();
        return view('pets.index', compact('pets'));
    }

    /**
     * Mostra o formulário de cadastro.
     */
    public function create()
    {
        // Precisamos da lista de clientes para selecionar o dono
        $clientes = Cliente::orderBy('nome_completo', 'asc')->get();
        return view('pets.create', compact('clientes'));
    }

    /**
     * Salva o novo pet.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'nome' => 'required|string|max:255',
            'especie' => 'required|string|max:50',
            'raca' => 'nullable|string|max:50',
            'peso' => 'nullable|numeric|min:0',
            'data_nascimento' => 'nullable|date',
        ]);

        Pet::create($request->all());

        return redirect()->route('pets.index')
                         ->with('success', 'Pet cadastrado com sucesso!');
    }

    /**
     * Mostra um pet específico (pode ser usado para o prontuário futuramente).
     */
    public function show(Pet $pet)
    {
        // return view('pets.show', compact('pet'));
    }

    /**
     * Mostra formulário de edição.
     */
    public function edit(Pet $pet)
    {
        $clientes = Cliente::orderBy('nome_completo', 'asc')->get();
        return view('pets.edit', compact('pet', 'clientes'));
    }

    /**
     * Atualiza o pet.
     */
    public function update(Request $request, Pet $pet)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'nome' => 'required|string|max:255',
            'especie' => 'required|string|max:50',
            'raca' => 'nullable|string|max:50',
            'peso' => 'nullable|numeric|min:0',
            'data_nascimento' => 'nullable|date',
        ]);

        $pet->update($request->all());

        return redirect()->route('pets.index')
                         ->with('success', 'Dados do pet atualizados!');
    }

    /**
     * Remove o pet.
     */
    public function destroy(Pet $pet)
    {
        $pet->delete();
        return redirect()->route('pets.index')
                         ->with('success', 'Pet removido com sucesso!');
    }
}