<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    /**
     * Lista os Pets.
     * Admin/Vet: Vê todos.
     * Cliente: Vê apenas os seus.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isCliente()) {
            // Garante que o cliente tem o registro vinculado para evitar erro
            if (!$user->cliente) {
                return redirect()->route('dashboard')->with('error', 'Perfil de cliente não encontrado.');
            }
            // Busca apenas os pets deste cliente
            $pets = $user->cliente->pets; 
        } else {
            // Admin/Vet vê tudo, com os dados do dono (Eager Loading)
            $pets = Pet::with('cliente')->get();
        }

        return view('pets.index', compact('pets'));
    }

    /**
     * Formulário de Criação.
     */
    public function create()
    {
        $user = Auth::user();
        $clientes = [];

        // Se for Admin ou Vet, precisa da lista de donos para escolher
        if (!$user->isCliente()) {
            $clientes = Cliente::orderBy('nome_completo')->get();
        } 
        // Se for Cliente, não precisa de lista (será ele mesmo)

        return view('pets.create', compact('clientes'));
    }

    /**
     * Salvar o Pet no Banco.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Regras de validação comuns
        $rules = [
            'nome' => 'required|string|max:255',
            'especie' => 'required|string', // Ex: Cachorro, Gato
            'raca' => 'nullable|string',
            'peso' => 'nullable|numeric',
            'data_nascimento' => 'nullable|date',
        ];

        // Se NÃO for cliente, o campo 'cliente_id' é obrigatório no formulário
        if (!$user->isCliente()) {
            $rules['cliente_id'] = 'required|exists:clientes,id';
        }

        $dados = $request->validate($rules);

        // INJEÇÃO DE SEGURANÇA:
        // Se for Cliente, forçamos o ID dele, ignorando qualquer input malicioso
        if ($user->isCliente()) {
            $dados['cliente_id'] = $user->cliente->id;
        }

        Pet::create($dados);

        return redirect()->route('pets.index')->with('success', 'Pet cadastrado com sucesso!');
    }

    /**
     * Exibe um Pet específico.
     */
    public function show(Pet $pet)
    {
        $this->authorizePetAccess($pet);
        return view('pets.show', compact('pet'));
    }

    /**
     * Edição.
     */
    public function edit(Pet $pet)
    {
        $this->authorizePetAccess($pet);
        
        // Se for admin, carrega lista de clientes para poder trocar o dono se necessário
        $clientes = Auth::user()->isCliente() ? [] : Cliente::all();

        return view('pets.edit', compact('pet', 'clientes'));
    }

    /**
     * Update.
     */
    public function update(Request $request, Pet $pet)
    {
        $this->authorizePetAccess($pet);

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'especie' => 'required|string',
            'raca' => 'nullable|string',
            'peso' => 'nullable|numeric',
            'data_nascimento' => 'nullable|date',
        ]);

        $pet->update($data);

        return redirect()->route('pets.index')->with('success', 'Dados do pet atualizados!');
    }

    /**
     * Delete.
     */
    public function destroy(Pet $pet)
    {
        $this->authorizePetAccess($pet);
        $pet->delete();
        return redirect()->route('pets.index')->with('success', 'Pet removido com sucesso.');
    }

    /**
     * Helper de Segurança: Verifica se o usuário pode mexer neste pet.
     */
    private function authorizePetAccess(Pet $pet)
    {
        $user = Auth::user();
        if ($user->isCliente() && $pet->cliente_id !== $user->cliente->id) {
            abort(403, 'Você não tem permissão para acessar este pet.');
        }
    }
}