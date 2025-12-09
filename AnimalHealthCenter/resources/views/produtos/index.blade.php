<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Produtos - Animal Health Center</title>
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
        .icon-trash:hover { color: #dc3545; }
        .btn-new { background-color: #1a1a1a; color: white; border-radius: 50px; padding: 8px 25px; text-decoration: none; font-size: 0.9rem; transition: background 0.2s; font-family: sans-serif; font-weight: 500; }
        .btn-new:hover { background-color: #333; color: white; }
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
            <h2 class="page-title">Produtos e Medicamentos</h2>
            <a href="{{ route('produtos.create') }}" class="btn-new mt-4 me-2">+ Novo Produto</a>
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
                                <th style="width: 30%;">Nome</th>
                                <th style="width: 15%;">Estoque</th>
                                <th style="width: 15%;">Unidade</th>
                                <th style="width: 20%;">Preço Venda</th>
                                <th class="text-end" style="width: 20%;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produtos as $prod)
                                <tr>
                                    <td class="fw-medium">{{ $prod->nome }}</td>
                                    
                                    <!-- Alerta visual se estoque baixo -->
                                    <td class="{{ $prod->estoque < 5 ? 'text-danger fw-bold' : '' }}">
                                        {{ $prod->estoque }}
                                    </td>
                                    
                                    <td>{{ $prod->unidade }}</td>
                                    <td>R$ {{ number_format($prod->preco_venda, 2, ',', '.') }}</td>
                                    
                                    <td class="text-end">
                                        <form action="{{ route('produtos.destroy', $prod->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir este produto?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-link p-0 border-0" title="Excluir">
                                                <i class="bi bi-trash3 action-icon icon-trash"></i>
                                            </button>
                                        </form>
                                        <a href="{{ route('produtos.edit', $prod->id) }}" title="Editar">
                                            <i class="bi bi-pencil-square action-icon"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-5">Nenhum produto cadastrado.</td></tr>
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