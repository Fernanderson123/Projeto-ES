<?php

namespace App\Http\Controllers;

use App\Models\Prontuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoricoController extends Controller
{
    /**
     * Página exclusiva de listagem para o CLIENTE.
     */
    public function index()
    {
        $user = Auth::user();

        // Segurança extra: garante que é cliente
        if (!$user->isCliente()) {
            return redirect()->route('dashboard');
        }

        // Busca apenas os prontuários dos pets deste cliente
        // Garante que o relacionamento 'pets' existe antes de buscar
        if ($user->cliente) {
            $petsIds = $user->cliente->pets->pluck('id');
        } else {
            $petsIds = [];
        }
        
        $consultas = Prontuario::with(['pet', 'veterinario'])
                               ->whereIn('pet_id', $petsIds)
                               ->orderBy('data_atendimento', 'desc')
                               ->get();

        return view('historico.index', compact('consultas'));
    }

    /**
     * Página exclusiva de detalhes (apenas leitura).
     */
    public function show($id)
    {
        $user = Auth::user();
        $consulta = Prontuario::with(['pet', 'veterinario'])->findOrFail($id);

        // Segurança: Verifica se o pet pertence ao cliente logado
        if ($user->cliente && $consulta->pet->cliente_id !== $user->cliente->id) {
            abort(403, 'Acesso negado a este histórico.');
        }

        return view('historico.show', compact('consulta'));
    }
}