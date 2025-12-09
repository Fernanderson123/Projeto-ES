<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - Animal Health Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #fcfaf6; font-family: 'Georgia', serif; }
        .card-custom { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .btn-custom { background-color: #a78bfa; border-color: #a78bfa; color: white; font-weight: bold; font-family: sans-serif; }
        .btn-custom:hover { background-color: #9061f9; color: white; }
    </style>
</head>
<body class="d-flex align-items-center min-vh-100">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="text-center mb-4">
                    <h2 style="font-family: 'Georgia', serif; font-weight: bold; color: #1a1a1a;">Animal Health Center 🐾</h2>
                </div>

                <div class="card card-custom p-4 bg-white">
                    <h4 class="text-center mb-3" style="font-family: sans-serif;">Esqueceu sua senha?</h4>
                    <p class="text-muted text-center small mb-4" style="font-family: sans-serif;">
                        Digite seu e-mail abaixo e enviaremos um link para você redefinir sua senha.
                    </p>

                    @if (session('status'))
                        <div class="alert alert-success border-0 text-center small mb-3">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label" style="font-family: sans-serif; font-weight: 600; font-size: 0.9rem;">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-custom py-2">Enviar Link de Redefinição</button>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-decoration-none text-muted small fw-bold" style="font-family: sans-serif;">
                                <i class="bi bi-arrow-left"></i> Voltar para o Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>