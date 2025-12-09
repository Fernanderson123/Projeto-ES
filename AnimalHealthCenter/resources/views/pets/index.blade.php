<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pets - Animal Health Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        body { background-color: #fcfaf6; font-family: 'Georgia', serif; }
        .page-title { font-family: sans-serif; font-size: 2rem; margin-top: 3rem; margin-bottom: 1.5rem; color: #000; margin-left: 1rem; }
        .list-card { background-color: white; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.02); border: none; }
        .table th { border-top: none; border-bottom: none; font-family: sans-serif; font-weight: bold; font-size: 0.95rem; color: #1a1a1a; padding-bottom: 1rem; }
        .table td { vertical-align: middle; border-bottom: none; padding: 1rem 0.5rem; font-family: sans-serif; color: #333; font-size: 0.95rem; }
        .action-icon { color: #666; font-size: 1.25rem; margin-left: 15px; cursor: pointer; transition: color 0.2s; text-decoration: none; }
        .action-icon:hover { color: #000; }
        .btn-new { background-color: #a78bfa; color: white; border-radius: 50px; padding: 8px 25px; text-decoration: none; font-size: 0.9rem; transition: background 0.2s; font-family: sans-serif; font-weight: 500; }
        .btn-new:hover { background-color: #9061f9; color: white; }
        .navbar-brand { color: #1a1a1a !important; }
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
        
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="page-title">Pets</h2>
            <a href="{{ route('pets.create') }}" class="btn-new mt-4 me-2">
                + Novo Pet
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
                                <th style="width: 25%;">Nome pet</th>
                                <th style="width: 20%;">Espécie/Raça</th>
                                <th style="width: 25%;">Dono</th>
                                <th class="text-end" style="width: 15%;">Ações</th>
                                <th class="text-end" style="width: 15%;">Última Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pets as $pet)
                                <tr>
                                    <td class="fw-medium">{{ $pet->nome }}</td>
                                    <td class="text-muted small">{{ $pet->especie }} - {{ $pet->raca ?? 'SRD' }}</td>
                                    
                                    <td>
                                        <a href="{{ route('clientes.edit', $pet->cliente_id) }}" class="text-dark text-decoration-none">
                                            {{ $pet->cliente->nome_completo }}
                                        </a>
                                    </td>

                                    <td class="text-end">
                                        <form action="{{ route('pets.destroy', $pet->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Remover este pet?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link p-0 border-0" title="Excluir">
                                                <i class="bi bi-trash3 action-icon"></i>
                                            </button>
                                        </form>

                                        <a href="{{ route('pets.edit', $pet->id) }}" title="Editar">
                                            <i class="bi bi-pencil-square action-icon"></i>
                                        </a>
                                    </td>

                                    <!-- LÓGICA CORRIGIDA AQUI -->
                                    <td class="text-end fw-bold">
                                        @if($pet->ultimoAtendimento)
                                            <span class="text-success">{{ $pet->ultimoAtendimento->tipo }}</span>
                                            <br>
                                            <small class="text-muted fw-normal" style="font-size: 0.75rem;">
                                                {{ $pet->ultimoAtendimento->data_hora->format('d/m/Y') }}
                                            </small>
                                        @else
                                            <span class="text-muted fw-normal small">--</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">
                                        Nenhum pet cadastrado.
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