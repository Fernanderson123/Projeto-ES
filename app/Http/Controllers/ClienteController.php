<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::orderBy('nome_completo', 'asc')->get();
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Apenas mostra a view do formulário de cadastro
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validação dos dados
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

        // 2. Cria o cliente no banco
        Cliente::create($dadosValidados);

        // 3. Redireciona de volta para a listagem com mensagem de sucesso
        return redirect()->route('clientes.index')
                         ->with('success', 'Cliente cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        // (Não vamos usar por enquanto)
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        // (Próximo passo)
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        // (Próximo passo)
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        // (Próximo passo)
    }
}