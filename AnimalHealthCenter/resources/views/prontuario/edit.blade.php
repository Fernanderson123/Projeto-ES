<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Prontuário - Animal Health Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #fcfaf6; font-family: 'Georgia', serif; }
        .form-card { background: white; padding: 2.5rem; border-radius: 12px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
        label { font-family: sans-serif; font-weight: 600; font-size: 0.9rem; color: #4a4a4a; margin-bottom: 0.4rem; }
        .form-control, .form-select { border-radius: 8px; padding: 0.6rem 1rem; border: 1px solid #e0e0e0; }
        .form-control:focus { border-color: #a78bfa; box-shadow: 0 0 0 0.2rem rgba(167, 139, 250, 0.25); }
        .btn-custom { background-color: #a78bfa; border-color: #a78bfa; color: white; font-family: sans-serif; font-weight: bold; border-radius: 8px; }
        .btn-custom:hover { background-color: #9061f9; color: white; }
        .link-back { color: #1a1a1a; text-decoration: none; font-family: sans-serif; font-weight: 600; display: inline-flex; align-items: center; margin-bottom: 1rem; }
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
                    <div class="small text-muted">Perfil: <strong class="text-dark">{{ Auth::user()->perfil }}</strong></div>
                </div>
                <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="btn btn-danger btn-sm">Sair</button></form>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <a href="{{ route('prontuario.index') }}" class="link-back"><i class="bi bi-arrow-left me-2"></i> Voltar para Histórico</a>
                <h2 class="mb-4 text-center">Editar Prontuário</h2>

                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 border-0 mb-4">
                        <ul class="mb-0"> @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach </ul>
                    </div>
                @endif

                <div class="form-card">
                    <form action="{{ route('prontuario.update', $prontuario->id) }}" method="POST">
                        @csrf @method('PUT')
                        
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <label>Paciente (Pet)</label>
                                <select name="pet_id" class="form-select" required>
                                    @foreach ($pets as $pet)
                                        <option value="{{ $pet->id }}" {{ $prontuario->pet_id == $pet->id ? 'selected' : '' }}>
                                            {{ $pet->nome }} ({{ $pet->especie }}) - Tutor: {{ $pet->cliente->nome_completo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Data do Atendimento</label>
                                <input type="date" name="data_atendimento" class="form-control" value="{{ $prontuario->data_atendimento->format('Y-m-d') }}" required>
                            </div>
                        </div>

                        <h5 class="border-bottom pb-2 mb-3" style="font-family: sans-serif;">Anamnese e Exame Físico</h5>
                        
                        <div class="mb-3">
                            <label>Sintomas / Queixa Principal</label>
                            <textarea name="sintomas" class="form-control" rows="3" required>{{ $prontuario->sintomas }}</textarea>
                        </div>

                        <h5 class="border-bottom pb-2 mb-3 mt-4" style="font-family: sans-serif;">Avaliação Médica</h5>

                        <div class="mb-3">
                            <label>Diagnóstico</label>
                            <textarea name="diagnostico" class="form-control" rows="2">{{ $prontuario->diagnostico }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label>Tratamento / Prescrição</label>
                            <textarea name="tratamento" class="form-control" rows="3">{{ $prontuario->tratamento }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label>Observações Adicionais</label>
                            <textarea name="observacoes" class="form-control" rows="2">{{ $prontuario->observacoes }}</textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-custom py-2 fs-5">Salvar Alterações</button>
                            <a href="{{ route('prontuario.index') }}" class="btn btn-light border text-muted text-center">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>