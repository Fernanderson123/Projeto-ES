<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar - Animal Health Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #fcfaf6;
            font-family: 'Georgia', serif;
        }
        /* Header Estilo Print 1 */
        .header-bar {
            background-color: transparent;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .brand-title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #1a1a1a;
            font-family: 'Georgia', serif;
        }
        .user-info {
            text-align: right;
            font-family: sans-serif;
            font-size: 0.9rem;
            color: #333;
            line-height: 1.4;
        }
        
        /* Títulos e Card */
        .page-title {
            font-family: sans-serif;
            font-size: 2rem;
            margin-top: 2rem;
            margin-bottom: 1.5rem;
            color: #000;
        }
        .list-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        /* Tabela */
        .table th {
            border-top: none;
            border-bottom: none;
            font-family: sans-serif;
            font-weight: bold;
            font-size: 0.95rem;
        }
        .table td {
            vertical-align: middle;
            border-bottom: none;
            padding: 12px 8px;
            font-family: sans-serif;
            color: #1a1a1a;
        }

        /* Badges de Perfil Coloridos */
        .badge-custom { font-size: 0.85rem; font-weight: 500; padding: 5px 10px; border-radius: 4px; color: white; }
        .bg-admin { background-color: #0d6efd; } /* Azul */
        .bg-recep { background-color: #6f42c1; } /* Roxo */
        .bg-vet { background-color: #198754; }   /* Verde */
        .bg-invest { background-color: #fd7e14; } /* Laranja */
        .bg-client { background-color: #6c757d; } /* Cinza */

        /* Ícones de Ação */
        .btn-icon {
            background: none;
            border: none;
            font-size: 1.2rem;
            margin: 0 6px;
            color: #4a4a4a;
            transition: 0.2s;
            display: inline-block; /* Garante alinhamento e remove underline fantasma */
            text-decoration: none;
        }
        .btn-icon:hover { color: #000; }
        
        .icon-edit { color: #333; }
        .icon-ban { color: #d9534f; } /* Desativar */
        .icon-check { color: #198754; } /* Reativar */
        .icon-trash { color: #dc3545; } /* Excluir Definitivo */

        /* Status Text */
        .status-active { font-weight: bold; color: #1a1a1a; }
        .status-inactive { font-weight: bold; color: #dc3545; }
    </style>
</head>
<body>

    <!-- Header Restaurado -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid mx-5">
            <a class="navbar-brand" href="{{ route('dashboard') }}" style="font-family: Georgia, serif; font-size: 1.5rem;">
                Animal Health Center 🐾
            </a>
            <div class="d-flex align-items-center">
                <div class="text-end me-3">
                    <a class="small text-muted" href="{{ route('profile.edit') }}">Bem vindo(a) <strong class="text-dark">{{ Auth::user()->name }}</strong></a>
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
        
        <h2 class="page-title">Gerenciar</h2>

        @if (session('success'))
            <div class="alert alert-success border-0 py-2 mb-3">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger border-0 py-2 mb-3">{{ session('error') }}</div>
        @endif

        <div class="list-card">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 30%;">Nome</th>
                        <th style="width: 20%;">Perfil</th>
                        <th class="text-end" style="width: 25%;">Ações</th>
                        <th class="text-end" style="width: 15%;">Situação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            
                            <!-- Perfil com Badges Coloridos -->
                            <td>
                                @php
                                    $badgeClass = match($user->perfil) {
                                        'Admin' => 'bg-admin',
                                        'Recepcionista' => 'bg-recep',
                                        'Veterinário' => 'bg-vet',
                                        'Investidor' => 'bg-invest',
                                        default => 'bg-client',
                                    };
                                @endphp
                                <span class="badge badge-custom {{ $badgeClass }}">
                                    {{ $user->perfil }}
                                </span>
                            </td>

                            <td class="text-end text-nowrap"> <!-- text-nowrap evita quebra de linha -->
                                @if ($user->id !== Auth::id())
                                    
                                    <!-- 1. EDITAR (Sem o underline estranho) -->
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-icon icon-edit" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <!-- 2. LÓGICA DE SITUAÇÃO -->
                                    @if ($user->active)
                                        <!-- Se ATIVO -> Botão DESATIVAR -->
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon icon-ban" title="Desativar Conta" onclick="return confirm('Desativar este usuário?');">
                                                <i class="bi bi-slash-circle"></i>
                                            </button>
                                        </form>
                                    @else
                                        <!-- Se INATIVO -> Botão REATIVAR -->
                                        <form action="{{ route('admin.users.activate', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn-icon icon-check" title="Reativar Conta">
                                                <i class="bi bi-check-circle-fill"></i>
                                            </button>
                                        </form>

                                        <!-- Se INATIVO -> Botão EXCLUIR PERMANENTE -->
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon icon-trash" title="Excluir Permanentemente" onclick="return confirm('ISSO É IRREVERSÍVEL. Excluir permanentemente?');">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    @endif

                                @else
                                    <span class="text-muted small">--</span>
                                @endif
                            </td>

                            <td class="text-end">
                                @if ($user->active)
                                    <span class="status-active">Ativo</span>
                                @else
                                    <span class="status-inactive">Inativo</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 text-end">
            <a href="{{ route('admin.users.create') }}" class="btn btn-dark rounded-pill px-4">
                Criar Novo
            </a>
        </div>

    </div>

</body>
</html>