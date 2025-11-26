<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatórios - Animal Health Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #fcfaf6; font-family: 'Georgia', serif; }
        
        .page-title { font-family: sans-serif; font-size: 2rem; margin-top: 2rem; color: #1a1a1a; }
        .section-title { font-family: sans-serif; font-size: 1.2rem; font-weight: bold; color: #4a4a4a; margin-bottom: 1rem; }

        /* Cards de Métricas */
        .stat-card {
            background: white; border: none; border-radius: 12px; padding: 1.5rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02); transition: transform 0.2s;
            height: 100%;
        }
        .stat-card:hover { transform: translateY(-2px); }
        .stat-number { font-family: sans-serif; font-size: 2.5rem; font-weight: bold; color: #a78bfa; }
        .stat-label { font-family: sans-serif; font-size: 0.9rem; color: #666; text-transform: uppercase; letter-spacing: 1px; }
        
        /* Tabelas */
        .content-card { background: white; border-radius: 12px; padding: 1.5rem; border: none; box-shadow: 0 2px 5px rgba(0,0,0,0.02); }
        .table th { font-family: sans-serif; font-size: 0.85rem; text-transform: uppercase; color: #666; border-bottom: 1px solid #eee; }
        .table td { font-family: sans-serif; vertical-align: middle; color: #333; }

        .navbar-brand { color: #1a1a1a !important; }
        
        /* Badge de Estoque Baixo */
        .badge-low-stock { background-color: #fee2e2; color: #dc2626; padding: 5px 10px; border-radius: 6px; font-weight: bold; font-size: 0.8rem; font-family: sans-serif; }
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

    <div class="container mb-5">
        <h2 class="page-title mb-4">Relatórios e Métricas</h2>

        <!-- Linha 1: Cards Principais -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number">{{ $agendamentosHoje }}</div>
                    <div class="stat-label">Agendamentos Hoje</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number">{{ $totalClientes }}</div>
                    <div class="stat-label">Clientes Totais</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number">{{ $totalPets }}</div>
                    <div class="stat-label">Pets Cadastrados</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number">{{ $totalProdutos }}</div>
                    <div class="stat-label">Produtos em Estoque</div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Coluna Esquerda: Alertas de Estoque -->
            <div class="col-md-6">
                <h3 class="section-title text-danger"><i class="bi bi-exclamation-triangle me-2"></i> Estoque Baixo</h3>
                <div class="content-card">
                    <table class="table table-borderless mb-0">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th class="text-end">Qtd. Atual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produtosBaixoEstoque as $prod)
                                <tr>
                                    <td>{{ $prod->nome }}</td>
                                    <td class="text-end">
                                        <span class="badge-low-stock">{{ $prod->estoque }} {{ $prod->unidade }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="2" class="text-center text-muted">Nenhum produto com estoque crítico.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Coluna Direita: Últimos Atendimentos -->
            <div class="col-md-6">
                <h3 class="section-title text-success"><i class="bi bi-check-circle me-2"></i> Últimos Atendimentos Concluídos</h3>
                <div class="content-card">
                    <table class="table table-borderless mb-0">
                        <thead>
                            <tr>
                                <th>Pet</th>
                                <th>Veterinário</th>
                                <th class="text-end">Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ultimosAtendimentos as $atendimento)
                                <tr>
                                    <td class="fw-bold">{{ $atendimento->pet->nome }}</td>
                                    <td class="small">{{ $atendimento->veterinario->name ?? '--' }}</td>
                                    <td class="text-end small text-muted">{{ $atendimento->updated_at->format('d/m H:i') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted">Nenhum atendimento recente.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>