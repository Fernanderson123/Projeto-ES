<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- ADICIONE ESTE ESTILO PARA O BADGE ROXO -->
    <style>
        .badge-purple {
            background-color: #6f42c1;
            /* Cor roxa (índigo) do Bootstrap */
            color: white;
        }
    </style>
</head>

<body style="background-color: #fcfaf6;">

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}" style="font-family: Georgia, serif;">
                Animal Health Center (Admin)
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">Sair</button>
            </form>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="mb-4">Gerenciamento de Usuários</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Perfil</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="align-middle">
                                    @php
                                        $badgeClass = 'bg-secondary'; // Padrão (Cliente)

                                        switch ($user->perfil) {
                                            case 'Admin':
                                                $badgeClass = 'bg-primary'; // Azul
                                                break;
                                            case 'Veterinário':
                                                $badgeClass = 'bg-success'; // Verde
                                                break;
                                            case 'Investidor':
                                                $badgeClass = 'bg-warning text-dark'; // Laranja
                                                break;
                                            case 'Recepcionista':
                                                $badgeClass = 'badge-purple'; // Nossa classe Roxo
                                                break;
                                        }
                                    @endphp

                                    <span class="badge {{ $badgeClass }}">
                                        {{ $user->perfil }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    @if ($user->id !== Auth::id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Excluir
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small">(Sua conta)</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>