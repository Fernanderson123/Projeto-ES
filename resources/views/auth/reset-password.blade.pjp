<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha - Animal Health Center</title>
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
                <div class="card card-custom p-4 bg-white">
                    <h4 class="text-center mb-4" style="font-family: sans-serif;">Nova Senha</h4>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="email" class="form-label" style="font-family: sans-serif; font-weight: 600;">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $email ?? old('email') }}" required readonly>
                            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label" style="font-family: sans-serif; font-weight: 600;">Nova Senha</label>
                            <input type="password" class="form-control" id="password" name="password" required autofocus>
                            @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label" style="font-family: sans-serif; font-weight: 600;">Confirmar Nova Senha</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-custom py-2">Redefinir Senha</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>