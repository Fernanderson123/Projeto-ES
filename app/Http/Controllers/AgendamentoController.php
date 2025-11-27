<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AgendamentoController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isCliente()) {
            $meusPetsIds = $user->cliente ? $user->cliente->pets->pluck('id') : [];
            
            $agendamentos = Agendamento::with(['pet', 'veterinario'])
                ->whereIn('pet_id', $meusPetsIds)
                ->orderBy('data_hora', 'desc')
                ->get();
        } else {
            $agendamentos = Agendamento::with(['pet.cliente', 'veterinario'])
                ->orderBy('data_hora', 'desc')
                ->get();
        }

        return view('agendamentos.index', compact('agendamentos'));
    }

    public function create()
    {
        if (Auth::user()->isCliente()) {
            $pets = Auth::user()->cliente ? Auth::user()->cliente->pets : collect();
        } else {
            $pets = Pet::with('cliente')->orderBy('nome')->get();
        }
        
        $veterinarios = User::where('perfil', 'Veterinário')->get();
        
        return view('agendamentos.create', compact('pets', 'veterinarios'));
    }

    /**
     * Salva com TODAS as Regras de Negócio:
     * 1. Horário Comercial (08-22h).
     * 2. Duração dinâmica (Cirurgia 5h vs Consulta 1h).
     * 3. Anti-Colisão de Veterinário.
     * 4. Anti-Colisão de Pet (NOVO).
     */
    public function store(Request $request)
    {
        $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'data_hora' => 'required|date|after:now',
            'tipo' => 'required',
        ]);

        // --- PREPARAÇÃO DOS DADOS ---
        $inicio = Carbon::parse($request->data_hora);
        $duracaoHoras = ($request->tipo === 'Cirurgia') ? 5 : 1;
        $fim = $inicio->copy()->addHours($duracaoHoras);

        // --- REGRA 1: HORÁRIO DE FUNCIONAMENTO ---
        if ($inicio->hour < 8) {
            return back()->withInput()->withErrors(['data_hora' => 'A clínica abre apenas às 08:00.']);
        }

        $fechamento = $inicio->copy()->setTime(22, 0, 0);
        if ($fim->gt($fechamento)) {
            return back()->withInput()->withErrors([
                'data_hora' => "O procedimento termina após às 22:00. Para {$request->tipo}, a duração é de {$duracaoHoras}h."
            ]);
        }

        // --- REGRA 2: DISPONIBILIDADE DO VETERINÁRIO ---
        if ($request->veterinario_id) {
            $conflitosVet = Agendamento::where('veterinario_id', $request->veterinario_id)
                ->whereDate('data_hora', $inicio->toDateString())
                ->where('status', '!=', 'Cancelado') // Ignora cancelados
                ->get();

            foreach ($conflitosVet as $agenda) {
                $inicioExistente = $agenda->data_hora;
                $duracaoExistente = ($agenda->tipo === 'Cirurgia') ? 5 : 1;
                $fimExistente = $inicioExistente->copy()->addHours($duracaoExistente);

                // Lógica de Interseção: (InicioA < FimB) E (FimA > InicioB)
                if ($inicio->lessThan($fimExistente) && $fim->greaterThan($inicioExistente)) {
                    return back()->withInput()->withErrors([
                        'data_hora' => "O veterinário selecionado já está ocupado neste horário ({$inicioExistente->format('H:i')} - {$fimExistente->format('H:i')})."
                    ]);
                }
            }
        }

        // --- REGRA 3: DISPONIBILIDADE DO PET (NOVO) ---
        // O mesmo pet não pode estar em dois lugares ao mesmo tempo
        $conflitosPet = Agendamento::where('pet_id', $request->pet_id)
            ->whereDate('data_hora', $inicio->toDateString())
            ->where('status', '!=', 'Cancelado')
            ->get();

        foreach ($conflitosPet as $agenda) {
            $inicioExistente = $agenda->data_hora;
            $duracaoExistente = ($agenda->tipo === 'Cirurgia') ? 5 : 1;
            $fimExistente = $inicioExistente->copy()->addHours($duracaoExistente);

            if ($inicio->lessThan($fimExistente) && $fim->greaterThan($inicioExistente)) {
                return back()->withInput()->withErrors([
                    'data_hora' => "Este Pet já possui um agendamento conflitante neste horário ({$inicioExistente->format('H:i')} - {$fimExistente->format('H:i')})."
                ]);
            }
        }

        // --- SUCESSO ---
        Agendamento::create([
            'pet_id' => $request->pet_id,
            'veterinario_id' => $request->veterinario_id,
            'data_hora' => $request->data_hora,
            'tipo' => $request->tipo,
            'observacoes' => $request->observacoes,
            'status' => 'Agendado'
        ]);

        return redirect()->route('agendamentos.index')->with('success', 'Agendamento realizado com sucesso!');
    }

    public function finalizar(Agendamento $agendamento)
    {
        if (Auth::user()->isCliente()) abort(403);
        
        if ($agendamento->status !== 'Agendado') {
            return redirect()->route('agendamentos.index')->with('error', 'Agendamento inválido para finalização.');
        }

        return view('prontuario.create', compact('agendamento'));
    }

    public function storeFinalizacao(Request $request, Agendamento $agendamento)
    {
        if (Auth::user()->isCliente()) abort(403);

        $request->validate([
            'sintomas' => 'required',
            'diagnostico' => 'required',
            'tratamento' => 'required',
        ]);

        \App\Models\Prontuario::create([
            'agendamento_id' => $agendamento->id,
            'pet_id' => $agendamento->pet_id,
            'veterinario_id' => Auth::id(),
            'data_atendimento' => now(),
            'sintomas' => $request->sintomas,
            'diagnostico' => $request->diagnostico,
            'tratamento' => $request->tratamento,
            'observacoes' => $request->observacoes,
        ]);

        $agendamento->update(['status' => 'Concluído']);

        return redirect()->route('agendamentos.index')->with('success', 'Consulta concluída e Prontuário salvo!');
    }

    public function destroy(string $id)
    {
        $agendamento = Agendamento::findOrFail($id);

        if (Auth::user()->isCliente()) {
            if (!$agendamento->pet || $agendamento->pet->cliente_id !== Auth::user()->cliente->id) {
                abort(403);
            }
        }

        $agendamento->update(['status' => 'Cancelado']);

        return redirect()->route('agendamentos.index')->with('success', 'Agendamento cancelado.');
    }

    
}