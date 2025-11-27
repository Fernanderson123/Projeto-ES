<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Novo Usuário - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body style="background-color: #fcfaf6;">

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.users.index') }}" style="font-family: Georgia, serif;">
                <i class="bi bi-arrow-left-circle me-2"></i>Voltar para Gerenciar
            </a>
            <span class="navbar-text" style="font-family: Georgia, serif;">Animal Health Center</span>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h4 class="mb-0" style="font-family: Georgia, serif;">Criar Novo Usuário</h4>
                    </div>
                    <div class="card-body">
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.users.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Nome Completo</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Senha</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Perfil de Acesso</label>
                                <select name="perfil" class="form-select" required>
                                    <option value="" selected disabled>Selecione...</option>
                                    <option value="Recepcionista">Recepcionista</option>
                                    <option value="Veterinário">Veterinário</option>
                                    <option value="Investidor">Investidor</option>
                                    <option value="Admin">Administrador</option>
                                    <option value="Cliente">Cliente (Padrão)</option>
                                </select>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Criar Usuário</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>