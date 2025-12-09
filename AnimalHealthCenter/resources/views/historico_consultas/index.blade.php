<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meu Histórico - Animal Health Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        /* Design System Padronizado */
        body { background-color: #fcfaf6; font-family: 'Georgia', serif; }
        
        /* Títulos */
        .page-title {
            font-family: sans-serif;
            font-size: 2rem;
            margin-top: 3rem;
            margin-bottom: 1.5rem;
            color: #1a1a1a;
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
            font-family: sans-serif;
            font-weight: bold;
            font-size: 0.95rem;
            color: #1a1a1a;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 1rem;
        }
        .table td {
            vertical-align: middle;
            padding: 1rem 0.5rem;
            font-family: sans-serif;
            color: #444;
            font-size: 0.95rem;
            border-bottom: 1px solid #f9f9f9;
        }

        /* Navbar */
        .navbar-brand { font-family: Georgia, serif; font-size: 1.5rem; color: #1a1a1a !important; }
        .btn-back { border: 1px solid #dee2e6; background: white; color: #333; border-radius: 50px; padding: 5px 20px; text-decoration: none; font-family: sans-serif; font-size: 0.9rem; }
        .btn-back:hover { background: #f8f9fa; color: #000; }
        
        /* Botão Detalhes */
        .btn-details {
            background-color: #f3f0ff; 
            color: #a78bfa; 
            border: none;
            width: 35px; height: 35px;
            border-radius: 50%;
            display: inline-flex; align-items: center; justify-content: center;
            transition: all 0.2s;
        }
        .btn-details:hover { background-color: #a78bfa; color: white; }
    </style>
</head>
<body>

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
    <div class="container">
        <h2 class="page-title">Histórico de Consultas</h2>

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="list-card">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Pet</th>
                                <th>Motivo da Consulta</th>
                                <th>Veterinário</th>
                                <th class="text-end">Detalhes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($consultas as $item)
                                <tr>
                                    <td class="fw-bold text-dark">
                                        {{ $item->data_atendimento->format('d/m/Y') }}
                                    </td>
                                    
                                    <td>
                                        <span class="fw-bold">{{ $item->pet->nome }}</span>
                                        <span class="text-muted small">({{ $item->pet->especie }})</span>
                                    </td>
                                    
                                    <td>
                                        {{ Str::limit($item->sintomas, 50) }}
                                    </td>
                                    
                                    <td class="text-muted small">
                                        Dr(a). {{ $item->veterinario->name ?? 'Equipe' }}
                                    </td>
                                    
                                    <td class="text-end">
                                        <a href="{{ route('historico.show', $item->id) }}" class="btn-details" title="Ver Detalhes">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5 font-sans">
                                        <i class="bi bi-folder2-open fs-1 d-block mb-3 opacity-25"></i>
                                        Nenhum histórico de consulta encontrado para seus pets.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>