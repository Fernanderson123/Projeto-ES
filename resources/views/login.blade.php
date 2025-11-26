<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Animal Health Center</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #fcfaf6;">

    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="col-md-4">

            <h1 class="text-center mb-4" style="font-family: Georgia, serif; font-size: 2.5rem;">
                Animal Health Center 🐾
            </h1>

            <div class="card shadow-sm border-dark">
                <div class="card-body p-4">
                    <h5 class="card-title text-center mb-3">Login</h5>
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Erro!</strong> {{ $errors->first('email') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <form action="{{ route('login') }}" method="POST"></form>
                    <form action="{{ route('login') }}" method="POST">

                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Usuário</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn text-white" style="background-color: #a78bfa;">
                                Login
                            </button>
                        </div>

                    </form>
                    <div class="text-center mt-4">
                            <a href="{{ route('password.request') }}" class="text-decoration-none text-muted d-block mb-2">
                                Esqueceu a senha?
                            </a>
                            <a href="{{ route('register.show') }}" class="text-decoration-none">
                                Registrar
                            </a>
                        </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>