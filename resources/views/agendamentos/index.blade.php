<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Agendamentos - Animal Health Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        body { 
            background-color: #fcfaf6; /* Fundo Bege */
            font-family: 'Georgia', serif; 
        }
        
        /* Títulos */
        .page-title {
            font-family: sans-serif;
            font-size: 2rem;
            margin-top: 3rem;
            margin-bottom: 1.5rem;
            color: #000;
            margin-left: 1rem;
        }

        /* Card da Lista */
        .list-card {
            background-color: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            border: none;
        }
        
        /* Tabela */
        .table th {
            border-top: none;
            border-bottom: none;
            font-family: sans-serif;
            font-weight: bold;
            font-size: 0.95rem;
            color: #1a1a1a;
            padding-bottom: 1rem;
        }
        .table td {
            vertical-align: middle;
            border-bottom: none;
            padding: 1rem 0.5rem;
            font-family: sans-serif;
            color: #333;
            font-size: 0.95rem;
        }
        
        /* Botão Novo */
        .btn-new {
            background-color: #a78bfa;
            color: white;
            border-radius: 50px;
            padding: 8px 25px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background 0.2s;
            font-family: sans-serif;
            font-weight: bold;
            border: 1px solid #a78bfa;
        }
        .btn-new:hover { background-color: #9061f9; color: white; }

        /* Badges de Status */
        .badge-status { padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .status-agendado { background-color: #e0f2fe; color: #0284c7; } /* Azul */
        .status-concluido { background-color: #dcfce7; color: #16a34a; } /* Verde */
        .status-cancelado { background-color: #fee2e2; color: #dc2626; } /* Vermelho */

        /* Header */
        .navbar-brand { color: #1a1a1a !important; }
    </style>
</head>
<body>

    <!-- Header Padronizado -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid mx-5">
            <a class="navbar-brand" href="{{ route('dashboard') }}" style="font-family: Georgia, serif; font-size: 1.5rem;">
                Animal Health Center 🐾
            </a>
            <div class="d-flex align-items-center">
                <div class="text-end me-3">
                    <a class="small text-muted text-decoration-none" href="{{ route('profile.edit') }}">
                        Bem vindo(a) <strong class="text-dark">{{ Auth::user()->name }}</strong>
                    </a>
                    <div class="small text-muted">Perfil: <strong class="text-dark">{{ Auth::user()->perfil }}</strong></div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Sair</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Conteúdo -->
    <div class="container">
        
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="page-title">Agenda</h2>
            <a href="{{ route('agendamentos.create') }}" class="btn-new mt-4 me-2">
                + Novo Agendamento
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 rounded-3 mb-4 mx-3">{{ session('success') }}</div>
        @endif

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="list-card mx-2">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="width: 20%;">Data/Hora</th>
                                <th style="width: 20%;">Paciente (Pet)</th>
                                <th style="width: 20%;">Veterinário</th>
                                <th style="width: 15%;">Tipo</th>
                                <th style="width: 15%;">Status</th>
                                <th class="text-end" style="width: 10%;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($agendamentos as $agenda)
                                <tr>
                                    <!-- Data -->
                                    <td class="fw-bold">
                                        {{ $agenda->data_hora->format('d/m/Y') }} 
                                        <span class="text-muted fw-normal ms-1">{{ $agenda->data_hora->format('H:i') }}</span>
                                    </td>
                                    
                                    <!-- Paciente -->
                                    <td>
                                        <div class="fw-medium">{{ $agenda->pet->nome }}</div>
                                        <div class="small text-muted">{{ $agenda->pet->cliente->nome_completo }}</div>
                                    </td>
                                    
                                    <!-- Veterinário -->
                                    <td>{{ $agenda->veterinario->name ?? 'Não atribuído' }}</td>
                                    
                                    <!-- Tipo -->
                                    <td>{{ $agenda->tipo }}</td>
                                    
                                    <!-- Status -->
                                    <td>
                                        @php
                                            $statusClass = match($agenda->status) {
                                                'Concluído' => 'status-concluido',
                                                'Cancelado' => 'status-cancelado',
                                                default => 'status-agendado',
                                            };
                                        @endphp
                                        <span class="badge-status {{ $statusClass }}">{{ $agenda->status }}</span>
                                    </td>
                                    
                                    <!-- Ações -->
                                    <td class="text-end">
                                        
                                        <!-- 1. Botão Check (Concluir/Prontuário) -->
                                        <!-- Só aparece se estiver Agendado -->
                                        @if($agenda->status === 'Agendado')
                                            <a href="{{ route('prontuario.create', ['agendamento_id' => $agenda->id]) }}" class="btn btn-link p-0 border-0 me-2 text-decoration-none" title="Finalizar e Gerar Prontuário">
                                                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                            </a>
                                        @endif

                                        <!-- 2. Botão Editar -->
                                        <a href="{{ route('agendamentos.edit', $agenda->id) }}" class="btn btn-link p-0 border-0 me-2 text-decoration-none" title="Editar">
                                            <i class="bi bi-pencil-square text-dark fs-5"></i>
                                        </a>

                                        <!-- 3. Botão Excluir -->
                                        <form action="{{ route('agendamentos.destroy', $agenda->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Cancelar este agendamento?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link p-0 border-0 text-decoration-none" title="Excluir">
                                                <i class="bi bi-trash3 text-danger fs-5"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">
                                        Nenhum agendamento encontrado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>