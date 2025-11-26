<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Novo Agendamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #fcfaf6; font-family: 'Georgia', serif; }
        .form-card { background: white; padding: 2.5rem; border-radius: 12px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
        .btn-custom { background-color: #a78bfa; color: white; font-weight: bold; border-radius: 8px; border: none; }
        .btn-custom:hover { background-color: #9061f9; color: white; }
        .navbar-brand { color: #1a1a1a !important; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-5">
        <div class="container-fluid mx-5">
            <a class="navbar-brand" href="{{ route('dashboard') }}" style="font-family: Georgia, serif; font-size: 1.5rem;">Animal Health Center 🐾</a>
            <div class="d-flex align-items-center">
                <div class="text-end me-3">
                    <a class="small text-muted text-decoration-none" href="{{ route('profile.edit') }}">Bem vindo(a) <strong class="text-dark">{{ Auth::user()->name }}</strong></a>
                </div>
                <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="btn btn-danger btn-sm">Sair</button></form>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="mb-4 text-center" style="font-family: sans-serif;">Novo Agendamento</h2>
                <div class="form-card">
                    <form action="{{ route('agendamentos.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Paciente (Pet)</label>
                            <select name="pet_id" class="form-select" required>
                                <option value="" selected disabled>Selecione...</option>
                                @foreach ($pets as $pet)
                                    <option value="{{ $pet->id }}">{{ $pet->nome }} (Dono: {{ $pet->cliente->nome_completo }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Veterinário</label>
                            <select name="veterinario_id" class="form-select" required>
                                <option value="" selected disabled>Selecione...</option>
                                @foreach ($veterinarios as $vet)
                                    <option value="{{ $vet->id }}">Dr(a). {{ $vet->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Data e Hora</label>
                                <input type="datetime-local" name="data_hora" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tipo</label>
                                <select name="tipo" class="form-select" required>
                                    <option value="Consulta">Consulta</option>
                                    <option value="Vacina">Vacina</option>
                                    <option value="Cirurgia">Cirurgia</option>
                                    <option value="Retorno">Retorno</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-custom py-2">Agendar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>