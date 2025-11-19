<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meu Perfil - Animal Health Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #fcfaf6; font-family: 'Georgia', serif; }
        .card-custom { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
        .form-label { font-family: sans-serif; font-weight: bold; color: #4a4a4a; }
    </style>
</head>
<body>
    
    <!-- Navbar Simples para Voltar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent pt-4 px-5">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}" style="font-family: sans-serif; font-weight: bold; font-size: 1.1rem;">
                <i class="bi bi-arrow-left-circle me-2"></i> Voltar ao Dashboard
            </a>
            <span class="navbar-text fw-bold" style="font-family: 'Georgia', serif; font-size: 1.5rem;">Animal Health Center</span>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                
                <h2 class="mb-4 text-center">Editar Meu Perfil</h2>

                @if (session('success'))
                    <div class="alert alert-success border-0 mb-4">{{ session('success') }}</div>
                @endif
                
                @if ($errors->any())
                    <div class="alert alert-danger border-0 mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card card-custom bg-white p-4">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nome</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Perfil (Cargo)</label>
                            <input type="text" class="form-control" value="{{ $user->perfil }}" disabled readonly style="background-color: #f8f9fa;">
                            <small class="text-muted">Para alterar seu cargo, contate um administrador.</small>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3" style="font-family: sans-serif; font-size: 1.1rem;">Alterar Senha</h5>
                        
                        <div class="mb-3">
                            <label class="form-label">Nova Senha</label>
                            <input type="password" name="password" class="form-control" placeholder="Deixe em branco para manter a atual">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Confirmar Nova Senha</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Repita a nova senha">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success py-2">Salvar Alterações</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</body>
</html>