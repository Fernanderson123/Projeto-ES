<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Lista todos os clientes.
     */
    public function index()
    {
        $clientes = Cliente::orderBy('nome_completo', 'asc')->get();
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Mostra o formulário de cadastro.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Salva o novo cliente no banco.
     */
    public function store(Request $request)
    {
        // 1. Validação
        $dadosValidados = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:clientes',
            'email' => 'nullable|email|max:255|unique:clientes,email',
            'telefone' => 'nullable|string|max:20',
            'endereco_cep' => 'nullable|string|max:9',
            'endereco_rua' => 'nullable|string|max:255',
            'endereco_numero' => 'nullable|string|max:20',
            'endereco_bairro' => 'nullable|string|max:100',
            'endereco_cidade' => 'nullable|string|max:100',
            'endereco_estado' => 'nullable|string|max:2',
        ]);

        // 2. Criação
        Cliente::create($dadosValidados);

        // 3. Redirecionamento
        return redirect()->route('clientes.index')
                         ->with('success', 'Cliente cadastrado com sucesso!');
    }

    /**
     * Mostra o formulário de edição.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Atualiza os dados do cliente.
     */
    public function update(Request $request, Cliente $cliente)
    {
        // 1. Validação (ignora o ID atual para permitir manter o mesmo CPF/Email)
        $dadosValidados = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:clientes,cpf,' . $cliente->id,
            'email' => 'nullable|email|max:255|unique:clientes,email,' . $cliente->id,
            'telefone' => 'nullable|string|max:20',
            'endereco_cep' => 'nullable|string|max:9',
            'endereco_rua' => 'nullable|string|max:255',
            'endereco_numero' => 'nullable|string|max:20',
            'endereco_bairro' => 'nullable|string|max:100',
            'endereco_cidade' => 'nullable|string|max:100',
            'endereco_estado' => 'nullable|string|max:2',
        ]);

        // 2. Atualização
        $cliente->update($dadosValidados);

        // 3. Redirecionamento
        return redirect()->route('clientes.index')
                         ->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove o cliente.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')
                         ->with('success', 'Cliente excluído com sucesso!');
    }
}