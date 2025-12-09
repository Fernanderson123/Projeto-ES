<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #fcfaf6; font-family: 'Georgia', serif; }
        .form-card { background: white; padding: 2rem; border-radius: 8px; border: none; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4" style="font-family: sans-serif;">Editar Usuário</h2>
        
        <div class="col-md-6 form-card">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Perfil</label>
                    <select name="perfil" class="form-select">
                        <option value="Recepcionista" {{ $user->perfil == 'Recepcionista' ? 'selected' : '' }}>Recepcionista</option>
                        <option value="Veterinário" {{ $user->perfil == 'Veterinário' ? 'selected' : '' }}>Veterinário</option>
                        <option value="Investidor" {{ $user->perfil == 'Investidor' ? 'selected' : '' }}>Investidor</option>
                        <option value="Admin" {{ $user->perfil == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Cliente" {{ $user->perfil == 'Cliente' ? 'selected' : '' }}>Cliente</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nova Senha (Opcional)</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <button type="submit" class="btn btn-dark rounded-pill px-4">Salvar</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-link text-dark">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>