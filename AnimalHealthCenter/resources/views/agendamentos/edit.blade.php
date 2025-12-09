<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Agendamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #fcfaf6; font-family: 'Georgia', serif; }
        .form-card { background: white; padding: 2.5rem; border-radius: 12px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
        label { font-family: sans-serif; font-weight: 600; font-size: 0.9rem; color: #4a4a4a; margin-bottom: 0.4rem; }
        .form-control, .form-select { border-radius: 8px; padding: 0.6rem 1rem; border: 1px solid #e0e0e0; }
        .form-control:focus { border-color: #a78bfa; box-shadow: 0 0 0 0.2rem rgba(167, 139, 250, 0.25); }
        
        /* Botão Salvar Roxo */
        .btn-custom { background-color: #a78bfa; border-color: #a78bfa; color: white; font-family: sans-serif; font-weight: bold; border-radius: 8px; }
        .btn-custom:hover { background-color: #9061f9; color: white; }
        
        /* Botão Cancelar Vermelho (Ajuste Solicitado) */
        .btn-cancel { 
            color: #dc3545; 
            border: 1px solid #dc3545; 
            background: white;
            font-family: sans-serif; 
            font-weight: bold; 
            border-radius: 8px; 
        }
        .btn-cancel:hover { background-color: #dc3545; color: white; }

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
                </div>
                <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="btn btn-danger btn-sm">Sair</button></form>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <a href="{{ route('agendamentos.index') }}" class="link-back">Voltar para Agenda</a>
                <h2 class="mb-4 text-center" style="font-family: sans-serif;">Editar Agendamento</h2>

                <div class="form-card">
                    <form action="{{ route('agendamentos.update', $agendamento->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label>Paciente (Pet)</label>
                            <select name="pet_id" class="form-select" required>
                                @foreach ($pets as $pet)
                                    <option value="{{ $pet->id }}" {{ $agendamento->pet_id == $pet->id ? 'selected' : '' }}>
                                        {{ $pet->nome }} (Dono: {{ $pet->cliente->nome_completo }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Veterinário Responsável</label>
                            <select name="veterinario_id" class="form-select" required>
                                @foreach ($veterinarios as $vet)
                                    <option value="{{ $vet->id }}" {{ $agendamento->veterinario_id == $vet->id ? 'selected' : '' }}>
                                        Dr(a). {{ $vet->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Data e Hora</label>
                                <input type="datetime-local" name="data_hora" class="form-control" value="{{ $agendamento->data_hora->format('Y-m-d\TH:i') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label>Status</label>
                                <select name="status" class="form-select">
                                    <option value="Agendado" {{ $agendamento->status == 'Agendado' ? 'selected' : '' }}>Agendado</option>
                                    <option value="Concluído" {{ $agendamento->status == 'Concluído' ? 'selected' : '' }}>Concluído</option>
                                    <option value="Cancelado" {{ $agendamento->status == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Tipo</label>
                            <select name="tipo" class="form-select" required>
                                <option value="Consulta" {{ $agendamento->tipo == 'Consulta' ? 'selected' : '' }}>Consulta</option>
                                <option value="Vacina" {{ $agendamento->tipo == 'Vacina' ? 'selected' : '' }}>Vacina</option>
                                <option value="Cirurgia" {{ $agendamento->tipo == 'Cirurgia' ? 'selected' : '' }}>Cirurgia</option>
                                <option value="Retorno" {{ $agendamento->tipo == 'Retorno' ? 'selected' : '' }}>Retorno</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label>Observações</label>
                            <textarea name="observacoes" class="form-control" rows="3">{{ $agendamento->observacoes }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between pt-2">
                            <!-- Botão Cancelar Vermelho -->
                            <a href="{{ route('agendamentos.index') }}" class="btn btn-cancel px-4">Cancelar</a>
                            <!-- Botão Salvar Roxo -->
                            <button type="submit" class="btn btn-custom px-4">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>