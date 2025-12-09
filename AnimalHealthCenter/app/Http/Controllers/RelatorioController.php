<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Pet;
use App\Models\Agendamento;
use App\Models\Produto;
use App\Models\User;

class RelatorioController extends Controller
{
    /**
     * Exibe o dashboard de relatórios e métricas.
     */
    public function index()
    {
        // 1. Totais Gerais
        $totalClientes = Cliente::count();
        $totalPets = Pet::count();
        $totalProdutos = Produto::count();
        $totalVeterinarios = User::where('perfil', 'Veterinário')->count();

        // 2. Agendamentos
        $agendamentosHoje = Agendamento::whereDate('data_hora', today())->count();
        $agendamentosMes = Agendamento::whereMonth('data_hora', now()->month)
                                      ->whereYear('data_hora', now()->year)
                                      ->count();
        
        // 3. Produtos com Stock Baixo (Alerta)
        $produtosBaixoEstoque = Produto::where('estoque', '<', 10)->get();

        // 4. Últimos Atendimentos Concluídos
        $ultimosAtendimentos = Agendamento::with(['pet', 'veterinario'])
                                          ->where('status', 'Concluído')
                                          ->latest('updated_at')
                                          ->take(5)
                                          ->get();

        return view('relatorios.index', compact(
            'totalClientes', 
            'totalPets', 
            'totalProdutos', 
            'totalVeterinarios',
            'agendamentosHoje',
            'agendamentosMes',
            'produtosBaixoEstoque',
            'ultimosAtendimentos'
        ));
    }
}